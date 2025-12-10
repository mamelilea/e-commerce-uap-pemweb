<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  ← Pastikan ada ini
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Cek apakah user memiliki salah satu role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, redirect berdasarkan role user
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
            'seller' => redirect()->route('seller.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
            'customer' => redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
            default => abort(403, 'Unauthorized action.')
        };
    }
}