<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('is_active', true)
            ->with('images')
            ->get();

        $starProducts = $products->where('is_star', true)->take(8);
        $homepageBanners = \App\Models\HomepageBanner::where('is_active', true)->latest()->take(5)->get();

        return view('welcome', compact('products', 'starProducts', 'homepageBanners'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['images', 'reviews', 'seller.profile'])->findOrFail($id);

        return view('product.show', compact('product'));
    }

    /**
     * Display products by category slug.
     */
    public function category($slug)
    {
        $subcategories = [
            'aksesoris' => ['Ganci', 'Nametag', 'Pin', 'Kaos', 'Gelas Custom'],
            'merchandise' => ['Kaos Khusus Sekolah', 'Gelas BN', 'Pulpen BN'],
            'hardware' => ['IoT (Hardware)'],
            'dkv-animasi' => ['Animasi (Logo gerak, iklan, dll)', 'Motion Graphic', 'Video Promosi', 'Desain Grafis'],
            'pemasaran' => ['Digital Marketing', 'Admin Medsos'],
            'pplg' => ['Website', 'Mobile', 'Server Hosting', 'Cloud', 'Game DEV', 'Excel', 'IoT (Software)'],
            'akuntansi' => ['Pembukuan', 'Pembuatan Laporan', 'Konsul Pajak'],
        ];

        $categoryNames = [
            'aksesoris' => 'Aksesoris',
            'merchandise' => 'Merchandise',
            'hardware' => 'Hardware',
            'dkv-animasi' => 'DKV & Animasi',
            'pemasaran' => 'Pemasaran',
            'pplg' => 'PPLG',
            'akuntansi' => 'Akuntansi',
        ];

        $products = Product::where('is_active', true)
            ->with('images')
            ->where('category', 'like', '%' . ($categoryNames[$slug] ?? ucfirst(str_replace('-', ' ', $slug))) . '%')
            ->get();

        $categoryName = $categoryNames[$slug] ?? ucfirst(str_replace('-', ' ', $slug));
        $currentSubcategories = $subcategories[$slug] ?? [];

        return view('product.category', compact('products', 'categoryName', 'slug', 'currentSubcategories'));
    }

    /**
     * Search products by query.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            $products = collect();
        } else {
            $products = Product::where('is_active', true)
                ->with('images')
                ->where(function ($q) use ($query) {
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
