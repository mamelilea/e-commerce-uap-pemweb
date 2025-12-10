<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreController extends Controller
{
   // FORM BUAT TOKO
    public function create()
    {
        // Jika user sudah punya toko, arahkan ke edit
        $store = Store::where('user_id', Auth::id())->first();

        if ($store) {
            return redirect()->route('stores.edit', $store->id);
        }

        return view('stores.create');
    }

    // SIMPAN TOKO BARU
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'logo'        => 'nullable|image|max:2048',
            'about'       => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'city'        => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['is_verified'] = false;

        Store::create($validated);

        return redirect()->route('home')->with('success', 'Toko berhasil dibuat.');
    }

    // FORM EDIT TOKO
    public function edit($id)
    {
        $store = Store::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return view('stores.edit', compact('store'));
    }

    // UPDATE TOKO
    public function update(Request $request, $id)
    {
        $store = Store::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'logo'        => 'nullable|image|max:2048',
            'about'       => 'nullable|string',
            'phone'       => 'nullable|string|max:20',
            'city'        => 'nullable|string|max:255',
            'address'     => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $validated['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }

        $store->update($validated);

        return back()->with('success', 'Profil toko berhasil diperbarui.');
    }

    // HAPUS TOKO
    public function destroy($id)
    {
        $store = Store::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($store->logo) {
            Storage::disk('public')->delete($store->logo);
        }

        $store->delete();

        return redirect()->route('dashboard')->with('success', 'Toko berhasil dihapus.');
    }
}