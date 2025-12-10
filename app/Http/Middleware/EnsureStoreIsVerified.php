<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStoreIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->store) {
            return redirect()->route('seller.register');
        }

        // Check if store is verified by admin
        if (!auth()->user()->store->is_verified) {
            return redirect()->route('seller.pending')
                ->with('info', 'Toko Anda sedang dalam proses verifikasi oleh admin');
        }

        return $next($request);
    }
}
