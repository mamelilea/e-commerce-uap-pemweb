<?php

namespace App\Http\Controllers;

use App\Models\StoreBalance;
use Illuminate\Http\Request;

class SellerBalanceController extends Controller
{
    public function index(Request $request)
    {
        $store = $request->user()->store()->firstOrFail();

        $balance = $store->balance()->with('storeBalanceHistories')->first();

        if (! $balance) {
            $balance = StoreBalance::create([
                'store_id' => $store->id,
                'balance'  => 0,
            ]);
        }

        $histories = $balance->storeBalanceHistories()
            ->latest()
            ->paginate(10);

        return view('seller.balance', [
            'balance'   => $balance,
            'histories' => $histories,
        ]);
    }
}