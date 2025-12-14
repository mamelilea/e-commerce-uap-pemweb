<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        if (!$store) {
            return redirect()->route('seller.store.register')
                ->with('info', 'Silakan daftar toko terlebih dahulu ya..');
        }
        $totalProducts = $store->products()->count();
        $totalOrders = $store->transactions()->count();
        $totalSales = $store->transactions()
            ->where('payment_status', 'paid')
            ->sum('grand_total');
        $isVerified = $store->is_verified;

        // Recent Orders (Last 5)
        $recentOrders = $store->transactions()
            ->with(['buyer.user', 'transactionDetails.product'])
            ->latest()
            ->take(5)
            ->get();

        // Chart Data (Dummy Monthly Data for Demo - in real app, group by date)
        // We will pass this to the view to be used by Chart.js
        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartData = [1200000, 1900000, 3000000, 5000000, 2000000, 3000000, 4500000, 6000000, 7000000, 8000000, 9500000, 12000000]; // Simplified dummy data

        return view('seller.dashboard', compact(
            'store', 
            'totalProducts', 
            'totalOrders', 
            'totalSales', 
            'isVerified',
            'recentOrders',
            'chartLabels',
            'chartData'
        ));
    }
}
