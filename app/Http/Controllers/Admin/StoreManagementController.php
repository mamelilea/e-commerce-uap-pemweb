<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreManagementController extends Controller
{
    /**
     * Display a listing of stores
     */
    public function index(Request $request)
    {
        $query = Store::with(['user', 'products']);

        // Filter by verification status
        if ($request->has('verification') && $request->verification != '') {
            if ($request->verification == 'verified') {
                $query->where('is_verified', true);
            } elseif ($request->verification == 'pending') {
                $query->where('is_verified', false)->whereNull('rejection_reason');
            } elseif ($request->verification == 'rejected') {
                $query->whereNotNull('rejection_reason');
            }
        }

        // Filter by status (active/suspended)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search by store name or owner
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $stores = $query->withCount('products')
                       ->latest()
                       ->paginate(15)
                       ->withQueryString();

        return view('admin.stores.index', compact('stores'));
    }

    /**
     * Display store detail
     */
    public function show($id)
    {
        $store = Store::with(['user', 'products.productImages'])
            ->withCount('products')
            ->findOrFail($id);

        // Get transactions if the model exists
        $transactions = collect();
        if (class_exists('\App\Models\Transaction')) {
            $transactions = \App\Models\Transaction::where('store_id', $id)
                ->with('buyer')
                ->latest()
                ->take(10)
                ->get();
        }

        return view('admin.stores.detail', compact('store', 'transactions'));
    }

    /**
     * Suspend store
     */
    public function suspend($id)
    {
        $store = Store::findOrFail($id);
        
        $store->update(['status' => 'suspended']);

        return back()->with('success', 'Toko berhasil disuspend!');
    }

    /**
     * Activate store
     */
    public function activate($id)
    {
        $store = Store::findOrFail($id);
        
        $store->update(['status' => 'active']);

        return back()->with('success', 'Toko berhasil diaktifkan!');
    }

    /**
     * Delete store
     */
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        
        // Delete all products and their images first
        foreach ($store->products as $product) {
            // Delete product images from storage
            foreach ($product->productImages as $image) {
                if (file_exists(storage_path('app/public/' . $image->image_path))) {
                    unlink(storage_path('app/public/' . $image->image_path));
                }
                $image->delete();
            }
            $product->delete();
        }
        
        // Delete store logo if exists
        if ($store->logo && file_exists(storage_path('app/public/' . $store->logo))) {
            unlink(storage_path('app/public/' . $store->logo));
        }
        
        $store->delete();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Toko berhasil dihapus!');
    }
}