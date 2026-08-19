<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\PaymentMethod;

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
        $product = Product::find($id);
        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan atau sudah dihapus.');
        }

        $product->update([
            'is_active' => true,
            'approval_status' => 'approved',
        ]);

        return back()->with('success', "Produk '{$product->name}' berhasil disetujui dan diterbitkan ke toko!");
    }

    public function rejectProduct(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan atau sudah dihapus.');
        }

        $product->update([
            'is_active' => false,
            'approval_status' => 'rejected',
        ]);

        return back()->with('success', "Pengajuan produk '{$product->name}' telah ditolak.");
    }

    public function transactions()
    {
        $orders = Order::with(['user', 'seller', 'items.product', 'refunds'])->latest()->paginate(20);
        return view('Admin.transactions.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with(['user', 'seller', 'items.product.images', 'payments', 'refunds'])
            ->findOrFail($id);

        $paymentMethods = PaymentMethod::active()->orderBy('sort_order')->get();

        return view('Admin.transactions.show', compact('order', 'paymentMethods'));
    }

    public function invoiceOrder($id)
    {
        $order = Order::with(['user', 'seller', 'items.product.images', 'payments', 'refunds'])
            ->findOrFail($id);

        return view('order.invoice', compact('order'));
    }

    public function approveRefund(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== Order::STATUS_MENUNGGU_PENGEMBALIAN) {
            return back()->with('error', 'Pesanan tidak dalam status menunggu pengembalian admin.');
        }

        $request->validate([
            'proof_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
            'transfer_reference' => 'nullable|string|max:100',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $proofPath = $request->file('proof_image')->store('refunds', 'public');

        $refund = $order->refunds()->latest()->first();

        if ($refund) {
            $refund->update([
                'status' => Refund::STATUS_PROOF_SENT,
                'proof_path' => $proofPath,
                'transfer_reference' => $request->transfer_reference,
                'admin_note' => $request->admin_note,
                'handled_by' => auth()->id(),
                'proof_sent_at' => now(),
                'dispute_reason' => null,
                'investigation_note' => null,
            ]);
        }

        $order->update(['status' => Order::STATUS_MENUNGGU_KONFIRMASI_PEMBELI]);

        return back()->with('success', 'Refund disetujui & bukti transfer terkirim ke pembeli untuk konfirmasi.');
    }

    public function rejectRefund(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!in_array($order->status, [Order::STATUS_MENUNGGU_PENGEMBALIAN, Order::STATUS_MENUNGGU_KONFIRMASI_PEMBELI])) {
            return back()->with('error', 'Pesanan tidak dalam status menunggu pengembalian.');
        }

        $request->validate([
            'reason' => 'required|string|min:5',
        ]);

        $refund = $order->refunds()->latest()->first();

        if ($refund) {
            $refund->update([
                'status' => Refund::STATUS_REJECTED,
                'rejection_reason' => $request->reason,
                'handled_by' => auth()->id(),
            ]);
        }

        if ($request->boolean('fraud')) {
            $order->user()->increment('refund_warnings');
            $warnings = (int) $order->user()->value('refund_warnings');
            if ($warnings >= 3) {
                $order->user()->update(['account_restricted' => true]);
            }
        }

        $order->update(['status' => Order::STATUS_SELESAI]);

        $fraudNote = $request->boolean('fraud') ? ' Pengajuan ditandai palsu dan peringatan dicatat ke akun pembeli.' : '';
        return back()->with('success', 'Pengajuan refund ditolak, pesanan kembali ke status selesai.' . $fraudNote);
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
