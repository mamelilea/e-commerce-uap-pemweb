<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartSession = session()->get('cart', []);
        
        if (empty($cartSession)) {
            return redirect()->route('cart.index');
        }

        $productIds = array_keys($cartSession);
        $products = Product::with(['store'])->whereIn('id', $productIds)->get();

        $groupedItems = [];
        $totalPrice = 0;

        foreach ($products as $product) {
            $qty = $cartSession[$product->id];
            $subtotal = $product->price * $qty;
            $totalPrice += $subtotal;

            if (!isset($groupedItems[$product->store_id])) {
                $groupedItems[$product->store_id] = [
                    'store' => $product->store,
                    'items' => []
                ];
            }

            $groupedItems[$product->store_id]['items'][] = [
                'product' => $product,
                'qty' => $qty,
                'subtotal' => $subtotal
            ];
        }

        return Inertia::render('Checkout/Index', [
            'groupedItems' => array_values($groupedItems),
            'cartTotal' => $totalPrice,
            'user' => Auth::user()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string|max:500',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'phone' => 'required|string',
            'courier' => 'required|string',
            'payment_method' => 'required|in:cod,qris,va',
            'note' => 'nullable|string'
        ]);

        $user = Auth::user();
        
        $buyer = Buyer::firstOrCreate(['user_id' => $user->id]);
        if (!$buyer->phone_number) {
            $buyer->update(['phone_number' => $request->phone]);
        }

        $cartSession = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cartSession))->get();
        [$courierName, $shippingCost] = explode('|', $request->courier);

        $orderGroupId = Str::random(10); 

        DB::transaction(function () use ($user, $buyer, $products, $cartSession, $request, $courierName, $shippingCost, $orderGroupId) {
            
            $groupedProducts = $products->groupBy('store_id');

            foreach ($groupedProducts as $storeId => $storeProducts) {
                
                $subtotal = 0;
                foreach ($storeProducts as $prod) {
                    $subtotal += $prod->price * $cartSession[$prod->id];
                }

                $tax = $subtotal * 0.11;
                $grandTotal = $subtotal + $tax + $shippingCost;

                $fullAddress = $request->address;
                if ($request->note) {
                    $fullAddress .= " (Catatan: " . $request->note . ")";
                }

                $paymentStatus = 'unpaid';

                $trx = Transaction::create([
                    'code' => 'TRX-' . strtoupper(Str::random(8)),
                    'buyer_id' => $buyer->id,
                    'store_id' => $storeId,
                    'address' => $fullAddress,
                    'address_id' => $request->payment_method,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'shipping' => $courierName,
                    'shipping_type' => 'Reg',
                    'shipping_cost' => $shippingCost,
                    'tracking_number' => null, 
                    'tax' => $tax,
                    'grand_total' => $grandTotal,
                    'payment_status' => $paymentStatus,
                    'created_at' => now(),
                ]);

                foreach ($storeProducts as $prod) {
                    $qty = $cartSession[$prod->id];
                    TransactionDetail::create([
                        'transaction_id' => $trx->id,
                        'product_id' => $prod->id,
                        'qty' => $qty,
                        'subtotal' => $prod->price * $qty,
                    ]);
                    $prod->decrement('stock', $qty);
                }
            }
            
            session()->forget('cart');
            session()->put('last_order_group', $orderGroupId);
        });

        return redirect()->route('checkout.success', ['code' => $orderGroupId, 'method' => $request->payment_method]);
    }

    public function success(Request $request, $code)
    {
        if (session('last_order_group') !== $code) {
            return redirect('/');
        }

        return Inertia::render('Checkout/Success', [
            'orderCode' => $code,
            'paymentMethod' => $request->method,
        ]);
    }
}