<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    /**
     * Display a listing of the seller's orders.
     */
    public function index(Request $request)
    {
        $query = Transaction::where('store_id', auth()->user()->store->id)
            ->with(['buyer.user', 'transactionDetails.product']);

        // Filter by status
        if ($request->status) {
            $query->where('payment_status', $request->status);
        }

        $orders = $query->latest()->paginate(15);

        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Transaction::where('store_id', auth()->user()->store->id)
            ->with(['buyer.user', 'transactionDetails.product'])
            ->findOrFail($id);

        return view('seller.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Transaction::where('store_id', auth()->user()->store->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,paid,processed,shipped,completed,cancelled',
        ]);

        // Check if status is CHANGING to completed
        $oldStatus = $order->payment_status;
        
        $order->update($validated);

        // If order is completed, add to store balance
        if ($validated['payment_status'] === 'completed' && $oldStatus !== 'completed') {
            $storeBalance = auth()->user()->store->storeBalance()->firstOrCreate(
                ['store_id' => auth()->user()->store->id],
                ['balance' => 0]
            );

            $amount = $order->grand_total;
            $storeBalance->increment('balance', $amount);

            // Create history record
            \App\Models\StoreBalanceHistory::create([
                'store_balance_id' => $storeBalance->id,
                'type' => 'income',
                'reference_id' => $order->id,
                'reference_type' => Transaction::class,
                'amount' => $amount,
                'remarks' => 'Sales revenue from Order #' . $order->code,
            ]);
        }

        return back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Add tracking number to order.
     */
    public function addTracking(Request $request, $id)
    {
        $order = Transaction::where('store_id', auth()->user()->store->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'tracking_number' => 'required|string|max:255',
        ]);

        $order->update($validated);

        return back()->with('success', 'Tracking number added successfully!');
    }
}
