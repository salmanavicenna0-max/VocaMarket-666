<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Payment;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Admin dashboard with real stats.
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalProducts = Product::where('type', 'produk')->count();
        $totalServices = Product::where('type', 'jasa')->count();

        $revenueMonth = Order::where('status', Order::STATUS_SELESAI)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total');

        $revenuePrevMonth = Order::where('status', Order::STATUS_SELESAI)
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->sum('total');

        $revenueChange = $revenuePrevMonth > 0
            ? round((($revenueMonth - $revenuePrevMonth) / $revenuePrevMonth) * 100, 1)
            : 0;

        $pendingPayments = Payment::where('status', Payment::STATUS_PENDING)->count();
        $pendingReviews = \App\Models\Review::where('status', \App\Models\Review::STATUS_PENDING)->count();

        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(5)
            ->get();

        return view('Admin.Dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalServices',
            'revenueMonth',
            'revenuePrevMonth',
            'revenueChange',
            'pendingPayments',
            'pendingReviews',
            'recentOrders'
        ));
    }
}
