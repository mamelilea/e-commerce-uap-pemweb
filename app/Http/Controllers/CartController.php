<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = \App\Models\Cart::where('user_id', \Illuminate\Support\Facades\Auth::id())->with('product.productCategory')->get();
        return view('cart.index', compact('carts'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $userId = \Illuminate\Support\Facades\Auth::id();
        $qty = $request->input('quantity', 1);

        $cart = \App\Models\Cart::where('user_id', $userId)->where('product_id', $request->product_id)->first();

        if ($cart) {
            $cart->increment('quantity', $qty);
        } else {
            \App\Models\Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'quantity' => $qty
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = \App\Models\Cart::where('id', $id)->where('user_id', \Illuminate\Support\Facades\Auth::id())->firstOrFail();
        $cart->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Cart updated successfully');
    }

    public function destroy($id)
    {
        \App\Models\Cart::where('id', $id)->where('user_id', \Illuminate\Support\Facades\Auth::id())->delete();
        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
