<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index()
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        
        $orders = \App\Models\Transaction::where('store_id', $store->id)
                    ->with(['user', 'transactionDetails.product'])
                    ->latest()
                    ->get();

        return view('frontend.store.orders.index', compact('orders', 'store'));
    }

    public function show($id)
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        
        $order = \App\Models\Transaction::where('id', $id)
                    ->where('store_id', $store->id)
                    ->with(['user', 'transactionDetails.product'])
                    ->firstOrFail();

        return view('frontend.store.orders.show', compact('order', 'store'));
    }

    public function updateStatus(Request $request, $id)
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        
        $transaction = \App\Models\Transaction::where('id', $id)
                        ->where('store_id', $store->id)
                        ->firstOrFail();

        $request->validate([
            'status' => 'required|in:paid,shipped,completed,cancelled',
        ]);

        $transaction->payment_status = $request->status;
        $transaction->save();

        return back()->with('success', 'Order status updated to ' . $request->status);
    }

    public function updateTracking(Request $request, $id)
    {
        $store = \App\Models\Store::where('user_id', auth()->id())->firstOrFail();
        
        $transaction = \App\Models\Transaction::where('id', $id)
                        ->where('store_id', $store->id)
                        ->firstOrFail();

        $request->validate([
            'tracking_number' => 'required|string|max:255',
            'shipping_info' => 'nullable|string',
        ]);

        $transaction->tracking_number = $request->tracking_number;
        $transaction->shipping_info = $request->shipping_info;
        $transaction->payment_status = 'shipped'; // Auto update to shipped
        $transaction->save();

        return back()->with('success', 'Tracking information updated successfully!');
    }
}
