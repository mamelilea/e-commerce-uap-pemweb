<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }


    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('components.public-layout', function ($view) {
            $cartCount = 0;
            if (\Illuminate\Support\Facades\Auth::check()) {
                $cartCount = \App\Models\Cart::where('user_id', \Illuminate\Support\Facades\Auth::id())->count();
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
