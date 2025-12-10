<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Store;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $cart = session()->get('cart', []);
        $cartCount = count($cart);

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'role' => $request->user()->role,
                    'store_verified' => $request->user()->role === 'seller' 
                        ? (Store::where('user_id', $request->user()->id)->value('is_verified') ?? false)
                        : null,
                ] : null,
                'cart_count' => $cartCount,
            ],
        ];
    }
}