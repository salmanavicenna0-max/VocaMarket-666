<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class SellerProfileController extends Controller
{
    public function show($id)
    {
        $seller = User::findOrFail($id);
        $products = Product::where('user_id', $id)->with('images')->get();
        
        // Calculate seller stats
        $totalSales = Order::where('seller_id', $id)->where('status', Order::STATUS_SELESAI)->count();
        $totalProducts = $products->count();
        // Static rating for now, or you can join reviews if available
        $rating = 4.9; 
        
        return view('profile.seller', compact('seller', 'products', 'totalSales', 'totalProducts', 'rating'));
    }
}
