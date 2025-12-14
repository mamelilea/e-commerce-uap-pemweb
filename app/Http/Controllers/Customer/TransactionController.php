<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Buyer;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{

    public function show(Product $product)
    {
        return view('customer.transaction', compact('product'));

    }



    public function process(Request $request)
    {
        $request->validate([

            'fullname' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'shipping_type' => 'required|string|in:reguler,express,same_day',
            'store_id' => 'required|integer|exists:stores,id',
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        if (!$user->buyer) {
            Buyer::create(['user_id' => $user->id]);
            $user->refresh();
        }
        $buyerId = $user->buyer->id;

        $transactionCode = 'TRX-' . Str::upper(Str::random(8));

        $shippingCosts = [
            'reguler' => 10000,
            'express' => 20000,
            'same_day' => 30000,
        ];

        $shippingCost = $shippingCosts[$request->shipping_type] ?? 0;

        
        $product = Product::findOrFail($request->product_id);
        $subtotal = $product->price * $request->quantity;

        $tax = $subtotal * 0.11; 
        $serviceFee = 2000;

        $grandTotal = $subtotal + $shippingCost + $tax + $serviceFee;

        $transaction = Transaction::create([
            'code' => $transactionCode,
            'buyer_id' => $buyerId,
            'store_id' => $request->store_id,
            'address' => $request->address,
            'address_id' => '',
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'shipping' => $request->shipping_type,
            'shipping_type' => $request->shipping_type,
            'shipping_cost' => $shippingCost,
            'tracking_number' => null,
            'tax' => $tax,
            'grand_total' => $grandTotal,
            'payment_status' => 'unpaid',
        ]);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $request->product_id,
            'qty' => $request->quantity,
            'subtotal' => $subtotal,
        ]);

        return redirect()->route('transaction.detail', $transaction->id)
        ->with('success', 'Transaksi berhasil diproses!');

    }

    public function detail(Transaction $transaction)
    {

    $transaction->load(['transactionDetails.product', 'store', 'buyer']);
    return view('customer.transaction_detail', compact('transaction'));

    }

    public function confirm(Transaction $transaction)
    {

        return redirect()->route('transaction.history')->with('success', 'Pembayaran dikonfirmasi. Silakan tunggu verifikasi.');
    }

    public function complete(Transaction $transaction)
    {
        if ($transaction->delivery_status !== 'shipped') {
            return redirect()->back()->with('error', 'Pesanan belum dikirim.');
        }

        $transaction->update([
            'delivery_status' => 'success'
        ]);

        return redirect()->back()->with('success', 'Terima kasih! Pesanan telah diterima.');
    }

    public function storeReview(Request $request, Transaction $transaction)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500',
        ]);

        \App\Models\ProductReview::create([
            'transaction_id' => $transaction->id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil dikirim!');
    }

    public function checkScanStatus(Transaction $transaction)
    {
        // Simulate checking with payment gateway/QR provider
        if (!session()->has('scan_start_' . $transaction->id)) {
            session(['scan_start_' . $transaction->id => now()]);
            return response()->json(['scanned' => false]);
        }
        
        $startTime = session('scan_start_' . $transaction->id);
        
        // Simulate a 5-8 second delay for "detection"
        if (now()->diffInSeconds($startTime) > 10) {
            return response()->json(['scanned' => true]);
        }

        return response()->json(['scanned' => false]);
    }

    public function uploadProof(Request $request, Transaction $transaction)
    {
        $request->validate([
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('proof_of_payment')) {
            $path = $request->file('proof_of_payment')->store('payment_proofs', 'public');
            
            $transaction->update([
                'proof_of_payment' => $path,
            ]);
            
            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload. Mohon tunggu verifikasi admin.');
        }

        return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran.');
    }

    public function history()
    {

        $user = Auth::user();

        if (!$user->buyer) {
             return redirect()->route('customer.home'); 
        }

        $transactions = Transaction::where('buyer_id', $user->buyer->id)
            ->with(['transactionDetails.product', 'store'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('customer.transaction_history', compact('transactions'));

    }
}
