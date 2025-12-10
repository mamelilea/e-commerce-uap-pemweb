<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if authenticated user has a store
        if (!auth()->user()->store) {
            return redirect()->route('seller.register')
                ->with('error', 'Anda harus mendaftar sebagai seller terlebih dahulu');
        }

        return $next($request);
    }
}
