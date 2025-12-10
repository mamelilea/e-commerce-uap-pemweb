<?php

namespace App\Http\Controllers;

use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class SellerWithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $user  = $request->user();
        $store = $user->store()->with('balance.withdrawals')->firstOrFail();

        $balance = $store->balance;

        if (!$balance) {
            $balance = StoreBalance::create([
                'store_id' => $store->id,
                'balance'  => 0,
            ]);

            $store->setRelation('balance', $balance);
        }

        $withdrawals  = $balance->withdrawals()->where('amount', '>', 0)->orderByDesc('created_at')->get();
        $bankAccounts = $balance->withdrawals()->where('amount', 0)->orderByDesc('created_at')->get();
        return view('seller.withdrawals.index', compact('store', 'balance', 'withdrawals', 'bankAccounts'));
    }

    public function store(Request $request)
    {
        $user  = $request->user();
        $store = $user->store()->with('balance')->firstOrFail();
        $balance = $store->balance;

        if (!$balance) {
            $balance = StoreBalance::create([
                'store_id' => $store->id,
                'balance'  => 0,
            ]);

            $store->setRelation('balance', $balance);
        }

        $data = $request->validate([
            'amount'          => 'required|numeric|min:1',
            'bank_account_id' => 'required|exists:withdrawals,id',
        ]);

        if ($data['amount'] > $balance->balance) {
            return back()
                ->withErrors(['amount' => 'Saldo toko tidak mencukupi untuk penarikan.'])
                ->withInput();
        }
        
        $bankAccount = Withdrawal::where('id', $data['bank_account_id'])
            ->where('store_balance_id', $balance->id)
            ->where('amount', 0)
            ->firstOrFail();

        $withdrawalData = [
            'amount'              => $data['amount'],
            'bank_account_name'   => $bankAccount->bank_account_name,
            'bank_account_number' => $bankAccount->bank_account_number,
            'bank_name'           => $bankAccount->bank_name,
            'store_balance_id'    => $balance->id,
            'status'              => 'pending',
        ];

        $withdrawal = Withdrawal::create($withdrawalData);
        $balance->decrement('balance', $data['amount']);

        StoreBalanceHistory::create([
            'store_balance_id' => $balance->id,
            'type'             => 'withdraw',
            'reference_id'     => $withdrawal->id,
            'reference_type'   => Withdrawal::class,
            'amount'           => -$data['amount'],
            'remarks'          => 'Pengajuan penarikan saldo',
        ]);

        return redirect()
            ->route('seller.withdrawals.index')
            ->with('success', 'Pengajuan penarikan dana berhasil diajukan.');
    }
}