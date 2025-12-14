<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        } else {
            $sessionCart = Session::get('cart', []);
            $productIds = array_keys($sessionCart);
            $products = Product::whereIn('id', $productIds)->get();
            
            $cartItems = $products->map(function ($product) use ($sessionCart) {
                return (object) [
                    'id' => $product->id, // Use product ID as cart ID for session to simplify deletion
                    'product' => $product,
                    'quantity' => $sessionCart[$product->id]['quantity'],
                    'product_id' => $product->id
                ];
            });
        }

        return view('customer.cart', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        if (Auth::check()) {
            Cart::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                ],
                [
                    'quantity' => \DB::raw('quantity + ' . $request->quantity)
                ]
            );
        } else {
            $cart = Session::get('cart', []);
            $productId = $request->product_id;
            
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $request->quantity;
            } else {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'quantity' => $request->quantity
                ];
            }
            
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produk berhasil masuk keranjang!');
    }

    public function destroy($id)
    {
        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();
            if ($cartItem) {
                $cartItem->delete();
            }
        } else {
            $cart = Session::get('cart', []);
            // For session, $id is passed as product_id from the view loop logic above
            if (isset($cart[$id])) {
                unset($cart[$id]);
                Session::put('cart', $cart);
            }
        }

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
