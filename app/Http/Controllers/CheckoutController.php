<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart()->with(['cartItems.product.productImages', 'cartItems.product.store'])->first();

        if (!$cart || $cart->cartItems->count() == 0) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong.');
        }

        foreach ($cart->cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart')
                    ->with('error', 'Stok produk "' . $item->product->name . '" tidak mencukupi.');
            }
        }

        $shippingCost = 10000;

        return view('checkout', compact('cart', 'shippingCost'));
    }

    public function process(Request $request)
    {
        // Validasi sesuai dengan field di form
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'shipping_method' => 'required|string|in:JNE,JNT,SiCepat',
            'payment_method' => 'required|string|in:COD,Transfer Bank,E-Wallet',
            'notes' => 'nullable|string',
        ]);

        $cart = Auth::user()->cart()->with('cartItems.product')->first();

        if (!$cart || $cart->cartItems->count() == 0) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong.');
        }

        // Validasi stok
        foreach ($cart->cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart')
                    ->with('error', 'Stok produk "' . $item->product->name . '" tidak mencukupi.');
            }
        }

        DB::beginTransaction();
        try {
            // Group cart items by store
            $itemsByStore = $cart->cartItems->groupBy('product.store_id');

            $transactionIds = [];

            // Hitung biaya kirim berdasarkan metode pengiriman
            $shippingCosts = [
                'JNE' => 15000,
                'JNT' => 12000,
                'SiCepat' => 10000,
            ];

            foreach ($itemsByStore as $storeId => $items) {
                $shippingCost = $shippingCosts[$request->shipping_method];
                $tax = 0;
                $subtotal = $items->sum(function($item) {
                    return $item->price * $item->quantity;
                });
                $grandTotal = $subtotal + $shippingCost + $tax;

                // Gabungkan alamat lengkap
                $fullAddress = $request->shipping_address . ', ' . 
                              $request->city . ', ' . 
                              $request->province . ' ' . 
                              $request->postal_code;

                // Create transaction for each store
                $transaction = Transaction::create([
                    'code' => 'TRX-' . strtoupper(Str::random(10)),
                    'user_id' => Auth::id(),
                    'store_id' => $storeId,
                    'address' => $fullAddress,
                    'address_id' => 'ADDR-' . strtoupper(Str::random(8)), // Generate address_id
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'shipping' => $request->shipping_method, // JNE/JNT/SiCepat
                    'shipping_type' => 'REG', // Default REG
                    'shipping_cost' => $shippingCost,
                    'tracking_number' => null,
                    'tax' => $tax,
                    'grand_total' => $grandTotal,
                    'payment_status' => 'unpaid',
                ]);

                // Simpan detail transaksi
                foreach ($items as $item) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item->product_id,
                        'qty' => $item->quantity,
                        'subtotal' => $item->price * $item->quantity,
                    ]);

                    // Kurangi stok produk
                    $item->product->decrement('stock', $item->quantity);
                }

                $transactionIds[] = $transaction->id;
            }

            // Kosongkan keranjang
            $cart->cartItems()->delete();

            DB::commit();

            // Redirect ke halaman success dengan data transaksi pertama
            return redirect()->route('checkout.success', ['transaction' => $transactionIds[0]])
                ->with('success', 'Checkout berhasil! Pesanan Anda sedang diproses.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function success($transactionId)
    {
        $transaction = Transaction::with(['transactionDetails.product', 'store'])
            ->where('user_id', Auth::id())
            ->findOrFail($transactionId);
            
        return view('CheckoutSuccess', compact('transaction'));
    }
}