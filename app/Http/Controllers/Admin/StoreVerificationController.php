<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreVerificationController extends Controller
{
    /**
     * Display list of stores for verification
     */
    public function index(Request $request)
    {
        $query = Store::with(['user', 'verifier'])->orderBy('created_at', 'desc');

        // Filter by status
        $status = $request->get('status', 'pending');

        if ($status === 'pending') {
            $query->pending();
        } elseif ($status === 'verified') {
            $query->verified();
        } elseif ($status === 'rejected') {
            $query->rejected();
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $stores = $query->paginate(15);

        // Statistics
        $stats = [
            'pending' => Store::pending()->count(),
            'verified' => Store::verified()->count(),
            'rejected' => Store::rejected()->count(),
            'total' => Store::count(),
        ];

        return view('admin.stores.verify', compact('stores', 'stats', 'status'));
    }

    /**
     * Show store detail for verification
     */
    public function show($id)
    {
        $store = Store::with(['user', 'products', 'verifier'])->findOrFail($id);

        return view('admin.stores.show', compact('store'));
    }

    /**
     * Approve store verification
     */
    public function approve($id)
    {
        $store = Store::findOrFail($id);

        // Check if already verified
        if ($store->is_verified) {
            return back()->with('info', 'Toko sudah diverifikasi sebelumnya.');
        }

        // Update store
        $store->update([
            'is_verified' => true,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()->route('admin.stores.verify', ['status' => 'verified'])
            ->with('success', "Toko '{$store->name}' berhasil diverifikasi!");
    }

    /**
     * Reject store verification
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'min:10', 'max:500'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan harus diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter.',
            'rejection_reason.max' => 'Alasan penolakan maksimal 500 karakter.',
        ]);

        $store = Store::findOrFail($id);

        // Update store
        $store->update([
            'is_verified' => false,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('admin.stores.verify', ['status' => 'rejected'])
            ->with('success', "Toko '{$store->name}' ditolak.");
    }

    /**
     * Reset store status (allow re-submission)
     */
    public function reset($id)
    {
        $store = Store::findOrFail($id);

        $store->update([
            'is_verified' => false,
            'verified_by' => null,
            'verified_at' => null,
            'rejection_reason' => null,
        ]);

        return redirect()->route('admin.stores.verify', ['status' => 'pending'])
            ->with('success', "Status toko '{$store->name}' berhasil direset.");
    }
}
