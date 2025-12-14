<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = \App\Models\Wishlist::where('user_id', auth()->id())->with('product')->get();
        return view('frontend.wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $exists = \App\Models\Wishlist::where('user_id', auth()->id())
                                      ->where('product_id', $request->product_id)
                                      ->exists();

        if (!$exists) {
            \App\Models\Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
            ]);
        }

        return redirect()->route('wishlist.index')->with('success', 'Product added to wishlist!');
    }

    public function destroy($id)
    {
        $wishlistItem = \App\Models\Wishlist::where('user_id', auth()->id())
                                            ->where('id', $id)
                                            ->firstOrFail();
        
        $wishlistItem->delete();

        return redirect()->route('wishlist.index')->with('success', 'Product removed from wishlist!');
    }
}
