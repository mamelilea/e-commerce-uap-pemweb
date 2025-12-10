<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Buyer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function index(Request $request)
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Ambil produk yang dipilih dari parameter query
        $selectedProductIds = $request->input('products', []);
        
        // Jika tidak ada produk yang dipilih, redirect kembali ke cart
        if (empty($selectedProductIds)) {
            return redirect()->route('cart.index')->with('error', 'Please select at least one product to checkout');
        }
        
        // Filter cart hanya untuk produk yang dipilih
        $filteredCart = array_filter($cart, function($item, $productId) use ($selectedProductIds) {
            return in_array($productId, $selectedProductIds);
        }, ARRAY_FILTER_USE_BOTH);
        
        if (empty($filteredCart)) {
            return redirect()->route('cart.index')->with('error', 'Selected products not found in cart');
        }

        $subtotal = 0;
        foreach ($filteredCart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Simpan produk yang dipilih di session untuk proses checkout
        session(['checkout_products' => $selectedProductIds]);

        return view('checkout.index', compact('filteredCart', 'subtotal'));
    }

    /**
     * Proses checkout
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'shipping_type' => 'required|in:regular,express,same_day',
            'payment_method' => 'required|in:cod,bank_transfer,e_wallet,credit_card',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Ambil produk yang dipilih dari session
        $selectedProductIds = session('checkout_products', []);
        
        if (empty($selectedProductIds)) {
            return redirect()->route('cart.index')->with('error', 'No products selected for checkout');
        }
        
        // Filter cart hanya untuk produk yang dipilih
        $checkoutCart = array_filter($cart, function($item, $productId) use ($selectedProductIds) {
            return in_array($productId, $selectedProductIds);
        }, ARRAY_FILTER_USE_BOTH);
        
        if (empty($checkoutCart)) {
            return redirect()->route('cart.index')->with('error', 'Selected products not found in cart');
        }

        // Ambil atau buat profil buyer
        $buyer = Buyer::firstOrCreate(
            ['user_id' => auth()->id()],
            ['profile_picture' => null, 'phone_number' => null]
        );

        // Hitung biaya pengiriman berdasarkan tipe
        $shippingCosts = [
            'regular' => 10000,
            'express' => 25000,
            'same_day' => 50000,
        ];
        $shippingCost = $shippingCosts[$request->shipping_type];

        // Kelompokkan item cart berdasarkan toko
        $itemsByStore = [];
        foreach ($checkoutCart as $item) {
            $storeId = $item['store_id'];
            if (!isset($itemsByStore[$storeId])) {
                $itemsByStore[$storeId] = [];
            }
            $itemsByStore[$storeId][] = $item;
        }


        $createdTransactions = [];

        // Tentukan status pembayaran berdasarkan metode pembayaran
        // E-Wallet dan Credit Card adalah pembayaran instan, tandai sebagai 'paid'
        // COD dan Bank Transfer butuh konfirmasi manual, tetap sebagai 'unpaid'
        $paymentStatus = in_array($request->payment_method, ['e_wallet', 'credit_card']) 
            ? 'paid' 
            : 'unpaid';

        // Buat transaksi untuk setiap toko
        foreach ($itemsByStore as $storeId => $items) {
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $tax = $subtotal * 0.11; // Pajak 11%
            $grandTotal = $subtotal + $shippingCost + $tax;

            // Buat transaksi
            $transaction = Transaction::create([
                'code' => 'TRX-' . strtoupper(Str::random(10)),
                'buyer_id' => $buyer->id,
                'store_id' => $storeId,
                'address_id' => 1, // ID alamat placeholder
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'shipping' => 'JNE', // Kurir pengiriman placeholder
                'shipping_type' => $request->shipping_type,
                'shipping_cost' => $shippingCost,
                'tracking_number' => null,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'payment_status' => $paymentStatus,
                'payment_method' => $request->payment_method,
            ]);

            // Buat detail transaksi
            foreach ($items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // Kurangi stok produk
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            $createdTransactions[] = $transaction;
        }

        // Hapus hanya produk yang dipilih dari cart
        $cart = session('cart', []);
        foreach ($selectedProductIds as $productId) {
            unset($cart[$productId]);
        }
        session(['cart' => $cart]);
        
        // Bersihkan session checkout
        session()->forget('checkout_products');

        // Redirect ke halaman sukses dengan transaksi pertama
        return redirect()->route('checkout.success', $createdTransactions[0]->id)
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Tampilkan halaman sukses
     */
    public function success(Transaction $transaction)
    {
        // Pastikan user memiliki transaksi ini
        if ($transaction->buyer->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('transaction'));
    }
}
