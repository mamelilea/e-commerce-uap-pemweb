<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->first();
        
        if(!$store) {
            return redirect()->route('store.create');
        }

        return view('frontend.store.index', compact('store'));
    }

    public function create()
    {
        // Check if user already has a store
        if(\App\Models\Store::where('user_id', auth()->id())->exists()) {
             return redirect()->route('store.index');
        }

        return view('frontend.store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name . '-' . uniqid()),
            'city' => $request->city,
            'about' => $request->about,
            'phone' => $request->phone,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'is_verified' => false, // Store needs admin verification
        ];

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }

        $store = \App\Models\Store::create($data);
        
        // Initialize Store Balance
        \App\Models\StoreBalance::create(['store_id' => $store->id, 'balance' => 0]);
        
        // Update user role to 'seller' after creating store
        $user = auth()->user();
        $user->role = 'seller';
        $user->save();
        
        return redirect()->route('store.index')->with('success', 'Shop created successfully! Your shop is pending admin verification. You will be able to start selling once approved.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function edit()
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        return view('frontend.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'about' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:10',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'city' => $request->city,
            'about' => $request->about,
            'phone' => $request->phone,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
        ];

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($store->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($store->logo)) {
                 \Illuminate\Support\Facades\Storage::disk('public')->delete($store->logo);
            }
            $data['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }

        if ($request->hasFile('banner')) {
            // Delete old banner if exists
            if ($store->banner && \Illuminate\Support\Facades\Storage::disk('public')->exists($store->banner)) {
                 \Illuminate\Support\Facades\Storage::disk('public')->delete($store->banner);
            }
            $data['banner'] = $request->file('banner')->store('stores/banners', 'public');
        }

        $store->update($data);

        return redirect()->route('store.edit')->with('success', 'Store profile updated successfully!');
    }

    public function destroy()
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        
        // Delete logo if exists
        if ($store->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($store->logo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($store->logo);
        }
        
        // Delete banner if exists
        if ($store->banner && \Illuminate\Support\Facades\Storage::disk('public')->exists($store->banner)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($store->banner);
        }
        
        // Change user role back to member
        $user = auth()->user();
        $user->role = 'member';
        $user->save();
        
        // Delete the store (this will cascade delete products, etc.)
        $store->delete();
        
        return redirect()->route('home')->with('success', 'Your store has been deleted successfully.');
    }
}
