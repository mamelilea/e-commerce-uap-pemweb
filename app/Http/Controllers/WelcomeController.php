<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['productImages', 'store'])
            ->withAvg('productReviews', 'rating')
            ->withCount('productReviews')
            ->latest()
            ->take(8)
            ->get();

        $categories = ProductCategory::withCount('products')->get();

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
        ]);
    }
}