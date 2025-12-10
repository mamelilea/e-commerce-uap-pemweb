<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsSeller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if user has seller role
        if ($user->role !== 'seller') {
            abort(403, 'Unauthorized. Only sellers can access this page.');
        }

        // Check if user has a store
        if (!$user->store) {
            abort(403, 'You do not have a store associated with your account.');
        }

        // Check if store is verified
        if (!$user->store->is_verified) {
            abort(403, 'Your store is not verified yet. Please wait for admin approval.');
        }

        return $next($request);
    }
}
