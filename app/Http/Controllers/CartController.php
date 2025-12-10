<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartSession = session()->get('cart', []);
        $productIds = array_keys($cartSession);
        
        $products = Product::with(['productImages', 'store', 'productCategory'])
            ->whereIn('id', $productIds)
            ->get();

        $carts = $products->map(function ($product) use ($cartSession) {
            return [
                'id' => $product->id,
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'qty' => $cartSession[$product->id],
                'product' => $product,
            ];
        });

        $continueUrl = route('products.list');
        if (!empty($productIds)) {
            $lastId = end($productIds);
            $lastProduct = $products->firstWhere('id', $lastId);
            
            if ($lastProduct && $lastProduct->productCategory) {
                $continueUrl = route('products.list', ['category' => $lastProduct->productCategory->slug]);
            }
        }

        return Inertia::render('Cart/Index', [
            'carts' => $carts->values(),
            'continueUrl' => $continueUrl
        ]);
    }

    public function store(Request $request)
    {
        $id = $request->product_id;
        $qty = $request->qty;

        $product = Product::find($id);
        
        if (!$product || $product->stock < $qty) {
            return back()->withErrors(['qty' => 'Stok tidak mencukupi.']);
        }

        $user = Auth::user();
        if ($user && $user->store && $product->store_id === $user->store->id) {
            return back()->withErrors(['qty' => 'Anda tidak dapat membeli produk dari toko Anda sendiri.']);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id] += $qty;
        } else {
            $cart[$id] = $qty;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk masuk keranjang!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::find($id);

            if ($request->type === 'plus') {
                if ($cart[$id] < $product->stock) {
                    $cart[$id]++;
                }
            } elseif ($request->type === 'minus') {
                if ($cart[$id] > 1) {
                    $cart[$id]--;
                }
            }
            
            session()->put('cart', $cart);
        }

        return back();
    }

    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}