<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display cart
     */
    public function index()
    {
        $cart = session('cart', []);
        $total = $this->calculateTotal($cart);
        
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = \App\Models\Product::with('productImages')->findOrFail($request->product_id);

        // Check if user is trying to buy their own product
        if (auth()->check() && auth()->user()->store) {
            if ($product->store_id === auth()->user()->store->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat membeli produk dari toko Anda sendiri'
                ], 403);
            }
        }

        // Check stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock'
            ], 400);
        }

        $cart = session('cart', []);

        // If product already in cart, update quantity
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $request->quantity;
            
            if ($product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock'
                ], 400);
            }
            
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->productImages->first()->image ?? null,
                'store_id' => $product->store_id,
                'store_name' => $product->store->name ?? 'XIV Shop',
            ];
        }

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    /**
     * Update cart product quantity
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        // If quantity is 0 or less, remove the item
        if ($request->quantity <= 0) {
            return $this->remove($productId);
        }

        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            $product = \App\Models\Product::findOrFail($productId);
            
            if ($product->stock < $request->quantity) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Insufficient stock'], 400);
                }
                return redirect()->back()->with('error', 'Insufficient stock');
            }

            $cart[$productId]['quantity'] = $request->quantity;
            session(['cart' => $cart]);

            if ($request->wantsJson() || $request->ajax()) {
                $itemSubtotal = $product->price * $request->quantity;
                $total = $this->calculateTotal($cart);
                $cartCount = array_sum(array_column($cart, 'quantity'));
                
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated',
                    'quantity' => $request->quantity,
                    'item_subtotal' => number_format($itemSubtotal, 0, ',', '.'),
                    'total' => number_format($total, 0, ',', '.'),
                    'cart_count' => $cartCount
                ]);
            }

            return redirect()->back()->with('success', 'Cart updated');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Product not found in cart'], 404);
        }

        return redirect()->back()->with('error', 'Product not found in cart');
    }

    /**
     * Remove product from cart
     */
    public function remove($productId)
    {
        $cart = session('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);

            if (request()->wantsJson() || request()->ajax()) {
                $total = $this->calculateTotal($cart);
                $cartCount = array_sum(array_column($cart, 'quantity'));

                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart',
                    'total' => number_format($total, 0, ',', '.'),
                    'cart_count' => $cartCount,
                    'is_empty' => empty($cart)
                ]);
            }

            return redirect()->back()->with('success', 'Product removed from cart');
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['success' => false, 'message' => 'Product not found in cart'], 404);
        }

        return redirect()->back()->with('error', 'Product not found in cart');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared');
    }

    /**
     * Calculate cart total
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
