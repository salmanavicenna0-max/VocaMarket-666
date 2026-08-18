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

        if ($user->role === 'pembeli') {
            return redirect()->route('orders.index')->with('error', 'Role pembeli tidak memiliki akses ke halaman dashboard penjual.');
        }

        if ($user->isAdmin()) {
            $products = Product::with(['images', 'seller'])->latest()->get();
            $orders = \App\Models\Order::where('status', '!=', 'menunggu_pembayaran')
                ->with(['items.product', 'user', 'payments'])
                ->latest()
                ->get();
        } else {
            $products = $user->products()->with('images')->latest()->get();
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
        $homepageBanners = \App\Models\HomepageBanner::where('user_id', $user->id)->get();

        $pendingProducts = Product::with(['seller', 'images'])
            ->where('approval_status', 'pending')
            ->latest()
            ->get();

        $allUsers = $user->isAdmin() ? \App\Models\User::latest()->get() : collect();

        $salesData = $this->buildSalesData($orders);

        return view('seller.products', compact('products', 'orders', 'reviews', 'totalRevenue', 'completedOrders', 'totalProducts', 'user', 'profile', 'pendingOrdersCount', 'ordersSiapDikirim', 'totalReviewsCount', 'homepageBanners', 'pendingProducts', 'allUsers', 'salesData'));
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
            'images' => 'nullable|array|max:10',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,webm,mov,ogg,m4v|max:51200'
        ]);

        $isAdmin = Auth::user()->isAdmin();

        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'category' => $request->category,
            'type' => $request->sub_category,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'is_active' => $isAdmin ? true : false,
            'approval_status' => $isAdmin ? 'approved' : 'pending',
        ]);

        if ($request->hasFile('images')) {
            $firstPath = null;
            foreach ($request->file('images') as $index => $file) {
                if ($index >= 10) break; // Limit to max 10 files
                $path = $file->store('products', 'public');
                if ($index === 0) {
                    $firstPath = $path;
                }
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
            if ($firstPath) {
                $product->update(['image_path' => $firstPath]);
            }
        }

        if ($isAdmin) {
            return back()->with('success', 'Produk berhasil ditambahkan dan langsung aktif!');
        } else {
            return back()->with('success', 'Pengajuan berhasil dikirim! Menunggu konfirmasi admin.');
        }
    }

    public function updateProduct(Request $request, $id)
    {
        if (Auth::user()->isAdmin()) {
            $product = Product::find($id);
        } else {
            $product = Product::where('user_id', Auth::id())->find($id);
        }

        if (!$product) {
            return back()->with('error', 'Produk tidak ditemukan atau sudah dihapus.');
        }

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

        return back()->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroyProduct($id)
    {
        if (Auth::user()->isAdmin()) {
            $product = Product::with('images')->find($id);
        } else {
            $product = Product::with('images')->where('user_id', Auth::id())->find($id);
        }

        if (!$product) {
            return back()->with('success', 'Produk sudah tidak ada atau telah dihapus sebelumnya.');
        }

        // Delete image files from storage
        foreach ($product->images as $img) {
            if ($img->path && \Illuminate\Support\Facades\Storage::disk('public')->exists($img->path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($img->path);
            }
        }
        if ($product->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus!');
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
    public function storeHomepageBanner(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|max:3072',
            'badge_text' => 'nullable|string|max:50',
            'title' => 'nullable|string|max:100',
            'subtitle' => 'nullable|string|max:200',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:255',
            'banner_id' => 'nullable|exists:homepage_banners,id'
        ]);

        $data = [
            'badge_text' => $request->badge_text,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'button_text' => $request->button_text ?? 'Lihat Toko',
            'button_link' => $request->button_link,
            'user_id' => Auth::id(),
            'is_active' => true,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }

        if ($request->filled('banner_id')) {
            $banner = \App\Models\HomepageBanner::where('id', $request->banner_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            $banner->update($data);
            return back()->with('success', 'Banner beranda berhasil diperbarui!');
        }

        if (!isset($data['image_path'])) {
            return back()->with('error', 'Silakan unggah gambar banner terlebih dahulu untuk banner baru.');
        }

        \App\Models\HomepageBanner::create($data);
        return back()->with('success', 'Banner beranda baru berhasil ditambahkan!');
    }

    public function destroyHomepageBanner($id)
    {
        $banner = \App\Models\HomepageBanner::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        if ($banner->image_path && !str_starts_with($banner->image_path, 'images/') && \Storage::disk('public')->exists($banner->image_path)) {
            \Storage::disk('public')->delete($banner->image_path);
        }
        
        $banner->delete();
        
        return back()->with('success', 'Banner berhasil dihapus!');
    }

    public function getDashboardData()
    {
        $user = Auth::user();
        $orders = $user->salesOrders()
            ->where('status', 'selesai')
            ->with(['items.product'])
            ->get();

        $salesData = $this->buildSalesData($orders);

        return response()->json([
            'labels' => $salesData['labels'],
            'data' => $salesData['data'],
            'totalRevenue' => $orders->sum('total'),
            'completedOrders' => $orders->count(),
        ]);
    }

    private function buildSalesData($orders)
    {
        $monthlyRevenue = array_fill(1, 12, 0);

        foreach ($orders->where('status', 'selesai') as $order) {
            $monthKey = (int) $order->created_at->format('n');
            $monthlyRevenue[$monthKey] += (int) $order->total;
        }

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        return [
            'labels' => $monthNames,
            'data' => array_values($monthlyRevenue),
        ];
    }
}
