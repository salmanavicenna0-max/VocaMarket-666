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
        // Define subcategories mapping
        $subcategories = [
            'aksesoris' => ['Ganci', 'Nametag', 'Pin', 'Kaos', 'Gelas Custom'],
            'merchandise' => ['Kaos Khusus Sekolah', 'Gelas BN', 'Pulpen BN'],
            'hardware' => ['IoT (Hardware)'],
            'dkv-animasi' => ['Animasi (Logo gerak, iklan, dll)', 'Motion Graphic', 'Video Promosi', 'Desain Grafis'],
            'pemasaran' => ['Digital Marketing', 'Admin Medsos'],
            'pplg' => ['Website', 'Mobile', 'Server Hosting', 'Cloud', 'Game DEV', 'Excel', 'IoT (Software)'],
            'akuntansi' => ['Pembukuan', 'Pembuatan Laporan', 'Konsul Pajak']
        ];

        $categoryNames = [
            'aksesoris' => 'Aksesoris',
            'merchandise' => 'Merchandise',
            'hardware' => 'Hardware',
            'dkv-animasi' => 'DKV & Animasi',
            'pemasaran' => 'Pemasaran',
            'pplg' => 'PPLG',
            'akuntansi' => 'Akuntansi'
        ];

        // Fetch all active products as a dummy for now
        $products = Product::where('is_active', true)->get();
        
        $categoryName = $categoryNames[$slug] ?? ucfirst(str_replace('-', ' ', $slug));
        $currentSubcategories = $subcategories[$slug] ?? [];

        return view('product.category', compact('products', 'categoryName', 'slug', 'currentSubcategories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            $products = collect();
        } else {
            $products = Product::where('is_active', true)
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('category', 'like', "%{$query}%")
                      ->orWhere('type', 'like', "%{$query}%");
                })
                ->get();
        }
        
        return view('product.search', compact('products', 'query'));
    }
}
