<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $store = $request->user()->store()->with('balance')->first();

        $metrics = [
            'products'        => $store ? $store->products()->count() : 0,
            'orders'          => $store ? $store->transactions()->count() : 0,
            'pendingOrders'   => $store ? $store->transactions()->where('status', 'pending')->count() : 0,
            'completedOrders' => $store ? $store->transactions()->where('status', 'completed')->count() : 0,
            'balance'         => $store?->balance?->balance ?? 0,
        ];

        $recentOrders = $store
            ? $store->transactions()
                ->with(['buyer.user'])
                ->latest()
                ->take(5)
                ->get()
            : collect();

        return view('seller.dashboard', [
            'store'        => $store,
            'metrics'      => $metrics,
            'recentOrders' => $recentOrders,
        ]);
    }
}