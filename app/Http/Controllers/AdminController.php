<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;

class AdminController extends Controller
{

    /**
     * Admin dashboard with real stats.
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalProducts = Product::whereIn('category', ['Aksesoris', 'Merchandise', 'Hardware'])->count();
        $totalServices = Product::whereIn('category', ['DKV & Animasi', 'Pemasaran', 'PPLG', 'Akuntansi'])->count();

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
        $pendingProducts = Product::where('approval_status', 'pending')->count();

        $recentOrders = Order::with(['user', 'seller', 'items.product'])
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
            'pendingProducts',
            'recentOrders'
        ));
    }

    public function productSubmissions()
    {
        $pendingProducts = Product::with(['seller', 'images'])
            ->where('approval_status', 'pending')
            ->latest()
            ->get();

        $historyProducts = Product::with(['seller', 'images'])
            ->whereIn('approval_status', ['approved', 'rejected'])
            ->latest()
            ->take(20)
            ->get();

        return view('Admin.products.submissions', compact('pendingProducts', 'historyProducts'));
    }

    public function approveProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        return back()->with('success', "Produk '{$product->name}' berhasil disetujui dan diterbitkan ke toko!");
    }

    public function rejectProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'is_active' => false,
            'approval_status' => 'rejected',
        ]);

        return back()->with('success', "Pengajuan produk '{$product->name}' telah ditolak.");
    }

    public function transactions()
    {
        $orders = Order::with(['user', 'seller', 'items.product'])->latest()->paginate(20);
        return view('Admin.transactions.index', compact('orders'));
    }

    public function approveRefund($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status === Order::STATUS_MENUNGGU_PENGEMBALIAN) {
            $order->update(['status' => Order::STATUS_MENUNGGU_PENGEMBALIAN_PENJUAL]);
            return back()->with('success', 'Refund disetujui Admin & diteruskan ke Penjual untuk konfirmasi.');
        }
        return back()->with('error', 'Pesanan tidak dalam status menunggu pengembalian admin.');
    }

    public function rejectRefund($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status === Order::STATUS_MENUNGGU_PENGEMBALIAN) {
            $order->update(['status' => Order::STATUS_SELESAI]);
            return back()->with('success', 'Komplain ditolak, pesanan dikembalikan ke status selesai.');
        }
        return back()->with('error', 'Pesanan tidak dalam status menunggu pengembalian.');
    }
    public function storeBanner(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'badge_text' => 'nullable|string|max:50',
            'title' => 'nullable|string|max:100',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:255',
            'banner_id' => 'nullable|exists:homepage_banners,id'
        ]);

        $data = $request->except(['_token', 'image', 'banner_id']);
        $data['user_id'] = auth()->id();
        $data['is_active'] = true;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }

        if ($request->filled('banner_id')) {
            $banner = \App\Models\HomepageBanner::where('id', $request->banner_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
            $banner->update($data);
            return back()->with('success', 'Banner berhasil diperbarui!');
        }

        if (!isset($data['image_path'])) {
            return back()->with('error', 'Gambar banner wajib diunggah untuk banner baru.');
        }

        \App\Models\HomepageBanner::create($data);
        return back()->with('success', 'Banner baru berhasil ditambahkan!');
    }

    public function destroyBanner($id)
    {
        $banner = \App\Models\HomepageBanner::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        // Don't delete seeded default images in public/images/
        if ($banner->image_path && !str_starts_with($banner->image_path, 'images/') && \Storage::disk('public')->exists($banner->image_path)) {
            \Storage::disk('public')->delete($banner->image_path);
        }
        
        $banner->delete();
        
        return back()->with('success', 'Banner berhasil dihapus!');
    }
}
