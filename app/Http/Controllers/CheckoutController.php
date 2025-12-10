<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Buyer;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    public function index(Request $request, Product $product)
    {
        $qty = $request->qty ?? 1;

        $address = session('checkout.address');
        $address_id = session('checkout.address_id');
        $city = session('checkout.city');
        $postal_code = session('checkout.postal_code');
        $shipping_type = session('checkout.shipping_type');
        $payment = session('checkout.payment');
        $shippingCost = 5000;
        $buyer_name = session('checkout.buyer_name');
        $phone_number = session('checkout.phone_number');

        return view('pengguna.cekout', [
            'product' => $product,
            'qty' => $qty,
            'total' => $product->price * $qty,
            'address' => $address,
            'address_id' => $address_id,
            'city' => $city,
            'postal_code' => $postal_code,
            'shipping_type' => $shipping_type,
            'payment' => $payment,
            'shippingCost' => $shippingCost,
            'buyer_name' => $buyer_name,
            'phone_number' => $phone_number,
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $user = Auth::user();
        $request->validate([
            'qty' => 'required|integer|min:1',
            'address' => 'required|string',
            'address_id' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'shipping_type' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'tax' => 'required|numeric',
            'grand_total' => 'required|numeric',
        ]);


        $buyer = Buyer::updateOrCreate(
                ['user_id' => $user->id], 
                [
                'name' => $user->name,
                'profile_picture' => $user->profile_picture ?? null,
                'phone_number' => $user->phone_number ?? null,
            ]
        );

        $store_id = $product->store_id;
        $product = Product::findOrFail($product->id);

        $transaction = Transaction::create([
            'buyer_id' => $buyer->id,
            'buyer_name' => $buyer->name,
            'profile_picture' => $buyer->profile_picture,
            'phone_number' => $buyer->phone_number,
            'created_by' => $user->name,
            'updated_by' => $user->name,
            'store_id' => $store_id,
            'code' => 'TRX-' . strtoupper(uniqid()),
            'address' => $request->address,
            'address_id' => $request->address_id ?? session('checkout.address_id'),
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'shipping' => session('checkout.shipping', 'default_shipping'),
            'shipping_type' => $request->shipping_type,
            'shipping_cost' => $request->shipping_cost,
            'tax' => $request->tax,
            'grand_total' => $request->grand_total,
            'payment_status' => 'paid',
            'status' => 'pending',
        ]);

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'qty' => $request->qty,
            'subtotal' => $product->price * $request->qty,
        ]);

        return redirect()->back()->with('success', 'Checkout berhasil! Data tersimpan di database.');
    }

    public function show(Transaction $transaction)
    {
        $transaction = Transaction::with('transactionDetails.product')->findOrFail($transaction->id);
        return view('pengguna.cekout', compact('transaction'));
    }

    public function address(Product $product)
    {
        return view('pengguna.alamat', compact('product'));
    }


    public function storeAddress(Request $request, Product $product)
    {
        $request->validate([
            'address' => 'required',
            'address_id' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
        ]);

        session([
            'checkout.address' => $request->address,
            'checkout.address_id' => $request->address_id,
            'checkout.city' => $request->city,
            'checkout.postal_code' => $request->postal_code,
        ]);

        return redirect()->route('pengguna.cekout', $product->id);
    }

    public function shipping(Product $product)
    {
        return view('pengguna.pengiriman', compact('product'));
    }

    public function storeShipping(Request $request, Product $product)
    {
        $request->validate([
            'shipping_type' => 'required',
        ]);

        session([
            'checkout.shipping_type' => $request->shipping_type
        ]);

        return redirect()->route('pengguna.cekout', $product->id);
    }

    public function payment(Product $product)
    {
        return view('pengguna.metodepembayaran', compact('product'));
    }

    public function storePayment(Request $request, Product $product)
    {
        $request->validate([
            'payment' => 'required',
        ]);

        session([
            'checkout.payment' => $request->payment
        ]);

        return redirect()->route('pengguna.cekout', $product->id);
    }
}
