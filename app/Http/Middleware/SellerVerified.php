<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerVerified
{
    /**
     * Handle an incoming request.
     *
     * Check if seller's store is verified
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Jika bukan seller, lanjutkan
        if ($user->role !== 'seller') {
            return $next($request);
        }

        // Cek apakah seller punya toko
        if (!$user->store) {
            return redirect()->route('seller.waiting')->with('error', 'Anda belum memiliki toko.');
        }

        $store = $user->store;

        // Jika toko ditolak, redirect ke halaman rejected
        if ($store->isRejected()) {
            return redirect()->route('seller.rejected');
        }

        // Jika toko belum diverifikasi (pending), redirect ke halaman waiting
        if (!$store->is_verified) {
            return redirect()->route('seller.waiting');
        }

        // Toko sudah verified, lanjutkan ke halaman yang diminta
        return $next($request);
    }
}
