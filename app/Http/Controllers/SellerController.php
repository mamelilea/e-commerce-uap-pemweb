<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function registerStore()
    {
        return view('store.register');
    }

    public function storeStore(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:stores,name',
            'about' => 'required',
            'city' => 'required',
            'address' => 'required',
            'logo' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $logoPath = 'stores/default.png';
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores', 'public');
        }

        \App\Models\Store::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'name' => $request->name,
            'logo' => $logoPath,
            'about' => $request->about,
            'phone' => \Illuminate\Support\Facades\Auth::user()->phone_number ?? '000',
            'address_id' => '0',
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => '00000',
            'is_verified' => false,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Store Registered! Waiting for verification.');
    }

    public function dashboard()
    {
        $store = \Illuminate\Support\Facades\Auth::user()->store;
        if (!$store) return redirect()->route('store.register');
        
        // Stats
        $sales = \App\Models\Transaction::where('store_id', $store->id)->where('payment_status', 'paid')->sum('grand_total');
        $orderCount = \App\Models\Transaction::where('store_id', $store->id)->count();

        return view('seller.dashboard', compact('store', 'sales', 'orderCount'));
    }

    public function profile()
    {
        $store = \Illuminate\Support\Facades\Auth::user()->store;
        return view('seller.profile', compact('store'));
    }

    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $store = \Illuminate\Support\Facades\Auth::user()->store;
        
        $request->validate([
            'name' => 'required|string|unique:stores,name,' . $store->id,
            'about' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);

        $store->update([
            'name' => $request->name,
            'about' => $request->about,
            'city' => $request->city,
            'address' => $request->address,
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('stores', 'public');
            $store->update(['logo' => $path]);
        }

        return redirect()->back()->with('success', 'Profile Updated');
    }

    // Product Management
    public function products()
    {
        if (!\Illuminate\Support\Facades\Auth::user()->isSeller()) {
            return redirect()->route('seller.dashboard')->with('error', 'Store verification pending. You cannot manage products yet.');
        }
        $store = \Illuminate\Support\Facades\Auth::user()->store;
        $products = \App\Models\Product::where('store_id', $store->id)->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    public function createProduct()
    {
        if (!\Illuminate\Support\Facades\Auth::user()->isSeller()) {
            return redirect()->route('seller.dashboard')->with('error', 'Store verification pending.');
        }
        $categories = \App\Models\ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    public function storeProduct(\Illuminate\Http\Request $request)
    {
        if (!\Illuminate\Support\Facades\Auth::user()->isSeller()) {
            return redirect()->route('seller.dashboard')->with('error', 'Store verification pending.');
        }
        $request->validate([
            'name' => 'required',
            'product_category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'required',
            'image' => 'required|image'
        ]);

        $store = \Illuminate\Support\Facades\Auth::user()->store;

        $product = \App\Models\Product::create([
            'store_id' => $store->id,
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'condition' => 'new', // Default
            'weight' => 1000, // Default
            'is_active' => true,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            \App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image' => $path,
                'is_thumbnail' => true
            ]);
        }

        return redirect()->route('seller.products')->with('success', 'Product Created');
    }

    public function destroyProduct($id)
    {
        $product = \App\Models\Product::where('id', $id)->where('store_id', \Illuminate\Support\Facades\Auth::user()->store->id)->firstOrFail();
        $product->delete();
        return back()->with('success', 'Product Deleted');
    }

    // Order Management
    public function orders()
    {
        if (!\Illuminate\Support\Facades\Auth::user()->isSeller()) {
            return redirect()->route('seller.dashboard')->with('error', 'Store verification pending.');
        }
        $store = \Illuminate\Support\Facades\Auth::user()->store;
        $transactions = \App\Models\Transaction::where('store_id', $store->id)->orderBy('created_at', 'desc')->get();
        return view('seller.orders.index', compact('transactions'));
    }

    public function updateOrder(\Illuminate\Http\Request $request, $id)
    {
        $transaction = \App\Models\Transaction::where('id', $id)->where('store_id', \Illuminate\Support\Facades\Auth::user()->store->id)->firstOrFail();
        
        if ($request->has('tracking_number')) {
            $transaction->update(['tracking_number' => $request->tracking_number]);
        }
        
        return back()->with('success', 'Order Updated');
    }

    public function balance()
    {
        if (!\Illuminate\Support\Facades\Auth::user()->isSeller()) {
            return redirect()->route('seller.dashboard')->with('error', 'Store verification pending.');
        }
        $store = \Illuminate\Support\Facades\Auth::user()->store;
        $balance = \App\Models\StoreBalance::firstOrCreate(['store_id' => $store->id], ['balance' => 0]);
        $history = \App\Models\StoreBalanceHistory::where('store_balance_id', $balance->id)->orderBy('created_at', 'desc')->get();
        return view('seller.balance', compact('balance', 'history'));
    }

    public function withdrawals()
    {
        if (!\Illuminate\Support\Facades\Auth::user()->isSeller()) {
            return redirect()->route('seller.dashboard')->with('error', 'Store verification pending.');
        }
        $store = \Illuminate\Support\Facades\Auth::user()->store;
        $withdrawals = \App\Models\Withdrawal::where('store_id', $store->id)->orderBy('created_at', 'desc')->get();
        return view('seller.withdrawals.index', compact('withdrawals'));
    }

    public function storeWithdrawal(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_name' => 'required|string',
            'account_number' => 'required|string'
        ]);

        $store = \Illuminate\Support\Facades\Auth::user()->store;
        $balance = \App\Models\StoreBalance::firstOrCreate(['store_id' => $store->id], ['balance' => 0]);

        if ($balance->balance < $request->amount) {
            return back()->with('error', 'Insufficient Balance');
        }

        \App\Models\Withdrawal::create([
            'store_id' => $store->id,
            'store_balance_id' => $balance->id,
            'amount' => $request->amount,
            'status' => 'pending',
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->account_number,
            'bank_account_name' => null // Optional as per migration
        ]);

        $balance->decrement('balance', $request->amount);
        
        // Record History
        \App\Models\StoreBalanceHistory::create([
             'store_balance_id' => $balance->id,
             'amount' => $request->amount,
             'type' => 'debit',
             'description' => 'Withdrawal Request',
        ]);

        return back()->with('success', 'Withdrawal Requested');
    }
}
