<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    // Tampilkan form registrasi toko
    public function create()
    {
        // Cek apakah user sudah punya toko
        if (Auth::user()->store) {
            return redirect()->route('store.dashboard')
                ->with('info', 'Anda sudah memiliki toko');
        }

        return view('store.create');
    }

    // Proses registrasi toko
    public function store(Request $request)
    {
        // Cek apakah user sudah punya toko
        if (Auth::user()->store) {
            return redirect()->route('store.dashboard')
                ->with('error', 'Anda sudah memiliki toko');
        }

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:stores,name',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'about' => 'required|string|min:20',
            'phone' => 'required|string|max:20',
            'address_id' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
        ], [
            'name.required' => 'Nama toko harus diisi',
            'name.unique' => 'Nama toko sudah digunakan',
            'logo.required' => 'Logo toko harus diupload',
            'logo.image' => 'File harus berupa gambar',
            'logo.mimes' => 'Logo harus format: jpeg, png, jpg',
            'logo.max' => 'Ukuran logo maksimal 2MB',
            'about.required' => 'Deskripsi toko harus diisi',
            'about.min' => 'Deskripsi minimal 20 karakter',
            'phone.required' => 'Nomor telepon harus diisi',
            'address_id.required' => 'ID alamat harus diisi',
            'city.required' => 'Kota harus diisi',
            'address.required' => 'Alamat lengkap harus diisi',
            'postal_code.required' => 'Kode pos harus diisi',
        ]);

        // Upload logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores/logos', 'public');
            $validated['logo'] = $logoPath;
        }

        // Tambahkan user_id
        $validated['user_id'] = Auth::id();
        $validated['is_verified'] = false;

        // Simpan toko
        $store = Store::create($validated);

        return redirect()->route('store.pending')
            ->with('success', 'Toko berhasil didaftarkan! Menunggu verifikasi admin.');
    }

    // Halaman dashboard toko
    public function dashboard()
    {
        $store = Auth::user()->store;

        // Jika belum punya toko
        if (!$store) {
            return redirect()->route('store.create')
                ->with('info', 'Silakan daftarkan toko Anda terlebih dahulu');
        }

        // Jika toko belum diverifikasi
        if (!$store->is_verified) {
            return redirect()->route('store.pending');
        }

        // Load relasi untuk statistik
        $store->load(['products', 'transactions']);

        $stats = [
            'total_products' => $store->products->count(),
            'total_transactions' => $store->transactions->count(),
            // 'pending_orders' => $store->transactions()->where('status', 'pending')->count(),
        ];

        return view('store.dashboard', compact('store', 'stats'));
    }

    // Halaman menunggu verifikasi
    public function pending()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('store.create');
        }

        if ($store->is_verified) {
            return redirect()->route('store.dashboard');
        }

        return view('store.pending', compact('store'));
    }

    // Tampilkan form edit toko
    public function edit()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('store.create');
        }

        return view('store.edit', compact('store'));
    }

    // Update toko
    public function update(Request $request)
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('store.create');
        }

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:stores,name,' . $store->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'about' => 'required|string|min:20',
            'phone' => 'required|string|max:20',
            'address_id' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
        ]);

        // Upload logo baru jika ada
        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }

            $logoPath = $request->file('logo')->store('stores/logos', 'public');
            $validated['logo'] = $logoPath;
        }

        // Update toko
        $store->update($validated);

        return redirect()->route('store.dashboard')
            ->with('success', 'Toko berhasil diperbarui!');
    }
}