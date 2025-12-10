<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsSeller
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Belum login
        if (!$user) {
            return redirect()->route('login');
        }

        // Belum punya toko sama sekali
        if (!$user->store) {
            return redirect()
                ->route('seller.store.create')
                ->with('error', 'Kamu belum memiliki toko. Daftarkan toko dulu ya.');
        }

        // Punya toko tapi belum diverifikasi admin
        if (!$user->store->is_verified) {
            return redirect()
                ->route('seller.waiting')
                ->with('error', 'Toko kamu masih menunggu verifikasi admin.');
        }

        // Lolos semua → benar-benar seller yang tokonya sudah verified
        return $next($request);
    }
}
