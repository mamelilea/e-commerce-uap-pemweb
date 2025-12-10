<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display wishlist
     */
    public function index()
    {
        $wishlistIds = session('wishlist', []);
        
        $products = \App\Models\Product::with(['store', 'productImages', 'productReviews'])
            ->whereIn('id', $wishlistIds)
            ->get();

        return view('wishlist.index', compact('products'));
    }

    /**
     * Toggle product in wishlist
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlist = session('wishlist', []);
        $productId = $request->product_id;

        if (in_array($productId, $wishlist)) {
            // Remove from wishlist
            $wishlist = array_diff($wishlist, [$productId]);
            $message = 'Removed from wishlist';
            $inWishlist = false;
        } else {
            // Add to wishlist
            $wishlist[] = $productId;
            $message = 'Added to wishlist';
            $inWishlist = true;
        }

        session(['wishlist' => array_values($wishlist)]);

        return response()->json([
            'success' => true,
            'message' => $message,
            'in_wishlist' => $inWishlist,
            'wishlist_count' => count($wishlist)
        ]);
    }

    /**
     * Remove from wishlist
     */
    public function remove($productId)
    {
        $wishlist = session('wishlist', []);
        
        if (in_array($productId, $wishlist)) {
            $wishlist = array_diff($wishlist, [$productId]);
            session(['wishlist' => array_values($wishlist)]);

            return redirect()->back()->with('success', 'Removed from wishlist');
        }

        return redirect()->back()->with('error', 'Product not in wishlist');
    }
}
