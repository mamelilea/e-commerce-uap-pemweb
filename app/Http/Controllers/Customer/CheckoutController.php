<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    // Halaman Checkout
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang belanja kosong! 🛒');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('customer.checkout', compact('cart', 'subtotal'));
    }

    // Proses Checkout

    private function calculateShipping($shippingType)
    {
        switch ($shippingType) {
            case 'regular':
                return 10000; // biaya ongkir reguler
            case 'express':
                return 20000; // biaya ongkir express
            case 'same_day':
                return 30000; // pengiriman di hari yang sama
            default:
                return 0;
        }
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_type'    => 'required|in:regular,express,same_day',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();

        try {
            // Hitung subtotal
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            // Hitung ongkir
            $shippingCost = $this->calculateShipping($request->shipping_type);
            $totalAmount  = $subtotal + $shippingCost;

            // Buat transaksi
            $transaction = Transaction::create([
                'user_id'          => Auth::id(),
                'transaction_code' => 'SC-' . strtoupper(Str::random(10)),
                'total_amount'     => $totalAmount,
                'shipping_address' => $request->shipping_address,
                'shipping_type'    => $request->shipping_type,
                'shipping_cost'    => $shippingCost,
                'status'           => 'pending',
            ]);

            // Buat detail transaksi & kurangi stok
            foreach ($cart as $productId => $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $productId,
                    'quantity'       => $item['quantity'],
                    'price'          => $item['price'],
                    'subtotal'       => $item['price'] * $item['quantity'],
                ]);

                // Kurangi stok
                $product = Product::find($productId);
                $product->decrement('stock', $item['quantity']);
            }

            // Hapus cart dari session
            session()->forget('cart');

            DB::commit();

            return redirect()->route('transaction.success', $transaction->id)
                ->with('success', 'Pesanan berhasil dibuat! 🎉');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
