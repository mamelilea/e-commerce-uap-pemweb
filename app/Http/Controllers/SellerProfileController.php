<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreBalance;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class SellerProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        $store = $user->store()
            ->with(['balance.withdrawals' => function ($q) {
                $q->where('amount', 0)->orderByDesc('created_at');
            }])->firstOrFail();

        $balance = $store->balance;

        return view('seller.profile', compact('store', 'balance'));
    }

    public function updateStore(Request $request)
    {
        $user  = $request->user();
        $store = $user->store()->firstOrFail();

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'logo'        => 'nullable|image|max:2048',
            'about'       => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'city'        => 'nullable|string|max:255',
            'address'     => 'nullable|string',
            'postal_code' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('logo')) {
            $path        = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }

        $store->update($data);

        return back()->with('success', 'Profil toko berhasil diperbarui.');
    }

    public function storeBank(Request $request)
    {
        $user  = $request->user();
        $store = $user->store()->with('balance')->firstOrFail();
        $balance = $store->balance;

        if (!$balance) {
            $balance = StoreBalance::create([
                'store_id' => $store->id,
                'balance'  => 0,
            ]);
        }

        $data = $request->validate([
            'bank_account_name'   => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
            'bank_name'           => 'required|string|max:255',
        ]);

        $data['store_balance_id'] = $balance->id;
        $data['amount']           = 0;
        $data['status']           = 'pending';

        Withdrawal::create($data);

        return back()->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    public function updateBank(Request $request, Withdrawal $withdrawal)
    {
        $this->authorizeBank($request, $withdrawal);

        $data = $request->validate([
            'bank_account_name'   => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
            'bank_name'           => 'required|string|max:255',
        ]);

        $withdrawal->update($data);

        return back()->with('success', 'Rekening bank berhasil diupdate.');
    }

    public function destroyBank(Request $request, Withdrawal $withdrawal)
    {
        $this->authorizeBank($request, $withdrawal);

        $withdrawal->delete();

        return back()->with('success', 'Rekening bank berhasil dihapus.');
    }

    protected function authorizeBank(Request $request, Withdrawal $withdrawal)
    {
        $userStoreId = $request->user()->store->id ?? null;

        if (!$userStoreId || $withdrawal->storeBalance->store_id !== $userStoreId) {
            abort(403);
        }
    }
}
