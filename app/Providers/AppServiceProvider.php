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
        try {
            // Share categories with all views for the navbar/mega-menu
            $categories = \App\Models\ProductCategory::whereNull('parent_id')->with('children')->get();
            \Illuminate\Support\Facades\View::share('globalCategories', $categories);
        } catch (\Exception $e) {
            // Fallback if database is not ready yet
            \Illuminate\Support\Facades\View::share('globalCategories', collect([]));
        }
    }
}
