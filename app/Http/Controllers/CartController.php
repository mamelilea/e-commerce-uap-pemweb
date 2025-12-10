<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Tampilkan isi keranjang
    public function index()
    {
        $cart = session('cart', []); // [product_id => quantity]

        if (empty($cart)) {
            return view('cart.index', [
                'items' => collect(),
                'total' => 0,
            ]);
        }

        $products = Product::with(['productImages', 'store'])
            ->whereIn('id', array_keys($cart))
            ->get();

        $items = $products->map(function ($product) use ($cart) {
            $qty = $cart[$product->id] ?? 0;
            $subtotal = $product->price * $qty;

            return [
                'product'  => $product,
                'qty'      => $qty,
                'subtotal' => $subtotal,
            ];
        });

        $total = $items->sum('subtotal');

        return view('cart.index', compact('items', 'total'));
    }

    // Tambah produk ke keranjang
    public function add(Request $request, Product $product)
    {
        $qty = (int) $request->input('qty', 1);
        if ($qty < 1) {
            $qty = 1;
        }

        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id] += $qty;
        } else {
            $cart[$product->id] = $qty;
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Produk "' . $product->name . '" ditambahkan ke keranjang.');
    }

    // 🔁 Update jumlah satu produk di keranjang
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);

        if (! isset($cart[$product->id])) {
            return back()->with('error', 'Produk tidak ada di keranjang.');
        }

        $cart[$product->id] = $data['qty'];
        session(['cart' => $cart]);

        return back()->with('success', 'Jumlah produk diperbarui.');
    }

    // Hapus satu produk dari keranjang
    public function remove(Product $product)
    {
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Produk "' . $product->name . '" dihapus dari keranjang.');
    }

    // Kosongkan keranjang
    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Keranjang telah dikosongkan.');
    }
}
