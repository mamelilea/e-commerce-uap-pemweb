<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Tampilkan form checkout untuk satu produk
    public function start(Request $request, Product $product)
    {
        $product->load(['store', 'productImages', 'productCategory']);

        // qty bisa dikirim lewat query (?qty=2) atau default 1
        $qty = max(1, (int) $request->query('qty', 1));

        // opsi pengiriman dummy (bisa kamu ganti nanti)
        $shippingOptions = [
            [
                'code' => 'jne_reg',
                'name' => 'JNE Reguler',
                'type' => 'Reguler',
                'cost' => 15000,
            ],
            [
                'code' => 'jne_yes',
                'name' => 'JNE YES',
                'type' => 'Express',
                'cost' => 25000,
            ],
            [
                'code' => 'pos_kilat',
                'name' => 'POS Kilat',
                'type' => 'Ekonomis',
                'cost' => 10000,
            ],
        ];

        return view('checkout.index', [
            'product'         => $product,
            'qty'             => $qty,
            'shippingOptions' => $shippingOptions,
        ]);
    }

    // Proses checkout: simpan ke transactions + transaction_details
    public function process(Request $request, Product $product)
    {
        $product->load('store');

        $shippingOptions = collect([
            [
                'code' => 'jne_reg',
                'name' => 'JNE Reguler',
                'type' => 'Reguler',
                'cost' => 15000,
            ],
            [
                'code' => 'jne_yes',
                'name' => 'JNE YES',
                'type' => 'Express',
                'cost' => 25000,
            ],
            [
                'code' => 'pos_kilat',
                'name' => 'POS Kilat',
                'type' => 'Ekonomis',
                'cost' => 10000,
            ],
        ]);

        $data = $request->validate([
            'qty'             => 'required|integer|min:1',
            'address'         => 'required|string|max:1000',
            'city'            => 'required|string|max:255',
            'postal_code'     => 'required|string|max:20',
            'shipping_option' => 'required|string',
        ]);

        // Cek stok
        if ($product->stock !== null && $data['qty'] > $product->stock) {
            return back()
                ->withInput()
                ->with('error', 'Stok produk tidak mencukupi.');
        }

        // Cari opsi pengiriman yang dipilih
        $selectedShipping = $shippingOptions->firstWhere('code', $data['shipping_option']);

        if (! $selectedShipping) {
            return back()
                ->withInput()
                ->with('error', 'Metode pengiriman tidak valid.');
        }

        $user = Auth::user();

        // Pastikan buyer profile ada (kalau belum, buat baru)
        $buyer = Buyer::firstOrCreate(
            ['user_id' => $user->id],
            ['phone_number' => null]
        );

        $qty       = $data['qty'];
        $subtotal  = $product->price * $qty;
        $shippingCost = $selectedShipping['cost'];
        $tax       = round($subtotal * 0.11, 2); // contoh PPN 11%
        $grandTotal = $subtotal + $shippingCost + $tax;

        DB::beginTransaction();

        try {
            // Buat transaksi
            $transaction = Transaction::create([
                'code'           => 'TRX-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4)),
                'buyer_id'       => $buyer->id,
                'store_id'       => $product->store_id,
                'address'        => $data['address'],
                'city'           => $data['city'],
                'postal_code'    => $data['postal_code'],
                'shipping'       => $selectedShipping['name'],
                'shipping_type'  => $selectedShipping['type'],
                'shipping_cost'  => $shippingCost,
                'tracking_number' => null,
                'tax'            => $tax,
                'grand_total'    => $grandTotal,
                'payment_status' => 'unpaid', // nanti bisa di-update setelah pembayaran
            ]);

            // Detail transaksi (produk yang dibeli)
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $product->id,
                'qty'            => $qty,
                'subtotal'       => $subtotal,
            ]);

            // Kurangi stok produk
            if ($product->stock !== null) {
                $product->decrement('stock', $qty);
            }

            DB::commit();

            return redirect()
                ->route('orders.show', $transaction)
                ->with('success', 'Checkout berhasil! Pesananmu sudah tercatat.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses checkout. Silakan coba lagi.');
        }
    }
}
