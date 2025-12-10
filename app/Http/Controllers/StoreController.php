<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    // Form register toko
    public function create()
    {
        return view('toko.register');
    }

    // Simpan pengajuan toko
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'address_id' => 'required|integer',
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Cek jika user sudah punya toko
        if ($user->store) {
            return back()->with('error', 'Kamu sudah memiliki toko.');
        }

        // Upload logo
        $logoPath = $request->file('logo')->store('logos', 'public');

        // Simpan toko baru sebagai belum diverifikasi
        Store::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'about' => $request->about,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'address_id' => $request->address_id,
            'logo' => $logoPath,
            'is_verified' => false, // default false
        ]);

        return redirect()->route('toko.dashboard')
            ->with('success', 'Toko berhasil diajukan! Tunggu verifikasi admin.');
    }

    // Dashboard toko
    public function dashboard()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            return redirect()->route('toko.register')
                ->with('error', 'Kamu belum memiliki toko.');
        }

        if (!$store->is_verified) {
            return back()->with('error', 'Toko Anda belum diverifikasi admin.');
        }

        return view('toko.dashboard', compact('store'));
    }

    // Halaman daftar pesanan
    public function orders(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;
        
        
        if (!$store) {
            return redirect()->route('toko.register')
            ->with('error', 'Kamu belum memiliki toko.');
        }
        
        if (!$store->is_verified) {
            return redirect()->route('toko.dashboard')
            ->with('error', 'Toko belum diverifikasi.');
        }
        
        // nanti diganti dengan relasi orders
        $status = $request->query('status', null);
        // Halaman daftar pesanan
        $ordersQuery = $store->transactions()->with(['buyer', 'transactionDetails.product'])->latest();


        
        if ($status) {
            $ordersQuery->where('status', $status);
        }


        $orders = $ordersQuery->get();

        return view('toko.orders.home', compact('store', 'orders'));
    }

    // Detail pesanan
    public function orderDetail($id)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store || !$store->is_verified) {
            return redirect()->route('toko.dashboard')->with('error', 'Toko belum diverifikasi.');
        }

        // Detail pesanan
        $order = $store->transactions()->with(['buyer', 'transactionDetails.product'])->findOrFail($id);


        return view('toko.orders.detail', compact('order'));
    }

    // Update status pesanan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed',
        ]);

        $user = Auth::user();
        $store = $user->store;

        if (!$store->is_verified) {
            return back()->with('error', 'Toko belum diverifikasi.');
        }

        $order = $store->transactions()->findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('toko.orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    // Update nomor resi
    public function updateResi(Request $request, $id)
    {
        $request->validate([
            'resi_number' => 'required|string|max:50',
        ]);

        $user = Auth::user();
        $store = $user->store;

        if (!$store->is_verified) {
            return back()->with('error', 'Toko belum diverifikasi.');
        }

        $order = $store->transactions()->findOrFail($id);
        $order->update(['resi_number' => $request->resi_number]);

        return redirect()->route('toko.orders.show', $order->id)
            ->with('success', 'Nomor resi berhasil diperbarui.');
    }

    // Admin - halaman verifikasi toko
    public function verificationPage()
    {
        $stores = Store::where('is_verified', false)->get();
        return view('admin.verifikasi', compact('stores'));
    }

    // Admin - approve toko
    public function approve($id)
    {
        Store::where('id', $id)->update([
            'is_verified' => true
        ]);

        return redirect()->route('admin.verifikasi')
            ->with('success', 'Toko berhasil disetujui.');
    }

    // Admin - reject toko
    public function reject($id)
    {
        Store::where('id', $id)->update([
            'is_verified' => false
        ]);

        return redirect()->route('admin.verifikasi')
            ->with('success', 'Toko berhasil ditolak.');
    }
}
