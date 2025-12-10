<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function detail($id)
    {
        $product = Product::find($id);

        if (!$product) {
            abort(404); 
        }

        return view('pengguna.detail', compact('product'));
    }

    public function index()
    {
    $products = Product::with('thumbnail')->get();
    return view('pengguna.home', compact('products'));
    }

    


}
