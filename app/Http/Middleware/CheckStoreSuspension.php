<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStoreSuspension
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->store && $user->store->is_suspended) {
            // Allow access to dashboard so they can see the message
            if ($request->routeIs('seller.dashboard')) {
                return $next($request);
            }
            
            return redirect()->route('seller.dashboard')->with('error', 'Your store is suspended.');
        }

        return $next($request);
    }
}
