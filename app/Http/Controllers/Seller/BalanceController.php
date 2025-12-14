<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use App\Models\Withdrawal;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    private function getStore()
    {
        return Auth::user()->store;
    }

    public function index()
    {
        $store = $this->getStore();
        if (!$store) {
            return redirect()->route('seller.store.register');
        }

        // Ensure balance record exists
        $balance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        // Fetch history (transactions + withdrawals)
        // We can fetch from StoreBalanceHistory if populated, but for now let's assume it might be empty if we just started tracking.
        // The requirements say "Tampilkan riwayat perubahan saldo".
        // We should check `store_balance_histories` table.
        // Assuming we need to show mixed history.
        
        $history = StoreBalanceHistory::where('store_balance_id', $balance->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('seller.balance.index', compact('store', 'balance', 'history'));
    }

    public function updateBank(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'bank_account_number' => 'required|numeric',
            'bank_account_name' => 'required|string|max:150',
        ]);

        $store = $this->getStore();
        $store->update([
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
        ]);

        return redirect()->back()->with('success', 'Informasi rekening berhasil diperbarui.');
    }

    public function withdraw()
    {
        $store = $this->getStore();
        $balance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        $withdrawals = Withdrawal::where('store_balance_id', $balance->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('seller.balance.withdraw', compact('store', 'balance', 'withdrawals'));
    }

    public function processWithdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|string',
            'bank_account_name' => 'required|string',
        ]);

        $store = $this->getStore();
        $balance = StoreBalance::where('store_id', $store->id)->firstOrFail();

        if ($request->amount > $balance->balance) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi.');
        }

        DB::transaction(function () use ($request, $balance) {
            // Deduct Balance
            $balance->decrement('balance', $request->amount);

            // Create Withdrawal Record
            $withdrawal = Withdrawal::create([
                'store_balance_id' => $balance->id,
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'bank_account_number' => $request->bank_account_number,
                'bank_account_name' => $request->bank_account_name,
                'status' => 'pending',
            ]);

            // Create History Record
            StoreBalanceHistory::create([
                'store_balance_id' => $balance->id,
                'type' => 'withdraw',
                'reference_id' => Str::uuid(), // Providing a UUID as per schema requirement
                'reference_type' => 'App\Models\Withdrawal',
                'amount' => $request->amount,
                'remarks' => 'Penarikan Dana ke ' . $request->bank_name,
            ]);
        });

        return redirect()->back()->with('success', 'Permintaan penarikan berhasil diajukan.');
    }
}
