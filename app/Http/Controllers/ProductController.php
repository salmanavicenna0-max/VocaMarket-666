<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        return view('welcome', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.show', compact('product'));
    }

    public function category($slug)
    {
        // Fetch all active products as a dummy for now
        $products = Product::where('is_active', true)->get();
        
        $categoryName = str_replace('-', ' ', ucfirst($slug));
        if (strtoupper($slug) === 'DKV' || strtoupper($slug) === 'PPLG') {
            $categoryName = strtoupper($slug);
        }

        return view('product.category', compact('products', 'categoryName', 'slug'));
    }
}
