<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    /**
     * Show the form for creating a new store.
     */
    public function create()
    {
        // Check if user already has a store
        if (auth()->user()->store) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.register');
    }

    /**
     * Store a newly created store in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores',
            'domain' => 'required|string|max:255|unique:stores,slug|alpha_dash',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        $store = Store::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'slug' => Str::slug($request->domain),
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'phone' => $request->phone,
            'is_verified' => false, // Default to unverified
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Store created successfully!');
    }

    /**
     * Display the seller dashboard.
     */
    public function dashboard()
    {
        $store = auth()->user()->store;
        
        if (!$store) {
            return redirect()->route('seller.register');
        }

        return view('seller.dashboard', compact('store'));
    }
}
