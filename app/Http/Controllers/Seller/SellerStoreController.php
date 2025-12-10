<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SellerStoreController extends Controller
{
    public function create()
    {
        return view('seller.register.register-store');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'about' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'address_id' => 'nullable',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $logoName = null;

        if ($request->hasFile('logo')) {
            $logoName = time() . '-' . $request->logo->getClientOriginalName();
            $request->logo->move(public_path('uploads/toko_logo/'), $logoName);
        }

        Store::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(), // <— TAMBAHKAN INI
            'about' => $request->about,
            'phone' => $request->phone,
            'address_id' => $request->address_id,
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'logo' => $logoName,
            'is_verified' => 0,
        ]);

        return redirect()->route('seller.waiting')->with('success', 'Toko berhasil didaftarkan! Menunggu verifikasi admin.');
    }
}
