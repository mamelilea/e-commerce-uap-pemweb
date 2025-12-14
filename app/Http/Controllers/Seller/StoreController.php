<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\StoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    protected $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->store) {
            return redirect()->route('seller.store.manage');
        }

        return view('seller.store.register');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->store) {
            return redirect()->back()->with('error', 'Anda sudah memiliki toko.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $this->storeService->createStore($user->id, $validated, $request->file('logo'));
        
        // Update User Role to Seller
        $user->update(['role' => 'seller']);

        return redirect()->route('seller.store.manage')->with('success', 'Pendaftaran toko berhasil! Status: Menunggu verifikasi Admin.');
    }

    public function manage()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            return redirect()->route('seller.store.register');
        }

        return view('seller.store.manage', compact('store'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            return redirect()->route('seller.store.register');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $this->storeService->updateStore($store, $validated, $request->file('logo'));

        return redirect()->route('seller.store.manage')->with('success', 'Profil toko berhasil diperbarui.');
    }

    public function destroy()
    {
        $store = Auth::user()->store;

        if ($store) {
            $this->storeService->deleteStore($store);
        }

        return redirect()->route('seller.store.register')->with('success', 'Toko Anda berhasil dihapus.');
    }
}
