<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::define('admin', function (\App\Models\User $user) {
            return $user->role === 'admin';
        });

        \Illuminate\Support\Facades\Gate::define('seller', function (\App\Models\User $user) {
            return $user->role === 'member' && $user->store;
        });

        \Illuminate\Support\Facades\Gate::define('customer', function (\App\Models\User $user) {
            return $user->role === 'member';
        });
    }
}
