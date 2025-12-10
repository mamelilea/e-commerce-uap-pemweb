<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\StoreBalance;
use Illuminate\Support\Facades\Auth;

class StoreWithdrawalController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->back()->with('error', 'Kamu belum memiliki toko.');
        }

        // Pastikan saldo toko ada — kalau tidak, buat otomatis
        $balance = $store->storeBalance;

        if (!$balance) {
            $balance = StoreBalance::create([
                'store_id' => $store->id,
                'balance' => 0
            ]);
        }

        // Ambil riwayat penarikan
        $withdrawals = $balance->withdrawals()->latest()->get();

        return view('toko.saldo.withdraw', compact('store', 'balance', 'withdrawals'));
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
            'bank_name' => 'required|string|max:100',
        ]);

        $store = Auth::user()->store;
        $balance = $store->storeBalance;

        // Jika belum ada balance, buat otomatis
        if (!$balance) {
            $balance = StoreBalance::create([
                'store_id' => $store->id,
                'balance' => 0
            ]);
        }

        // Cek saldo cukup
        if ($request->amount > $balance->balance) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        // Buat record penarikan
        Withdrawal::create([
            'store_balance_id' => $balance->id,
            'amount' => $request->amount,
            'bank_account_name' => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_name' => $request->bank_name,
            'status' => 'pending',
        ]);

        // Kurangi saldo
        $balance->update([
            'balance' => $balance->balance - $request->amount,
        ]);

        return back()->with('success', 'Penarikan berhasil diajukan. Menunggu verifikasi admin.');
    }
}
