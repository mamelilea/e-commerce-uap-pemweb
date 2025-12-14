<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = \App\Models\Cart::where('user_id', auth()->id())->with('product')->get();
        return view('frontend.cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = \App\Models\Cart::where('user_id', auth()->id())
                                    ->where('product_id', $request->product_id)
                                    ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            \App\Models\Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cartItem = \App\Models\Cart::where('user_id', auth()->id())
                                    ->where('id', $id)
                                    ->firstOrFail();

        if ($request->action === 'increase') {
            $cartItem->quantity += 1;
        } elseif ($request->action === 'decrease' && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
        }

        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function destroy($id)
    {
        $cartItem = \App\Models\Cart::where('user_id', auth()->id())
                                    ->where('id', $id)
                                    ->firstOrFail();
        
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }
}
