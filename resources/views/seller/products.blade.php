@extends('layouts.app')
@section('title', 'Kelola Produk - Pusat Penjual')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 mb-6 max-w-6xl mx-auto" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ url('/') }}" class="hover:text-primary transition flex items-center gap-1">
                    <i class="ph-fill ph-house"></i> Beranda
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="ph-bold ph-caret-right text-gray-400 mx-1 text-xs"></i>
                    <a href="{{ url('/user') }}" class="hover:text-primary transition">Profil</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="ph-bold ph-caret-right text-gray-400 mx-1 text-xs"></i>
                    <span class="text-gray-900 font-medium">Pusat Penjual</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-6 relative">
        
        <!-- Mobile Sidebar Toggle -->
        <div class="lg:hidden bg-white p-4 border border-gray-200 rounded-xl flex justify-between items-center shadow-sm mb-2 sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center shrink-0">
                    <i class="ph-fill ph-storefront text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm leading-tight text-gray-900">Toko Saya</h3>
                    <p class="text-gray-500 text-xs">{{ $user->name }}</p>
                </div>
            </div>
            <button id="seller-sidebar-toggle" class="p-2 text-gray-600 hover:text-primary transition bg-gray-50 rounded-lg">
                <i class="ph-bold ph-list text-2xl"></i>
            </button>
        </div>

        <!-- Sidebar Penjual -->
        <div id="seller-sidebar" class="lg:col-span-1 flex-col gap-4 hidden lg:flex absolute lg:relative w-full z-10 bg-white lg:bg-transparent rounded-xl shadow-lg lg:shadow-none p-4 lg:p-0 border border-gray-200 lg:border-none top-[80px] lg:top-0">
            
            <div class="bg-primary rounded-xl shadow-sm p-5 text-white hidden lg:flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shrink-0">
                    <i class="ph-fill ph-storefront text-2xl text-primary"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg leading-tight">Toko Saya</h3>
                    <p class="text-blue-100 text-xs">{{ $user->name }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <ul class="flex flex-col" id="nav-tabs">
                    <li>
                        <button onclick="switchTab('dashboard')" id="nav-dashboard" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-squares-four text-xl"></i> Dashboard
                        </button>
                    </li>
                    <li>
                        <button onclick="switchTab('produk')" id="nav-produk" class="w-full text-left flex items-center gap-3 px-5 py-4 text-primary font-medium bg-blue-50 border-l-4 border-primary transition">
                            <i class="ph-fill ph-package text-xl"></i> Produk Saya
                        </button>
                    </li>
                    <li>
                        <button onclick="switchTab('pesanan')" id="nav-pesanan" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent flex justify-between">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-shopping-bag text-xl"></i> Pesanan Masuk
                            </div>
                            @if($pendingOrdersCount > 0)
                                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingOrdersCount }}</span>
                            @endif
                        </button>
                    </li>
                    <li>
                        <button onclick="switchTab('ulasan')" id="nav-ulasan" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent flex justify-between">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-star text-xl"></i> Ulasan Pembeli
                            </div>
                            @if($totalReviewsCount > 0)
                                <span class="bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $totalReviewsCount }}</span>
                            @endif
                        </button>
                    </li>
                    @if(Auth::user()->isAdmin())
                    <li>
                        <button onclick="switchTab('pengajuanproduk')" id="nav-pengajuanproduk" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent flex justify-between">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-package text-xl text-yellow-500"></i> Pengajuan Produk Siswa
                            </div>
                        </button>
                    </li>
                    @endif
                    <li>
                        <button onclick="switchTab('konfigurasitoko')" id="nav-konfigurasitoko" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-sliders text-xl"></i> Konfigurasi Toko
                        </button>
                    </li>
                    <li>
                        <button onclick="switchTab('statustoko')" id="nav-statustoko" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-check-circle text-xl"></i> Status Toko
                        </button>
                    </li>
                    @if(Auth::user()->seller_status === 'approved')
                    <li>
                        <button onclick="switchTab('bannerberanda')" id="nav-bannerberanda" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-image text-xl"></i> Banner Beranda
                        </button>
                    </li>
                    @endif
                </ul>
            </div>

        </div>

        <!-- Konten Kanan: Tab Area -->
        <div class="lg:col-span-3">

            <!-- TAB: Dashboard -->
            <div id="tab-dashboard" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Dashboard Toko</h2>
                        <p class="text-gray-500 text-sm mt-1">Ringkasan performa toko Anda bulan ini</p>
                    </div>
                    <select id="dashboardTimeFilter" onchange="updateDashboardStats()" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary bg-white transition cursor-pointer">
                        <option value="bulan">Bulan Ini</option>
                        <option value="minggu">7 Hari Terakhir</option>
                        <option value="tahun">Tahun Ini</option>
                    </select>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Grid Statistik Kunci -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Card 1 -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200 flex flex-col justify-center transition hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-primary">
                                    <i class="ph-fill ph-wallet text-xl"></i>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">Total Pendapatan</p>
                            <h3 id="statPendapatan" class="text-2xl font-bold text-gray-900 mt-1 transition-all duration-300">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200 flex flex-col justify-center transition hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-green-600">
                                    <i class="ph-fill ph-shopping-bag text-xl"></i>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">Pesanan Selesai</p>
                            <h3 id="statPesanan" class="text-2xl font-bold text-gray-900 mt-1 transition-all duration-300">{{ $completedOrders }}</h3>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200 flex flex-col justify-center transition hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-purple-600">
                                    <i class="ph-fill ph-package text-xl"></i>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">Total Produk</p>
                            <h3 id="statProduk" class="text-2xl font-bold text-gray-900 mt-1 transition-all duration-300">{{ $totalProducts }}</h3>
                        </div>

                        <!-- Card 4 -->
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200 flex flex-col justify-center transition hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-orange-600">
                                    <i class="ph-fill ph-eye text-xl"></i>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">Kunjungan Toko</p>
                            <h3 id="statKunjungan" class="text-2xl font-bold text-gray-900 mt-1 transition-all duration-300">{{ $visitorCount ?? 0 }}</h3>
                        </div>
                    </div>

                    <!-- Progress Pesanan & Status -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2 border border-gray-200 rounded-xl p-5 bg-gray-50/50">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-bold text-gray-900">Performa Penjualan</h4>
                                <button class="text-sm text-primary font-medium hover:underline">Lihat Detail</button>
                            </div>
                            <div class="h-48 flex items-end gap-2 justify-between mt-6 px-2">
                                <canvas id="salesChart" width="400" height="200" class="max-w-full"></canvas>
                            </div>
                            <div class="flex justify-between text-xs text-gray-400 mt-2 px-2 font-medium">
                                <span>Sen</span>
                                <span>Sel</span>
                                <span>Rab</span>
                                <span class="text-primary font-bold">Kam</span>
                                <span>Jum</span>
                                <span>Sab</span>
                                <span>Min</span>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-xl p-5 flex flex-col gap-4">
                            <h4 class="font-bold text-gray-900 mb-2">Tugas Menunggu</h4>

                            <div onclick="switchTab('pesanan')" class="flex items-center justify-between p-3 bg-red-50 text-red-700 rounded-lg border border-red-100 cursor-pointer hover:bg-red-100 transition">
                                <div class="flex items-center gap-2">
                                    <i class="ph-bold ph-warning-circle text-xl"></i>
                                    <span class="font-bold text-sm">Pesanan Baru</span>
                                </div>
                                @if($pendingOrdersCount > 0)
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingOrdersCount }}</span>
                                @endif
                            </div>

                            <div onclick="switchTab('pesanan')" class="flex items-center justify-between p-3 bg-yellow-50 text-yellow-700 rounded-lg border border-yellow-100 cursor-pointer hover:bg-yellow-100 transition">
                                <div class="flex items-center gap-3">
                                    <i class="ph-bold ph-truck text-xl"></i>
                                    <span class="font-bold text-sm">Siap Dikirim</span>
                                </div>
<span class="font-bold text-sm">{{ $ordersSiapDikirim }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: Produk Saya -->
            <div id="tab-produk" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Produk Saya</h2>
                        <p class="text-gray-500 text-sm mt-1">Kelola daftar produk, stok, dan harga jualan Anda</p>
                    </div>
                    <button onclick="openAddProductModal()" class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-sm transition flex items-center gap-2">
                        <i class="ph-bold ph-plus"></i> Tambah Produk Baru
                    </button>
                </div>

                <div class="p-4 border-b border-gray-100 flex gap-4">
                    <div class="relative flex-1 max-w-sm">
                        <i class="ph ph-magnifying-glass absolute left-3 top-2.5 text-gray-400 text-lg"></i>
                        <input type="text" id="searchProduk" onkeyup="filterProduk()" placeholder="Cari nama produk..." class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:border-primary text-sm transition">
                    </div>
                    <select id="filterKategoriProduk" onchange="filterProduk()" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary bg-white transition cursor-pointer">
                        <option value="">Semua Kategori</option>
                        <option value="Barang Fisik">Barang Fisik</option>
                        <option value="Jasa">Jasa</option>
                        <option value="Makanan">Makanan</option>
                    </select>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm border-b border-gray-200">
                                <th class="p-4 font-bold w-[40%]">Info Produk</th>
                                <th class="p-4 font-bold text-center">Harga</th>
                                <th class="p-4 font-bold text-center">Stok / Status</th>
                                <th class="p-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($products as $product)
                            <tr class="produk-row hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <div class="flex gap-4 items-center">
                                        @if($product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="w-16 h-16 rounded-lg object-cover border border-gray-200 shrink-0">
                                        @else
                                            <div class="w-16 h-16 rounded-lg bg-gray-100 border border-gray-200 shrink-0 flex items-center justify-center text-gray-400">
                                                <i class="ph-fill ph-image text-2xl"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm line-clamp-2">{{ $product->name }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">Kategori: {{ $product->category }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="font-bold text-primary">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex flex-col items-center gap-1">
                                        @if($product->approval_status === 'pending' || (!$product->is_active && $product->approval_status !== 'rejected'))
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-1 rounded-full border border-yellow-200 inline-flex items-center">
                                                <i class="ph-bold ph-clock mr-1"></i> Menunggu Admin
                                            </span>
                                        @elseif($product->approval_status === 'rejected')
                                            <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full border border-red-200 inline-flex items-center">
                                                <i class="ph-bold ph-x-circle mr-1"></i> Ditolak
                                            </span>
                                        @else
                                            @if($product->stock > 0)
                                                <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full inline-flex items-center">
                                                    <i class="ph-bold ph-check-circle mr-1"></i> Aktif (Stok: {{ $product->stock }})
                                                </span>
                                            @else
                                                <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2.5 py-1 rounded-full border border-gray-200">Habis</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-2">
                                        <button type="button" onclick='openEditProductModal({{ $product->id }}, @json($product->name), {{ $product->price }}, @json($product->category), @json($product->type), @json($product->description), {{ $product->stock }})' class="p-2 text-blue-600 hover:bg-blue-100 rounded transition tooltip" title="Edit">
                                            <i class="ph-bold ph-pencil-simple text-lg"></i>
                                        </button>
                                        <form action="{{ route('seller.product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded transition tooltip" title="Hapus">
                                                <i class="ph-bold ph-trash text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center p-4 text-gray-500">Belum ada produk.</td></tr>
                            @endforelse
</tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-gray-200 flex justify-between items-center text-sm text-gray-500">
                    <p>Menampilkan 3 produk</p>
                    <div class="flex gap-1">
                        <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 hover:bg-gray-50" disabled><i class="ph-bold ph-caret-left"></i></button>
                        <button class="w-8 h-8 flex items-center justify-center rounded border border-primary bg-primary text-white font-bold">1</button>
                        <button class="w-8 h-8 flex items-center justify-center rounded border border-gray-300 hover:bg-gray-50"><i class="ph-bold ph-caret-right"></i></button>
                    </div>
                </div>
            </div>

            <!-- TAB: Pesanan Masuk -->
            <div id="tab-pesanan" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Pesanan Masuk</h2>
                    <p class="text-gray-500 text-sm mt-1">Kelola dan proses pesanan dari pelanggan Anda</p>
                </div>

                <!-- Horizontal Tabs for Status -->
                <div id="filter-pesanan-container" class="flex overflow-x-auto border-b border-gray-200 whitespace-nowrap">
                    <button onclick="filterPesanan('Semua', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-primary text-primary font-bold text-sm transition">Semua</button>
                    <button onclick="filterPesanan('Perlu Diproses', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition relative">
                        Perlu Diproses
                        @if($pendingOrdersCount > 0)
                            <span id="badge-diproses" class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">{{ $pendingOrdersCount }}</span>
                        @endif
                    </button>
                    <button onclick="filterPesanan('Selesai', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Selesai</button>
                    <button onclick="filterPesanan('Dibatalkan', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Dibatalkan</button>
                    <button onclick="filterPesanan('Pengembalian', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Pengembalian</button>
                </div>

                <div class="p-6 flex flex-col gap-4">
                    @forelse($orders as $order)
                    <div class="pesanan-item border border-gray-200 rounded-xl overflow-hidden hover:border-primary transition border-l-4 {{ $order->status == 'menunggu_pembayaran' ? 'border-l-yellow-400' : 'border-l-blue-400' }}" data-status="{{ $order->status_label }}">
                        <div class="bg-gray-50 p-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-user-circle text-gray-500 text-xl"></i>
                                <div>
                                    <span class="font-bold text-gray-900">{{ $order->user->name ?? 'Guest' }}</span>
                                    <p class="text-[10px] text-gray-500">{{ $order->code_order }}</p>
                                </div>
                            </div>
                            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded border border-blue-200">{{ $order->status_label }}</span>
                        </div>
                        <div class="p-4 flex gap-4 flex-col">
                            @foreach($order->items as $item)
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900">{{ $item->name_snapshot }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $item->quantity }} barang x Rp{{ number_format($item->price_snapshot, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            @endforeach
                            <div class="text-right flex flex-col justify-between shrink-0 mt-4 border-t pt-2">
                                <div>
                                    <p class="text-xs text-gray-500">Total Pembayaran</p>
                                    <p class="font-bold text-primary text-lg">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                          <div class="p-4 border-t border-gray-100 flex flex-wrap justify-between items-center gap-4 bg-gray-50">

                              <!-- Lihat Bukti Bayar -->
                              <div>
                                  @if($order->payments && $order->payments->count() > 0)
                                      <a href="{{ asset('storage/' . $order->payments->last()->payment_proof) }}" target="_blank" class="text-primary text-sm font-bold hover:underline flex items-center gap-1">
                                          <i class="ph-bold ph-image"></i> Lihat Bukti Pembayaran
                                      </a>
                                  @endif
                              </div>

                              <div class="flex justify-end gap-2">
                                  @if($order->status == 'menunggu_verifikasi' || $order->status == 'diproses')
                                      <form action="{{ route('seller.order.status', $order->id) }}" method="POST">
                                          @csrf
                                          <input type="hidden" name="status" value="dibatalkan">
                                          <button type="submit" class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-bold hover:bg-red-50 transition focus:outline-none">Tolak / Batalkan</button>
                                      </form>
                                  @endif

                                   @if($order->status == 'menunggu_pengembalian')
                                       <form action="{{ route('admin.refund.approve', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Setujui refund ini dan teruskan ke penjual?');">
                                           @csrf
                                           <button type="submit" class="px-4 py-2 bg-yellow-500 text-gray-900 rounded-lg text-sm font-extrabold hover:bg-yellow-400 transition shadow-sm focus:outline-none flex items-center gap-1">
                                               <i class="ph-bold ph-check"></i> Setujui Refund (Teruskan ke Penjual)
                                           </button>
                                       </form>
                                       <form action="{{ route('admin.refund.reject', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak refund ini?');">
                                           @csrf
                                           <button type="submit" class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-bold hover:bg-red-50 transition focus:outline-none">Tolak Refund</button>
                                       </form>
                                   @endif
                                   @if($order->status == 'menunggu_pengembalian_penjual')
                                       <form action="{{ route('seller.refund.approve', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Setujui refund ini?');">
                                           @csrf
                                           <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-bold hover:bg-green-700 transition shadow-sm focus:outline-none">Konfirmasi Refund Penjual</button>
                                       </form>
                                       <form action="{{ route('seller.refund.reject', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Tolak refund?');">
                                           @csrf
                                           <button type="submit" class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-bold hover:bg-red-50 transition focus:outline-none">Tolak Refund</button>
                                       </form>
                                   @endif
                                   @if($order->status == 'menunggu_verifikasi')
                                      <form action="{{ route('seller.order.status', $order->id) }}" method="POST">
                                          @csrf
                                          <input type="hidden" name="status" value="diproses">
                                          <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-sm focus:outline-none">Konfirmasi Pembayaran</button>
                                      </form>
                                  @elseif($order->status == 'diproses')
                                      <form action="{{ route('seller.order.status', $order->id) }}" method="POST">
                                          @csrf
                                          <input type="hidden" name="status" value="selesai">
                                          <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-bold hover:bg-green-600 transition shadow-sm focus:outline-none">Tandai Selesai</button>
                                      </form>
                                  @endif
                              </div>
                          </div>
                    </div>
                    @empty
                    <div class="text-center p-8 text-gray-500">Belum ada pesanan.</div>
                    @endforelse
</div>
            </div>

            <!-- TAB: Ulasan -->
            <div id="tab-ulasan" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Ulasan Pembeli</h2>
                    <p class="text-gray-500 text-sm mt-1">Lihat umpan balik dari pembeli terhadap produk Anda</p>
                </div>

                <div class="p-6">
                    <div class="flex flex-col gap-4">
                        @forelse($reviews as $review)
                        <div class="border border-gray-200 rounded-lg p-5">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h4 class="font-bold text-gray-800">{{ $review->product->name }}</h4>
                                    <p class="text-xs text-gray-500">Oleh: {{ $review->user->name }} - {{ $review->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex text-yellow-500">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="ph-fill ph-star"></i>
                                        @else
                                            <i class="ph ph-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg text-sm text-gray-700">
                                "{{ $review->comment ?: 'Tidak ada komentar tertulis.' }}"
                            </div>
                        </div>
                        @empty
                        <div class="text-center p-8 text-gray-500">Belum ada ulasan untuk produk Anda.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- TAB: Konfigurasi Toko -->
            <div id="tab-konfigurasitoko" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200 bg-blue-50/50 rounded-t-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <i class="ph-fill ph-sliders text-primary"></i> Konfigurasi Profil Toko
                        </h2>
                        <p class="text-gray-500 text-sm mt-1">Atur banner sampul, nama, dan informasi toko Anda agar terlihat menarik bagi calon pembeli</p>
                    </div>
                    <a href="{{ route('seller.profile', Auth::id()) }}" target="_blank" class="px-4 py-2 bg-white text-primary font-bold border border-primary rounded-lg shadow-sm hover:bg-blue-50 transition text-sm flex items-center gap-1.5 shrink-0">
                        <i class="ph-bold ph-arrow-square-out"></i> Lihat Halaman Toko
                    </a>
                </div>

                <form action="{{ route('user.store.update') }}" method="POST" enctype="multipart/form-data" class="p-6 flex flex-col gap-6">
                    @csrf

                    <!-- Banner Toko Field -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Banner Sampul Toko</label>
                        <div class="relative w-full h-44 rounded-xl overflow-hidden border border-gray-300 bg-gray-100 flex items-center justify-center mb-2 shadow-inner">
                            @if($profile && $profile->banner_toko)
                                <img src="{{ asset('storage/' . $profile->banner_toko) }}" alt="Banner Toko" id="banner-preview-seller" class="w-full h-full object-cover">
                            @else
                                <div id="banner-placeholder-seller" class="text-center text-gray-400 flex flex-col items-center">
                                    <i class="ph-fill ph-image text-5xl mb-1 text-gray-300"></i>
                                    <span class="text-xs font-medium">Belum ada banner khusus (menggunakan tampilan default)</span>
                                </div>
                                <img id="banner-preview-seller" class="w-full h-full object-cover hidden">
                            @endif
                        </div>
                        <input type="file" name="banner_toko" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 transition cursor-pointer" onchange="previewSellerBanner(event)">
                        <p class="text-xs text-gray-500 mt-1">Rekomendasi banner: Rasio lanskap (contoh: 1200 x 400 pixel, Maks: 3MB).</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Toko</label>
                        <input type="text" name="nama_toko" value="{{ old('nama_toko', $profile->nama_toko ?? ('Toko ' . $user->name)) }}" placeholder="Masukkan nama toko Anda..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition" required>
                        <p class="text-xs text-gray-500 mt-1">Nama ini akan menjadi judul utama di halaman profil toko Anda.</p>
                    </div>

                    <!-- Color Picker Warna Judul Toko -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Warna Teks Judul Toko</label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="warna_judul_toko" name="warna_judul_toko" value="{{ old('warna_judul_toko', $profile->warna_judul_toko ?? '#111827') }}" oninput="document.getElementById('hex_judul_toko').value = this.value" class="w-12 h-10 border border-gray-300 rounded-lg p-1 cursor-pointer bg-white">
                            <input type="text" id="hex_judul_toko" value="{{ old('warna_judul_toko', $profile->warna_judul_toko ?? '#111827') }}" readonly class="w-28 border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-700 font-mono text-center">
                            <span class="text-xs text-gray-500">Pilih warna teks agar judul toko Anda kontras dan terlihat jelas di atas banner.</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Tentang Penjual / Deskripsi Toko</label>
                        <textarea name="deskripsi_toko" rows="4" placeholder="Tuliskan deskripsi singkat mengenai produk, jasa, atau toko Anda..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">{{ old('deskripsi_toko', $profile->deskripsi_toko) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Deskripsi ini akan ditampilkan pada bagian "Tentang Penjual" di halaman profil toko.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Lokasi Toko / Alamat Sekolah</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $profile->alamat ?? 'SMK Bakti Nusantara 666') }}" placeholder="Contoh: SMK Bakti Nusantara 666" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Nomor HP / WhatsApp Toko</label>
                            <input type="text" name="no_telp" value="{{ old('no_telp', $profile->no_telp) }}" placeholder="Contoh: 085156699111" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-sm flex items-center gap-2">
                            <i class="ph-bold ph-floppy-disk"></i> Simpan Konfigurasi Toko
                        </button>
                    </div>
                </form>
            </div>

            @if(Auth::user()->isAdmin())
            <!-- TAB: Pengajuan Produk Siswa (Admin Moderasi) -->
            <div id="tab-pengajuanproduk" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden overflow-hidden">
                <div class="p-6 space-y-6">
                    <div class="overflow-x-auto border border-gray-200 rounded-xl">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 text-xs font-bold uppercase border-b border-gray-200">
                                    <th class="p-4">Produk / Jasa</th>
                                    <th class="p-4">Siswa / Penjual</th>
                                    <th class="p-4">Kategori & Tipe</th>
                                    <th class="p-4 text-center">Harga</th>
                                    <th class="p-4 text-center">Stok</th>
                                    <th class="p-4 text-center">Aksi Moderasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($pendingProducts ?? [] as $product)
                                <tr class="hover:bg-yellow-50/30 transition">
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden shrink-0 relative">
                                                @if($product->images->isNotEmpty())
                                                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <i class="ph-fill ph-image text-lg"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 text-sm line-clamp-1">{{ $product->name }}</h4>
                                                <p class="text-xs text-gray-500 line-clamp-1">{{ $product->description }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 font-semibold text-gray-800">
                                        {{ $product->seller->name ?? 'Siswa' }}
                                    </td>
                                    <td class="p-4">
                                        <span class="bg-blue-50 text-blue-700 text-xs font-bold px-2 py-0.5 rounded border border-blue-100">
                                            {{ $product->category }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center font-bold text-primary">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 text-center font-bold text-gray-700">
                                        {{ $product->stock }}
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('admin.products.approve', $product->id) }}" method="POST" onsubmit="return confirm('Setujui dan publikasikan produk ini ke toko?');">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition shadow-sm flex items-center gap-1">
                                                    <i class="ph-bold ph-check"></i> Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.products.reject', $product->id) }}" method="POST" onsubmit="return confirm('Tolak pengajuan produk ini?');">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-600 text-xs font-bold rounded-lg transition flex items-center gap-1">
                                                    <i class="ph-bold ph-x"></i> Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-500">
                                        <p class="font-bold text-gray-700 text-sm">Tidak ada pengajuan produk baru dari siswa.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif



            <!-- TAB: Banner Beranda -->
            @if(Auth::user()->seller_status === 'approved')
            <div id="tab-bannerberanda" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200 bg-blue-50/50 rounded-t-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <i class="ph-fill ph-image text-primary"></i> Pengaturan Banner Beranda (Homepage)
                        </h2>
                        <p class="text-gray-500 text-sm mt-1">Kelola banner promosi toko Anda. Resolusi yang direkomendasikan adalah 1200x450 pixel (Landscape).</p>
                    </div>
                    <button onclick="openBannerModal()" class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-sm flex items-center gap-2 shrink-0">
                        <i class="ph-bold ph-plus"></i> Tambah Banner Baru
                    </button>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6">
                        @if(isset($homepageBanners) && $homepageBanners->count() > 0)
                            @foreach($homepageBanners as $banner)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col md:flex-row">
                                <div class="w-full md:w-1/3 bg-gray-100">
                                    <img src="{{ str_starts_with($banner->image_path, 'images/') ? asset($banner->image_path) : asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" class="w-full h-48 object-cover">
                                </div>
                                <div class="p-6 flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center gap-3 mb-2">
                                            @if($banner->badge_text)
                                                <span class="bg-accent text-gray-900 text-xs font-bold px-2.5 py-1 rounded-full uppercase">{{ $banner->badge_text }}</span>
                                            @endif
                                            @if($banner->is_active)
                                                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded border border-green-200">Aktif</span>
                                            @endif
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $banner->title ?? '(Tanpa Judul)' }}</h3>
                                        <p class="text-gray-600 text-sm mb-4">{{ $banner->subtitle }}</p>
                                        <div class="flex items-center gap-2 text-sm">
                                            <span class="text-gray-500 font-medium">Tombol:</span>
                                            <span class="font-bold text-primary">{{ $banner->button_text ?? '-' }}</span>
                                            <span class="text-gray-400">&rarr;</span>
                                            <a href="{{ $banner->button_link }}" target="_blank" class="text-blue-500 hover:underline">{{ $banner->button_link ?? '-' }}</a>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                                        <button onclick='editBanner(@json($banner))' class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50 transition flex items-center gap-2">
                                            <i class="ph-bold ph-pencil-simple"></i> Edit
                                        </button>
                                        <form action="{{ route('seller.homepage_banner.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg text-sm font-bold hover:bg-red-100 transition flex items-center gap-2">
                                                <i class="ph-bold ph-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="bg-gray-50 rounded-xl border border-gray-200 p-12 text-center flex flex-col items-center">
                                <i class="ph-fill ph-images text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Banner</h3>
                                <p class="text-gray-500 max-w-md">Anda belum mengunggah banner promosi. Klik tombol "Tambah Banner Baru" untuk mulai menambahkan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<!-- Modal Tambah Produk -->
<div id="addProductModal" class="fixed inset-0 z-[100] hidden bg-gray-900/50 backdrop-blur-sm flex items-start justify-center overflow-y-auto pt-4 pb-10 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl transform scale-95 transition-transform duration-300 relative mt-4 mb-auto">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
            <h3 class="font-bold text-lg text-gray-900">Tambah Produk Baru</h3>
            <button onclick="closeAddProductModal()" class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors focus:outline-none">
                <i class="ph-bold ph-x text-xl"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6">
            <form id="formTambahProduk" action="{{ route('seller.product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <!-- Info Dasar -->
                <div class="space-y-4">
                    <h4 class="font-bold text-gray-900 border-b border-gray-100 pb-2">1. Informasi Produk</h4>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="name" placeholder="Contoh: Jasa Desain Logo Esport" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori / Jurusan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="category" id="kategoriUtama" onchange="updateSubKategori()" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 appearance-none focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white transition">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <optgroup label="Produk Sekolah">
                                        <option value="Aksesoris">Aksesoris</option>
                                        <option value="Merchandise">Merchandise</option>
                                        <option value="Hardware">Hardware</option>
                                    </optgroup>
                                    <optgroup label="Jasa Setiap Jurusan">
                                        <option value="DKV & Animasi">DKV & Animasi</option>
                                        <option value="Pemasaran">Pemasaran</option>
                                        <option value="PPLG">PPLG</option>
                                        <option value="Akuntansi">Akuntansi</option>
                                    </optgroup>
                                </select>
                                <i class="ph-bold ph-caret-down absolute right-4 top-3.5 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sub/Isi Kategori <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="sub_category" id="subKategori" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 appearance-none focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white transition disabled:bg-gray-100 disabled:cursor-not-allowed" disabled>
                                    <option value="" disabled selected>Pilih Kategori Utama Dulu</option>
                                </select>
                                <i class="ph-bold ph-caret-down absolute right-4 top-3.5 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk <span class="text-red-500">*</span></label>
                        <textarea rows="4" name="description" placeholder="Jelaskan detail layanan atau produk yang Anda jual..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required></textarea>
                    </div>
                </div>

                <!-- Harga & Stok -->
                <div class="space-y-4 pt-2">
                    <h4 class="font-bold text-gray-900 border-b border-gray-100 pb-2">2. Harga & Stok</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-2.5 text-gray-500 font-medium">Rp</span>
                                <input type="text" name="price" id="addProductPrice" oninput="formatRupiahInput(this)" placeholder="0" class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok (Opsional untuk Jasa)</label>
                            <input type="number" name="stock" placeholder="Contoh: 10" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                        </div>
                    </div>
                </div>

                <!-- Foto & Video Produk -->
                <div class="space-y-4 pt-2">
                    <h4 class="font-bold text-gray-900 border-b border-gray-100 pb-2">3. Foto & Video Produk (Maks. 6 File)</h4>

                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary transition group cursor-pointer bg-gray-50 hover:bg-blue-50/50" onclick="document.getElementById('imageUpload').click()">
                        <i class="ph-bold ph-upload-simple text-3xl text-gray-400 group-hover:text-primary transition mb-2"></i>
                        <p class="text-sm font-medium text-gray-700">Klik untuk mengunggah atau seret foto/video ke sini</p>
                        <p class="text-xs text-gray-500 mt-1">Maks. 6 file (Foto JPG, PNG, WEBP & Video MP4, WEBM). Maks 50MB per file.</p>
                        <input type="file" name="images[]" id="imageUpload" onchange="handleMediaSelect(event)" multiple accept="image/*,video/*" class="hidden">
                    </div>
                    <!-- Media Previews -->
                    <div id="imagePreviewContainer" class="flex gap-4 mt-4 hidden overflow-x-auto pb-2"></div>
                </div>

            </form>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50 rounded-b-2xl">
            <button type="button" onclick="closeAddProductModal()" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-100 transition focus:outline-none">Batal</button>
            <button type="submit" form="formTambahProduk" class="px-5 py-2.5 bg-primary text-white rounded-lg text-sm font-bold hover:bg-blue-700 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-primary/50 flex items-center gap-2">
                <i class="ph-bold ph-floppy-disk"></i> Simpan Produk
            </button>
        </div>
        </div>
    </div>
</div>

<!-- Modal Edit Produk -->
<div id="editProductModal" class="fixed inset-0 z-[100] hidden bg-gray-900/50 backdrop-blur-sm flex items-start justify-center overflow-y-auto pt-4 pb-10 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl transform scale-95 transition-transform duration-300 relative mt-4 mb-auto">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
            <h3 class="font-bold text-lg text-gray-900">Edit Produk</h3>
            <button onclick="closeEditProductModal()" class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors focus:outline-none">
                <i class="ph-bold ph-x text-xl"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6">
            <form id="formEditProduk" action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <!-- Info Dasar -->
                <div class="space-y-4">
                    <h4 class="font-bold text-gray-900 border-b border-gray-100 pb-2">1. Informasi Produk</h4>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" id="editProductName" name="name" placeholder="Contoh: Jasa Desain Logo Esport" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori / Jurusan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="editProductCategory" name="category" onchange="updateEditSubKategori()" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 appearance-none focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white transition" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <optgroup label="Produk Sekolah">
                                        <option value="Aksesoris">Aksesoris</option>
                                        <option value="Merchandise">Merchandise</option>
                                        <option value="Hardware">Hardware</option>
                                    </optgroup>
                                    <optgroup label="Jasa Setiap Jurusan">
                                        <option value="DKV & Animasi">DKV & Animasi</option>
                                        <option value="Pemasaran">Pemasaran</option>
                                        <option value="PPLG">PPLG</option>
                                        <option value="Akuntansi">Akuntansi</option>
                                    </optgroup>
                                </select>
                                <i class="ph-bold ph-caret-down absolute right-4 top-3.5 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sub/Isi Kategori <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="editProductSubCategory" name="sub_category" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 appearance-none focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white transition disabled:bg-gray-100 disabled:cursor-not-allowed" disabled>
                                    <option value="" disabled selected>Pilih Kategori Utama Dulu</option>
                                </select>
                                <i class="ph-bold ph-caret-down absolute right-4 top-3.5 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Harga & Stok -->
                <div class="space-y-4 pt-2">
                    <h4 class="font-bold text-gray-900 border-b border-gray-100 pb-2">2. Harga & Stok</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-2.5 text-gray-500 font-medium">Rp</span>
                                <input type="text" id="editProductPrice" name="price" oninput="formatRupiahInput(this)" placeholder="0" class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
                            <input type="number" id="editProductStock" name="stock" placeholder="Contoh: 10" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 mt-4">Deskripsi Produk <span class="text-red-500">*</span></label>
                        <textarea id="editProductDescription" rows="4" name="description" placeholder="Jelaskan detail layanan atau produk yang Anda jual..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required></textarea>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50 rounded-b-2xl">
            <button type="button" onclick="closeEditProductModal()" class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-100 transition focus:outline-none">Batal</button>
            <button type="submit" form="formEditProduk" class="px-5 py-2.5 bg-primary text-white rounded-lg text-sm font-bold hover:bg-blue-700 shadow-sm transition focus:outline-none focus:ring-2 focus:ring-primary/50 flex items-center gap-2">
                <i class="ph-bold ph-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</div>

<!-- Modal Lacak Pengiriman -->
<div id="trackingModal" class="fixed inset-0 z-[100] hidden bg-gray-900/50 backdrop-blur-sm flex items-center justify-center overflow-y-auto pt-10 pb-10 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md transform scale-95 transition-transform duration-300 relative my-auto">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
            <div>
                <h3 class="font-bold text-lg text-gray-900">Status Transaksi (COD)</h3>
                <p class="text-xs text-gray-500">Metode: <span class="font-bold text-primary">Bertemu Langsung</span></p>
            </div>
            <button onclick="closeTrackingModal()" class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors focus:outline-none">
                <i class="ph-bold ph-x text-xl"></i>
            </button>
        </div>
        <!-- Body - Timeline -->
        <div class="p-6">
            <div class="relative border-l-2 border-gray-100 ml-4 space-y-8">
                <!-- Step 1 -->
                <div class="relative pl-6">
                    <div class="absolute -left-[11px] bg-green-500 w-5 h-5 rounded-full flex items-center justify-center ring-4 ring-white shadow-sm">
                        <i class="ph-bold ph-check text-white text-[10px]"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-900">Pesanan Dikonfirmasi</span>
                        <span class="text-xs text-gray-500">14 Okt 2023, 08:30 WIB</span>
                        <span class="text-xs text-gray-500 mt-1">Pesanan telah disetujui oleh Anda (Penjual).</span>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="relative pl-6">
                    <div class="absolute -left-[11px] bg-green-500 w-5 h-5 rounded-full flex items-center justify-center ring-4 ring-white shadow-sm">
                        <i class="ph-bold ph-check text-white text-[10px]"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-900">Barang Disiapkan</span>
                        <span class="text-xs text-gray-500">14 Okt 2023, 09:15 WIB</span>
                        <span class="text-xs text-gray-500 mt-1">Anda telah menyiapkan barang dan menentukan titik temu.</span>
                    </div>
                </div>
                <!-- Step 3 (Active) -->
                <div class="relative pl-6">
                    <div class="absolute -left-[11px] bg-primary w-5 h-5 rounded-full flex items-center justify-center ring-4 ring-white shadow-sm">
                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-primary">Menunggu Pertemuan</span>
                        <span class="text-xs text-primary font-medium">Hari ini, 12:00 WIB</span>
                        <span class="text-xs text-gray-600 mt-1">Silakan temui pembeli di <span class="font-bold">Kantin Sekolah (Meja Pojok)</span> untuk serah terima.</span>
                    </div>
                </div>
                <!-- Step 4 -->
                <div class="relative pl-6 opacity-50">
                    <div class="absolute -left-[11px] bg-gray-200 w-5 h-5 rounded-full ring-4 ring-white"></div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-500">Proses Serah Terima & Pembayaran</span>
                    </div>
                </div>
                <!-- Step 5 -->
                <div class="relative pl-6 opacity-50">
                    <div class="absolute -left-[11px] bg-gray-200 w-5 h-5 rounded-full ring-4 ring-white"></div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-gray-500">Transaksi Selesai</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-100 flex justify-end bg-gray-50/50 rounded-b-2xl">
            <button onclick="closeTrackingModal()" class="px-5 py-2.5 bg-gray-900 text-white rounded-lg text-sm font-bold hover:bg-gray-800 transition shadow-sm focus:outline-none">Tutup</button>
        </div>
    </div>
</div>

<!-- Modal Banner Form -->
<div id="bannerModal" class="fixed inset-0 z-[100] hidden bg-gray-900/50 backdrop-blur-sm flex items-start justify-center overflow-y-auto pt-4 pb-10 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl transform scale-95 transition-transform duration-300 relative mt-4 mb-auto">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
            <h3 id="bannerModalTitle" class="font-bold text-lg text-gray-900">Tambah Banner Baru</h3>
            <button onclick="closeBannerModal()" class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors focus:outline-none">
                <i class="ph-bold ph-x text-xl"></i>
            </button>
        </div>
        
        <div class="p-6">
            <form id="bannerForm" action="{{ route('seller.homepage_banner.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
                @csrf
                <input type="hidden" name="banner_id" id="banner_id">
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Gambar Banner</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-primary hover:file:bg-blue-100 transition cursor-pointer">
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar (untuk Edit).</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Teks Badge</label>
                        <input type="text" name="badge_text" id="badge_text" placeholder="Promo Terbatas" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Judul Utama</label>
                        <input type="text" name="title" id="title" placeholder="Koleksi Seragam" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Subjudul / Deskripsi</label>
                    <input type="text" name="subtitle" id="subtitle" placeholder="Deskripsi singkat..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Teks Tombol</label>
                        <input type="text" name="button_text" id="button_text" value="Lihat Toko" placeholder="Lihat Toko" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Link Tujuan</label>
                        <input type="url" name="button_link" id="button_link" placeholder="https://..." value="{{ route('seller.profile', Auth::id()) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition">
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-gray-100">
                    <button type="button" onclick="closeBannerModal()" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-bold hover:bg-gray-50 transition">Batal</button>
                    <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-sm">Simpan Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toastSuccess" class="fixed bottom-6 right-6 bg-white border-l-4 border-green-500 shadow-lg rounded-lg p-4 flex items-center gap-3 transform translate-y-20 opacity-0 transition-all duration-300 z-[200]">
    <div id="toastIconContainer" class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center shrink-0">
        <i id="toastIcon" class="ph-bold ph-check text-lg"></i>
    </div>
    <div>
        <h4 id="toastTitle" class="font-bold text-gray-900 text-sm">Berhasil!</h4>
        <p id="toastMessage" class="text-xs text-gray-500">Tindakan berhasil dilakukan.</p>
    </div>
    <button onclick="closeToast()" class="ml-4 text-gray-400 hover:text-gray-600 focus:outline-none">
        <i class="ph-bold ph-x"></i>
    </button>
</div>

<style>
    /* Custom Scrollbar for Modal */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<script>
    // --- Edit Product Logic ---
    function openEditProductModal(id, name, price, category, subCategory, description, stock) {
        const modal = document.getElementById('editProductModal');

        // Set form action dynamic
        document.getElementById('formEditProduk').action = `/seller/product/${id}`;

        // Pre-fill data
        document.getElementById('editProductName').value = name;

        // Format price logic
        const priceInput = document.getElementById('editProductPrice');
        priceInput.value = price;
        formatRupiahInput(priceInput);

        document.getElementById('editProductDescription').value = description;
        document.getElementById('editProductStock').value = stock;

        // Set category dropdown
        const catSelect = document.getElementById('editProductCategory');
        for(let i=0; i<catSelect.options.length; i++) {
            if(catSelect.options[i].value === category) {
                catSelect.selectedIndex = i;
                break;
            }
        }

        // Trigger subcategory update
        updateEditSubKategori();

        // Set subcategory dropdown if available
        if (subCategory) {
            const subCatSelect = document.getElementById('editProductSubCategory');
            for(let i=0; i<subCatSelect.options.length; i++) {
                if(subCatSelect.options[i].value === subCategory) {
                    subCatSelect.selectedIndex = i;
                    break;
                }
            }
        }

        modal.classList.remove('hidden');
        void modal.offsetWidth; // trigger reflow

        modal.classList.remove('opacity-0');
        modal.querySelector('div.bg-white').classList.remove('scale-95');
        modal.querySelector('div.bg-white').classList.add('scale-100');
    }

    function updateEditSubKategori() {
        const kategoriSelect = document.getElementById('editProductCategory');
        const subKategoriSelect = document.getElementById('editProductSubCategory');
        const selectedKategori = kategoriSelect.value;

        // Reset sub kategori
        subKategoriSelect.innerHTML = '<option value="" disabled selected>Pilih Sub Kategori</option>';

        if (selectedKategori && kategoriData[selectedKategori]) {
            // Enable dropdown
            subKategoriSelect.disabled = false;

            // Tambahkan option baru
            kategoriData[selectedKategori].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub;
                option.textContent = sub;
                subKategoriSelect.appendChild(option);
            });
        } else {
            subKategoriSelect.disabled = true;
        }
    }

    function closeEditProductModal() {
        const modal = document.getElementById('editProductModal');

        modal.classList.add('opacity-0');
        modal.querySelector('div.bg-white').classList.remove('scale-100');
        modal.querySelector('div.bg-white').classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function submitEditProduk(e) {
        e.preventDefault();
        closeEditProductModal();
        showDynamicToast('Berhasil Diperbarui', 'Data produk Anda berhasil disimpan.', 'success');
    }

    // Data Kategori & Sub Kategori
    const kategoriData = {
        'Aksesoris': ['Ganci', 'Nametag', 'Pin', 'Kaos', 'Gelas Custom'],
        'Merchandise': ['Kaos Khusus Sekolah', 'Gelas BN', 'Pulpen BN'],
        'Hardware': ['IoT (Hardware)'],
        'DKV & Animasi': ['Animasi (Logo gerak, iklan, dll)', 'Motion Graphic', 'Video Promosi', 'Desain Grafis'],
        'Pemasaran': ['Digital Marketing', 'Admin Medsos'],
        'PPLG': ['Website', 'Mobile', 'Server Hosting', 'Cloud', 'Game DEV', 'Excel', 'IoT (Software)'],
        'Akuntansi': ['Pembukuan', 'Pembuatan Laporan', 'Konsul Pajak']
    };

    function updateSubKategori() {
        const kategoriSelect = document.getElementById('kategoriUtama');
        const subKategoriSelect = document.getElementById('subKategori');
        const selectedKategori = kategoriSelect.value;

        // Reset sub kategori
        subKategoriSelect.innerHTML = '<option value="" disabled selected>Pilih Sub Kategori</option>';

        if (selectedKategori && kategoriData[selectedKategori]) {
            // Enable dropdown
            subKategoriSelect.disabled = false;

            // Tambahkan option baru
            kategoriData[selectedKategori].forEach(sub => {
                const option = document.createElement('option');
                option.value = sub;
                option.textContent = sub;
                subKategoriSelect.appendChild(option);
            });
        } else {
            // Disable jika kosong
            subKategoriSelect.disabled = true;
            subKategoriSelect.innerHTML = '<option value="" disabled selected>Pilih Kategori Utama Dulu</option>';
        }
    }

    // Modal Functions
    function openAddProductModal() {
        const modal = document.getElementById('addProductModal');
        const modalContent = modal.querySelector('div.bg-white');

        modal.classList.remove('hidden');
        // Trigger reflow
        void modal.offsetWidth;

        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
    }

    function closeAddProductModal() {
        const modal = document.getElementById('addProductModal');
        const modalContent = modal.querySelector('div.bg-white');

        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            selectedMediaFiles = [];
            updateFileInputAndPreview();
        }, 300); // match duration-300
    }

    // Close modal when clicking outside
    document.getElementById('addProductModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddProductModal();
        }
    });


    function switchTab(tabId) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('block');
        });

        // Remove active state from all nav buttons
        document.querySelectorAll('#nav-tabs button').forEach(el => {
            el.classList.remove('text-primary', 'bg-blue-50', 'border-primary');
            el.classList.add('text-gray-600', 'border-transparent');
        });

        // Show target tab content
        const targetTab = document.getElementById('tab-' + tabId);
        if (targetTab) {
            targetTab.classList.remove('hidden');
            targetTab.classList.add('block');
        }

        // Set active state on clicked nav button
        const activeNav = document.getElementById('nav-' + tabId);
        if (activeNav) {
            activeNav.classList.remove('text-gray-600', 'border-transparent');
            activeNav.classList.add('text-primary', 'bg-blue-50', 'border-primary');
        }

        // Hide sidebar on mobile after clicking a tab
        if (window.innerWidth < 1024) {
            const sidebar = document.getElementById('seller-sidebar');
            if (sidebar) {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('flex');
            }
        }
        if (tabId === 'pesanan') {
            fetch('{{ route("seller.mark_orders_read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(() => {
                document.querySelectorAll('#nav-pesanan .bg-red-500').forEach(el => el.remove());
                document.querySelectorAll('.bg-red-500').forEach(el => {
                    if (el.parentElement.textContent.includes('Pesanan Baru')) el.remove();
                });
                document.querySelectorAll('#badge-diproses').forEach(el => el.remove());
            });
        } else if (tabId === 'ulasan') {
            fetch('{{ route("seller.mark_reviews_read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(() => {
                document.querySelectorAll('#nav-ulasan .bg-blue-500').forEach(el => el.remove());
            });
        }
    }

    // Interactive Functions

    // 1. Dashboard Filter Logic
    function updateDashboardStats() {
        const filter = document.getElementById('dashboardTimeFilter').value;
        const statPendapatan = document.getElementById('statPendapatan');
        const statPesanan = document.getElementById('statPesanan');
        const statProduk = document.getElementById('statProduk');
        const statKunjungan = document.getElementById('statKunjungan');

        // Add fade out effect
        const stats = [statPendapatan, statPesanan, statProduk, statKunjungan];
        stats.forEach(el => el.classList.add('opacity-0'));

        setTimeout(() => {
            // Dummy logic to change numbers based on filter
            if (filter === 'bulan') {
                statPendapatan.textContent = 'Rp 4.250.000';
                statPesanan.textContent = '124';
                statProduk.textContent = '32';
                statKunjungan.textContent = '1.845';
            } else if (filter === 'minggu') {
                statPendapatan.textContent = 'Rp 950.000';
                statPesanan.textContent = '28';
                statProduk.textContent = '32';
                statKunjungan.textContent = '420';
            } else if (filter === 'tahun') {
                statPendapatan.textContent = 'Rp 45.800.000';
                statPesanan.textContent = '1.450';
                statProduk.textContent = '35';
                statKunjungan.textContent = '24.500';
            }
            // Fade back in
            stats.forEach(el => el.classList.remove('opacity-0'));
        }, 300);
    }

    // 2. Product Search & Filter Logic
    function filterProduk() {
        const searchVal = document.getElementById('searchProduk').value.toLowerCase();
        const categoryVal = document.getElementById('filterKategoriProduk').value.toLowerCase();
        const rows = document.querySelectorAll('.produk-row');

        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            const category = row.getAttribute('data-category');

            const matchSearch = name.includes(searchVal);
            const matchCategory = categoryVal === "" || category === categoryVal;

            if (matchSearch && matchCategory) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function formatRupiahInput(input) {
        let value = input.value.replace(/\D/g, '');
        if (value) {
            input.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            input.value = '';
        }
    }

    // 3. Media Upload Accumulation & Preview (Max 6 Photos/Videos)
    let selectedMediaFiles = [];

    function handleMediaSelect(event) {
        const newFiles = Array.from(event.target.files);

        // Append new files up to max 6 total
        for (let file of newFiles) {
            if (selectedMediaFiles.length < 6) {
                selectedMediaFiles.push(file);
            }
        }

        updateFileInputAndPreview();
    }

    function removeMediaFile(index) {
        selectedMediaFiles.splice(index, 1);
        updateFileInputAndPreview();
    }

    function updateFileInputAndPreview() {
        const input = document.getElementById('imageUpload');
        const container = document.getElementById('imagePreviewContainer');
        if (!input || !container) return;

        // Sync files array to input via DataTransfer
        try {
            const dt = new DataTransfer();
            selectedMediaFiles.forEach(file => dt.items.add(file));
            input.files = dt.files;
        } catch (err) {
            console.error("DataTransfer error:", err);
        }

        // Render preview cards
        if (selectedMediaFiles.length > 0) {
            container.classList.remove('hidden');
            container.innerHTML = '';

            selectedMediaFiles.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const mediaDiv = document.createElement('div');
                    mediaDiv.className = "relative w-20 h-20 rounded-lg overflow-hidden border border-gray-200 shrink-0 group bg-black/5 shadow-sm";

                    const isVideo = file.type.startsWith('video/') || file.name.match(/\.(mp4|webm|mov|ogg|m4v)$/i);

                    mediaDiv.innerHTML = `
                        ${isVideo ? `
                            <video src="${e.target.result}" class="w-full h-full object-cover"></video>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center pointer-events-none">
                                <i class="ph-fill ph-video-camera text-white text-xl"></i>
                            </div>
                        ` : `
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                        `}
                        <button type="button" onclick="removeMediaFile(${idx})" class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md transition z-10" title="Hapus File Ini">
                            <i class="ph-bold ph-x text-[10px]"></i>
                        </button>
                    `;
                    container.appendChild(mediaDiv);
                };
                reader.readAsDataURL(file);
            });
        } else {
            container.classList.add('hidden');
            container.innerHTML = '';
        }
    }

    // 4. Form Submit & Toast
    function submitProduk(e) {
        e.preventDefault(); // prevent actual reload
        closeAddProductModal(); // close modal
        showDynamicToast('Berhasil!', 'Produk baru berhasil ditambahkan.', 'success');
    }

    function showDynamicToast(title, message, type = 'success') {
        const toast = document.getElementById('toastSuccess');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');
        const toastIcon = document.getElementById('toastIcon');
        const toastIconContainer = document.getElementById('toastIconContainer');

        toastTitle.textContent = title;
        toastMessage.textContent = message;

        // Reset styling
        toast.className = `fixed bottom-6 right-6 bg-white border-l-4 shadow-lg rounded-lg p-4 flex items-center gap-3 transform translate-y-20 opacity-0 transition-all duration-300 z-[200]`;

        if (type === 'success') {
            toast.classList.add('border-green-500');
            toastIconContainer.className = 'w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center shrink-0';
            toastIcon.className = 'ph-bold ph-check text-lg';
        } else if (type === 'error') {
            toast.classList.add('border-red-500');
            toastIconContainer.className = 'w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center shrink-0';
            toastIcon.className = 'ph-bold ph-warning-circle text-lg';
        } else if (type === 'info') {
            toast.classList.add('border-blue-500');
            toastIconContainer.className = 'w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center shrink-0';
            toastIcon.className = 'ph-bold ph-info text-lg';
        }

        // Show animation
        setTimeout(() => {
            toast.classList.remove('translate-y-20', 'opacity-0');
        }, 10);

        // Auto hide after 3 seconds
        setTimeout(() => {
            closeToast();
        }, 3000);
    }

    function closeToast() {
        const toast = document.getElementById('toastSuccess');
        toast.classList.add('translate-y-20', 'opacity-0');
    }

    // 5. Order Management Logic
    function filterPesanan(status, btnElement) {
        // Update tab styling
        const tabs = document.querySelectorAll('.order-tab-btn');
        tabs.forEach(tab => {
            tab.classList.remove('border-primary', 'text-primary', 'border-b-2');
            tab.classList.add('border-transparent', 'text-gray-600');
        });
        btnElement.classList.remove('border-transparent', 'text-gray-600');
        btnElement.classList.add('border-primary', 'text-primary', 'border-b-2');

        // Filter elements
        const orders = document.querySelectorAll('.pesanan-item');
        orders.forEach(order => {
            const itemStatus = order.getAttribute('data-status') || '';
            if (status === 'Semua') {
                order.style.display = '';
            } else if (status === 'Pengembalian' && (itemStatus.includes('Refund') || itemStatus.includes('Pengembalian'))) {
                order.style.display = '';
            } else if (itemStatus === status) {
                order.style.display = '';
            } else {
                order.style.display = 'none';
            }
        });
    }

    function terimaPesanan(orderId) {
        const orderEl = document.getElementById(orderId);
        if(!orderEl) return;

        // Change Status Data Attribute
        orderEl.setAttribute('data-status', 'Sedang Dikirim');
        orderEl.classList.remove('border-l-yellow-400');
        orderEl.classList.add('border-l-transparent'); // optional

        // Change Badge
        const badge = document.getElementById('badge-' + orderId);
        if(badge) {
            badge.className = 'bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded border border-blue-200 transition';
            badge.textContent = 'Sedang Dikirim';
        }

        // Change Actions
        const actions = document.getElementById('action-' + orderId);
        if(actions) {
            actions.innerHTML = `
                <button onclick="cetakResi(this)" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50 transition focus:outline-none">Cetak Label</button>
                <button onclick="lacakPengiriman(this)" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-sm focus:outline-none">Kirim & Lacak</button>
            `;
            // Remove bg-gray-50 from parent if needed, but it's fine.
        }

        // Hide red badge on tab if order processed
        const badgeDiproses = document.getElementById('badge-diproses');
        if(badgeDiproses) badgeDiproses.classList.add('hidden');

        showDynamicToast('Pesanan Diproses', 'Pesanan kini berada di tahap Sedang Dikirim.', 'success');
    }

    function tolakPesanan(orderId) {
        const orderEl = document.getElementById(orderId);
        if(!orderEl) return;

        // Hide order with animation
        orderEl.style.transition = 'all 0.3s ease';
        orderEl.style.opacity = '0';
        orderEl.style.transform = 'scale(0.95)';

        setTimeout(() => {
            orderEl.style.display = 'none';
        }, 300);

        showDynamicToast('Pesanan Ditolak', 'Anda telah membatalkan pesanan tersebut.', 'error');

        // Hide red badge on tab
        const badgeDiproses = document.getElementById('badge-diproses');
        if(badgeDiproses) badgeDiproses.classList.add('hidden');
    }

    function cetakResi(btn) {
        showDynamicToast('Cetak Label', 'Label pengiriman sedang diunduh...', 'info');
    }

    function lacakPengiriman(btn) {
        openTrackingModal();
    }

    function openTrackingModal() {
        const modal = document.getElementById('trackingModal');
        const modalContent = modal.querySelector('div.bg-white');

        modal.classList.remove('hidden');
        void modal.offsetWidth; // trigger reflow

        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
    }

    function closeTrackingModal() {
        const modal = document.getElementById('trackingModal');
        const modalContent = modal.querySelector('div.bg-white');

        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Close tracking modal when clicking outside
    const trackingModal = document.getElementById('trackingModal');
    if (trackingModal) {
        trackingModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeTrackingModal();
            }
        });
    }

    function previewSellerBanner(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('banner-preview-seller');
                const placeholder = document.getElementById('banner-placeholder-seller');
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function previewHomepageBanner(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('homepage-banner-preview');
                const placeholder = document.getElementById('homepage-banner-placeholder');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (window.location.hash) {
            const tabId = window.location.hash.substring(1);
            if (document.getElementById('tab-' + tabId)) {
                switchTab(tabId);
            }
        } else {
            switchTab('dashboard');
        }
    });

    // Mobile Sidebar Toggle
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('seller-sidebar-toggle');
        const sidebar = document.getElementById('seller-sidebar');
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('flex');
            });
        }
    });

    const bannerModal = document.getElementById('bannerModal');
    const bannerModalInner = bannerModal ? bannerModal.querySelector('div') : null;

    function openBannerModal() {
        document.getElementById('bannerForm').reset();
        document.getElementById('banner_id').value = '';
        document.getElementById('bannerModalTitle').innerText = 'Tambah Banner Baru';
        // Reset default link
        document.getElementById('button_link').value = '{{ route('seller.profile', Auth::id()) }}';
        document.getElementById('button_text').value = 'Lihat Toko';
        
        bannerModal.classList.remove('hidden');
        setTimeout(() => {
            bannerModal.classList.remove('opacity-0');
            bannerModalInner.classList.remove('scale-95');
        }, 10);
    }

    function editBanner(banner) {
        document.getElementById('bannerForm').reset();
        document.getElementById('banner_id').value = banner.id;
        document.getElementById('badge_text').value = banner.badge_text || '';
        document.getElementById('title').value = banner.title || '';
        document.getElementById('subtitle').value = banner.subtitle || '';
        document.getElementById('button_text').value = banner.button_text || '';
        document.getElementById('button_link').value = banner.button_link || '';
        
        document.getElementById('bannerModalTitle').innerText = 'Edit Banner';
        
        bannerModal.classList.remove('hidden');
        setTimeout(() => {
            bannerModal.classList.remove('opacity-0');
            bannerModalInner.classList.remove('scale-95');
        }, 10);
    }

    function closeBannerModal() {
        bannerModal.classList.add('opacity-0');
        bannerModalInner.classList.add('scale-95');
        setTimeout(() => {
            bannerModal.classList.add('hidden');
        }, 300);
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Initialize sales chart with backend data
    const ctx = document.getElementById('salesChart');
    if (ctx) {
        const data = {{ $salesData ?? json_encode(['labels' => [], 'data' => []]) }};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Penjualan Bulanan',
                    data: data.data,
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Performa Penjualan Bulanan'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
</script>
@endsection
