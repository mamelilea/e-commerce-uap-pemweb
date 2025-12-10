<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerStoreController extends Controller
{
    /**
     * Display store profile
     */
    public function index()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        return view('seller.store.index', compact('store'));
    }

    /**
     * Show edit form
     */
    public function edit()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        return view('seller.store.edit', compact('store'));
    }

    /**
     * Update store profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'about' => ['required', 'string', 'max:1000'],
            'phone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'postal_code' => ['required', 'string', 'max:10'],
        ]);

        // Handle logo upload
        $logoPath = $store->logo; // Keep existing logo by default

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($store->logo && Storage::disk('public')->exists($store->logo)) {
                Storage::disk('public')->delete($store->logo);
            }

            // Upload new logo
            $logoPath = $request->file('logo')->store('store-logos', 'public');
        }

        // Update store data
        $store->update([
            'name' => $request->name,
            'logo' => $logoPath,
            'about' => $request->about,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
        ]);

        return redirect()->route('seller.store.index')
            ->with('success', 'Profil toko berhasil diperbarui!');
    }

    /**
     * Delete store logo
     */
    public function deleteLogo()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'You do not have a store.');
        }

        if ($store->logo && Storage::disk('public')->exists($store->logo)) {
            Storage::disk('public')->delete($store->logo);
        }

        $store->logo = null;
        $store->save();

        return back()->with('success', 'Logo toko berhasil dihapus!');
    }
}
