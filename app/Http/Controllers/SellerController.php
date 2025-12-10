<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Str;

class SellerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        if (!$user->store) {
            return redirect()->route('seller.register');
        }
        
        $totalProducts = \App\Models\Product::where('store_id', $user->store->id)->count();
        $totalOrders = \App\Models\Transaction::where('store_id', $user->store->id)->count();
        
        $storeBalance = \App\Models\StoreBalance::firstOrCreate(
            ['store_id' => $user->store->id],
            ['balance' => 0]
        );
        
        return view('seller.dashboard', compact('totalProducts', 'totalOrders', 'storeBalance'));
    }

    public function registerStore()
    {
        return view('seller.register');
    }

    public function storeStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
        ]);

        $user = auth()->user();
        
        Store::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'logo' => 'default_logo.png',
            'about' => $request->about,
            'phone' => '000000000',
            'address_id' => '0',
            'city' => $request->city,
            'address' => 'Default Address',
            'postal_code' => '00000',
            'is_verified' => false,
        ]);

        return redirect()->route('seller.dashboard');
    }

    public function products()
    {
        return view('seller.products.index');
    }

    public function createProduct()
    {
        return view('seller.products.create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'required|string',
            'condition' => 'required|in:new,second',
            'category_id' => 'required|exists:product_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $store = auth()->user()->store;

        $product = Product::create([
            'store_id' => $store->id,
            'product_category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'condition' => $request->condition,
            'price' => $request->price,

            'stock' => $request->stock,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
             \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image' => $path,
                'is_thumbnail' => true,
            ]);
        } else {
             \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image' => 'products/default.jpg',
                'is_thumbnail' => true,
            ]);
        }

        return redirect()->route('seller.products.index');
    }

    public function editProduct(\App\Models\Product $product)
    {
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }
        return view('seller.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, \App\Models\Product $product)
    {
         if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'required|string',
            'condition' => 'required|in:new,second',
            'category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update([
            'product_category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'condition' => $request->condition,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        if ($request->hasFile('image')) {
            $product->productImages()->delete();
            
            $path = $request->file('image')->store('products', 'public');
             \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image' => $path,
                'is_thumbnail' => true,
            ]);
        }

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully');
    }

    public function orders()
    {
        $store = auth()->user()->store;
        $transactions = \App\Models\Transaction::where('store_id', $store->id)->latest()->get();
        return view('seller.orders.index', compact('transactions'));
    }

    public function showOrder(\App\Models\Transaction $transaction)
    {
        if ($transaction->store_id !== auth()->user()->store->id) {
            abort(403);
        }
        return view('seller.orders.show', compact('transaction'));
    }

    public function updateOrder(\App\Models\Transaction $transaction, Request $request)
    {
        if ($transaction->store_id !== auth()->user()->store->id) {
            abort(403);
        }
        
        if ($transaction->delivery_status === 'received') {
            return redirect()->back()->with('error', 'Order already completed. Cannot update tracking number.');
        }

        if ($request->status) {
        }
        
        $request->validate([
            'tracking_number' => 'nullable|string'
        ]);

        if ($request->tracking_number) {
            $transaction->update([
                'tracking_number' => $request->tracking_number,
                'delivery_status' => 'shipped'
            ]);
        }

        return redirect()->back()->with('success', 'Order updated');
    }
    public function destroyProduct(\App\Models\Product $product)
    {
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        // Delete product images
        foreach ($product->productImages as $image) {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($image->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image);
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully');
    }
}
