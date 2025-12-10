<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! $request->user()) {
            return redirect('login');
        }

        $user = $request->user();

        foreach ($roles as $role) {
            // Check for Admin
            if ($role === 'admin' && $user->role === 'admin') {
                return $next($request);
            }
            
            // Check for Seller
            if ($role === 'seller' && $user->store) {
                 return $next($request);
            }
            
            // Check for Customer/Member (Authenticated user)
            if ($role === 'member' || $role === 'customer') {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized');
    }
}
