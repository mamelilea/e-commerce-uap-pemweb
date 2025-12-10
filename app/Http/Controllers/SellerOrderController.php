<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $store = Store::where('user_id', $user->id)->first();

        if (!$store) {
            return redirect()->route('seller.dashboard');
        }

        $query = Transaction::with(['buyer.user', 'transactionDetails.product.productImages'])
            ->where('store_id', $store->id);

        if ($request->has('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status')) {
            if ($request->status === 'unpaid') {
                $query->where('payment_status', 'unpaid');
            } elseif ($request->status === 'processing') {
                $query->where('payment_status', 'paid')->whereNull('tracking_number');
            } elseif ($request->status === 'shipped') {
                $query->where('payment_status', 'paid')->whereNotNull('tracking_number');
            }
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return Inertia::render('Seller/Orders/Index', [
            'orders' => $orders,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    public function updateResi(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
        ]);

        $transaction = Transaction::findOrFail($id);
        
        $transaction->update([
            'tracking_number' => $request->tracking_number,
        ]);

        return back()->with('success', 'Nomor resi berhasil diupdate.');
    }
}