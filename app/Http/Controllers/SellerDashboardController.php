<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductImage;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $products = $user->products()->with('images')->latest()->get();
        if ($user->isAdmin()) {
            $orders = \App\Models\Order::where('status', '!=', 'menunggu_pembayaran')
                ->with(['items.product', 'user', 'payments'])
                ->latest()
                ->get();
        } else {
            $orders = $user->salesOrders()
                ->where('status', '!=', 'menunggu_pembayaran')
                ->with(['items.product', 'user', 'payments'])
                ->latest()
                ->get();
        }

        $reviews = \App\Models\Review::whereHas('product', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['user', 'product'])->latest()->get();

        $pendingOrdersCount = $orders->where('is_read_by_seller', false)->whereIn('status', ['menunggu_verifikasi', 'diproses'])->count();
        $ordersSiapDikirim = $orders->where('status', 'diproses')->count();
        $totalReviewsCount = $reviews->where('is_read_by_seller', false)->count();
        $reviewsBelumDibalas = $reviews->where('is_read_by_seller', false)->count();

        $totalRevenue = $orders->where('status', 'selesai')->sum('total');
        $completedOrders = $orders->where('status', 'selesai')->count();
        $totalProducts = $products->count();
        $visitorCount = $orders->count() > 0 ? $orders->sum('total') / 1000 : 0; // Estimated visitors based on order count
        $profile = $user->profile ?? \App\Models\Profile::firstOrCreate(['user_id' => $user->id]);

        return view('seller.products', compact('products', 'orders', 'reviews', 'totalRevenue', 'completedOrders', 'totalProducts', 'user', 'profile', 'pendingOrdersCount', 'ordersSiapDikirim', 'totalReviewsCount'));
    }

    public function storeProduct(Request $request)
    {
        if ($request->has('price')) {
            $cleanPrice = (int) str_replace(['.', ','], '', $request->input('price'));
            $request->merge(['price' => $cleanPrice]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'sub_category' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images' => 'nullable|array|max:6',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,webm,mov,ogg,m4v|max:51200'
        ]);

        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'category' => $request->category,
            'type' => $request->sub_category,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_active' => false,
            'approval_status' => 'pending',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                if ($index >= 6) break; // Limit to max 6 files
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return back()->with('success', 'Pengajuan produk berhasil dikirim! Menunggu konfirmasi admin.');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        if ($request->has('price')) {
            $cleanPrice = (int) str_replace(['.', ','], '', $request->input('price'));
            $request->merge(['price' => $cleanPrice]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'sub_category' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = [
            'name' => $request->name,
            'category' => $request->category,
            'type' => $request->sub_category,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        if ($request->has('is_active')) {
            $data['is_active'] = $request->is_active;
        }

        $product->update($data);

        return back()->with('success', 'Produk diperbarui!');
    }

    public function destroyProduct($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        $product->delete();

        return back()->with('success', 'Produk dihapus!');
    }
    public function markOrdersRead()
    {
        $user = Auth::user();
        \App\Models\Order::where('seller_id', $user->id)
            ->where('is_read_by_seller', false)
            ->update(['is_read_by_seller' => true]);

        return response()->json(['success' => true]);
    }

    public function markReviewsRead()
    {
        $user = Auth::user();
        \App\Models\Review::whereHas('product', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('is_read_by_seller', false)->update(['is_read_by_seller' => true]);

        return response()->json(['success' => true]);
    }

    public function getDashboardData()
    {
        $user = Auth::user();
        $orders = $user->salesOrders()
            ->where('status', 'selesai')
            ->with(['items.product'])
            ->get();

        // Group by month
        $monthlyRevenue = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyRevenue[$m] = 0;
        }

        foreach ($orders as $order) {
            $month = strtotime($order->created_at);
            $monthKey = date('n', $month);
            $monthlyRevenue[$monthKey] += $order->total;
        }

        $labels = [];
        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $labels[] = $monthNames[$m - 1];
            $data[] = $monthlyRevenue[$m];
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'totalRevenue' => $orders->where('status', 'selesai')->sum('total'),
            'completedOrders' => $orders->where('status', 'selesai')->count(),
        ]);
    }
}
