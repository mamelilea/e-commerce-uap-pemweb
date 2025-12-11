<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Tambah ke keranjang
    public function addToCart(Request $request, $productId)
    {
        $product = Product::with('productImages')->findOrFail($productId);
        
        $cart = session()->get('cart', []);
        
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity ?? 1,
                'image' => $product->productImages->first()?->image_url ?? asset('image/home.png'),
                'weight' => $product->weight,
                'slug' => $product->slug,
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang! 🛒');
    }

    // Lihat keranjang
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        return view('customer.cart', compact('cart'));
    }

    // Update quantity
    public function updateCart(Request $request, $productId)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Keranjang diupdate!');
    }

    // Hapus dari keranjang
    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang!');
    }
}