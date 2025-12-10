<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreVerificationController extends Controller
{
    /**
     * Display pending stores for verification.
     */
    public function index()
    {
        $pendingStores = Store::where('is_verified', false)
            ->with('user')
            ->latest()
            ->paginate(15);

        return view('admin.stores.index', compact('pendingStores'));
    }

    /**
     * Show store details for verification.
     */
    public function show($id)
    {
        $store = Store::with('user')->findOrFail($id);

        return view('admin.stores.show', compact('store'));
    }

    /**
     * Approve store verification.
     */
    public function approve($id)
    {
        $store = Store::findOrFail($id);
        $store->update(['is_verified' => true]);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store has been verified successfully!');
    }

    /**
     * Reject store verification.
     */
    public function reject($id)
    {
        $store = Store::findOrFail($id);
        
        // Optionally delete the store or just keep it unverified
        // $store->delete();
        
        return redirect()->route('admin.stores.index')
            ->with('success', 'Store verification rejected.');
    }

    /**
     * View all stores (verified and unverified).
     */
    public function all()
    {
        $stores = Store::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.stores.all', compact('stores'));
    }
}
