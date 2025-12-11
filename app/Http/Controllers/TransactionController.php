<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Hanya user yang login bisa akses
    public function __construct()
    {
        // $this->middleware('auth');
    }

    // Fungsi tampilkan riwayat transaksi
    public function index()
    {
        // Ambil semua transaksi user yang login
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('transactionDetails.product.productImages')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Tampilkan view
        return view('customer.transaction-history', compact('transactions'));
    }

    // Fungsi tampilkan detail 1 transaksi
    public function show($id)
    {
        // Ambil transaksi berdasarkan ID
        $transaction = Transaction::where('user_id', Auth::id())
            ->with('transactionDetails.product.productImages')
            ->findOrFail($id);
            
        // Tampilkan view detail
        return view('customer.transaction-detail', compact('transaction'));
    }

    // Fungsi halaman sukses setelah checkout
    public function success($id)
    {
        // Ambil transaksi berdasarkan ID
        $transaction = Transaction::where('user_id', Auth::id())
            ->findOrFail($id);
            
        // Tampilkan halaman sukses
        return view('customer.transaction-success', compact('transaction'));
    }
}