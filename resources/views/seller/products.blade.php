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

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        <!-- Sidebar Penjual -->
        <div class="lg:col-span-1 flex flex-col gap-4">
            
            <div class="bg-primary rounded-xl shadow-sm p-5 text-white flex items-center gap-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shrink-0">
                    <i class="ph-fill ph-storefront text-2xl text-primary"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg leading-tight">Toko Saya</h3>
                    <p class="text-blue-100 text-xs">Budi Santoso (X PPLG)</p>
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
                            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">3</span>
                        </button>
                    </li>
                    <li class="border-t border-gray-100">
                        <a href="{{ url('/user') }}" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 transition border-l-4 border-transparent">
                            <i class="ph-bold ph-arrow-left text-xl"></i> Kembali ke Pembeli
                        </a>
                    </li>
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
                                <span class="flex items-center text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                    <i class="ph-bold ph-trend-up mr-1"></i> 15%
                                </span>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">Total Pendapatan</p>
                            <h3 id="statPendapatan" class="text-2xl font-bold text-gray-900 mt-1 transition-all duration-300">Rp 4.250.000</h3>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200 flex flex-col justify-center transition hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-green-600">
                                    <i class="ph-fill ph-shopping-bag text-xl"></i>
                                </div>
                                <span class="flex items-center text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                    <i class="ph-bold ph-trend-up mr-1"></i> 8%
                                </span>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">Pesanan Selesai</p>
                            <h3 id="statPesanan" class="text-2xl font-bold text-gray-900 mt-1 transition-all duration-300">124</h3>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200 flex flex-col justify-center transition hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-purple-600">
                                    <i class="ph-fill ph-package text-xl"></i>
                                </div>
                                <span class="flex items-center text-xs font-bold text-gray-500 bg-white px-2 py-1 rounded-full">
                                    <i class="ph-bold ph-minus mr-1"></i> 0%
                                </span>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">Total Produk</p>
                            <h3 id="statProduk" class="text-2xl font-bold text-gray-900 mt-1 transition-all duration-300">32</h3>
                        </div>

                        <!-- Card 4 -->
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200 flex flex-col justify-center transition hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm text-orange-600">
                                    <i class="ph-fill ph-eye text-xl"></i>
                                </div>
                                <span class="flex items-center text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                    <i class="ph-bold ph-trend-up mr-1"></i> 24%
                                </span>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">Kunjungan Toko</p>
                            <h3 id="statKunjungan" class="text-2xl font-bold text-gray-900 mt-1 transition-all duration-300">1.845</h3>
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
                                <!-- Dummy Bar Chart -->
                                <div class="w-full bg-blue-100 rounded-t-sm h-[30%] relative group cursor-pointer hover:bg-blue-200 transition"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs font-bold text-gray-500 hidden group-hover:block">Rp2M</span></div>
                                <div class="w-full bg-blue-100 rounded-t-sm h-[50%] relative group cursor-pointer hover:bg-blue-200 transition"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs font-bold text-gray-500 hidden group-hover:block">Rp3M</span></div>
                                <div class="w-full bg-blue-100 rounded-t-sm h-[40%] relative group cursor-pointer hover:bg-blue-200 transition"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs font-bold text-gray-500 hidden group-hover:block">Rp2.5M</span></div>
                                <div class="w-full bg-primary rounded-t-sm h-[80%] relative group cursor-pointer shadow-[0_0_15px_rgba(37,99,235,0.4)]"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs font-bold text-primary">Rp4.2M</span></div>
                                <div class="w-full bg-blue-100 rounded-t-sm h-[60%] relative group cursor-pointer hover:bg-blue-200 transition"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs font-bold text-gray-500 hidden group-hover:block">Rp3.5M</span></div>
                                <div class="w-full bg-blue-100 rounded-t-sm h-[45%] relative group cursor-pointer hover:bg-blue-200 transition"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs font-bold text-gray-500 hidden group-hover:block">Rp2.8M</span></div>
                                <div class="w-full bg-blue-100 rounded-t-sm h-[70%] relative group cursor-pointer hover:bg-blue-200 transition"><span class="absolute -top-6 left-1/2 -translate-x-1/2 text-xs font-bold text-gray-500 hidden group-hover:block">Rp4M</span></div>
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
                                <div class="flex items-center gap-3">
                                    <i class="ph-bold ph-warning-circle text-xl"></i>
                                    <span class="font-bold text-sm">Pesanan Baru</span>
                                </div>
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">3</span>
                            </div>

                            <div onclick="switchTab('pesanan')" class="flex items-center justify-between p-3 bg-yellow-50 text-yellow-700 rounded-lg border border-yellow-100 cursor-pointer hover:bg-yellow-100 transition">
                                <div class="flex items-center gap-3">
                                    <i class="ph-bold ph-truck text-xl"></i>
                                    <span class="font-bold text-sm">Siap Dikirim</span>
                                </div>
                                <span class="font-bold text-sm">1</span>
                            </div>

                            <div onclick="switchTab('pesanan')" class="flex items-center justify-between p-3 bg-gray-50 text-gray-700 rounded-lg border border-gray-200 cursor-pointer hover:bg-gray-100 transition">
                                <div class="flex items-center gap-3">
                                    <i class="ph-bold ph-chat-circle-dots text-xl"></i>
                                    <span class="font-bold text-sm">Chat Belum Dibalas</span>
                                </div>
                                <span class="font-bold text-sm text-gray-400">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: Produk Saya -->
            <div id="tab-produk" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content block">
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
                            
                            <!-- Produk 1 -->
                            <tr class="produk-row hover:bg-gray-50 transition" data-name="jasa pembuatan logo bisnis & e-sports" data-category="jasa">
                                <td class="p-4">
                                    <div class="flex gap-4 items-center">
                                        <img src="https://picsum.photos/seed/desain/100/100" class="w-16 h-16 rounded-lg object-cover border border-gray-200 shrink-0">
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm line-clamp-2">Jasa Pembuatan Logo Bisnis & E-Sports</h4>
                                            <p class="text-xs text-gray-500 mt-1">Kategori: Jasa</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="font-bold text-primary">Rp150.000</span>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">Tersedia</span>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-2">
                                        <button onclick="openEditProductModal('Jasa Pembuatan Logo Bisnis & E-Sports', '150000', 'DKV & Animasi', 'Desain Grafis')" class="p-2 text-blue-600 hover:bg-blue-100 rounded transition tooltip" title="Edit">
                                            <i class="ph-bold ph-pencil-simple text-lg"></i>
                                        </button>
                                        <button class="p-2 text-red-600 hover:bg-red-100 rounded transition tooltip" title="Hapus">
                                            <i class="ph-bold ph-trash text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Produk 2 -->
                            <tr class="produk-row hover:bg-gray-50 transition" data-name="jasa pembukuan usaha kecil" data-category="akuntansi">
                                <td class="p-4">
                                    <div class="flex gap-4 items-center">
                                        <img src="https://picsum.photos/seed/akuntansi/100/100" class="w-16 h-16 rounded-lg object-cover border border-gray-200 shrink-0">
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm line-clamp-2">Jasa Pembukuan Usaha Kecil</h4>
                                            <p class="text-xs text-gray-500 mt-1">Kategori: Akuntansi</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="font-bold text-primary">Rp50.000</span>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">Tersedia</span>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-2">
                                        <button onclick="openEditProductModal('Jasa Pembukuan Usaha Kecil', '50000', 'Akuntansi', 'Pembukuan')" class="p-2 text-blue-600 hover:bg-blue-100 rounded transition tooltip" title="Edit">
                                            <i class="ph-bold ph-pencil-simple text-lg"></i>
                                        </button>
                                        <button class="p-2 text-red-600 hover:bg-red-100 rounded transition tooltip" title="Hapus">
                                            <i class="ph-bold ph-trash text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Produk 3 -->
                            <tr class="produk-row hover:bg-gray-50 transition" data-name="casing hp custom aesthetic terserah bebas" data-category="barang fisik">
                                <td class="p-4">
                                    <div class="flex gap-4 items-center">
                                        <div class="w-16 h-16 rounded-lg bg-gray-100 border border-gray-200 shrink-0 flex items-center justify-center text-gray-400">
                                            <i class="ph-fill ph-image text-2xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm line-clamp-2">Casing HP Custom Aesthetic Terserah Bebas</h4>
                                            <p class="text-xs text-gray-500 mt-1">Kategori: Barang Fisik</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="font-bold text-primary">Rp25.000</span>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2.5 py-1 rounded-full border border-gray-200">Habis</span>
                                </td>
                                <td class="p-4">
                                    <div class="flex justify-center gap-2">
                                        <button class="p-2 text-blue-600 hover:bg-blue-100 rounded transition tooltip" title="Edit">
                                            <i class="ph-bold ph-pencil-simple text-lg"></i>
                                        </button>
                                        <button class="p-2 text-red-600 hover:bg-red-100 rounded transition tooltip" title="Hapus">
                                            <i class="ph-bold ph-trash text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

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
                        <span id="badge-diproses" class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">1</span>
                    </button>
                    <button onclick="filterPesanan('Sedang Dikirim', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Sedang Dikirim</button>
                    <button onclick="filterPesanan('Selesai', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Selesai</button>
                    <button onclick="filterPesanan('Dibatalkan', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Dibatalkan</button>
                    <button onclick="filterPesanan('Pengembalian', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Pengembalian</button>
                </div>
                
                <div class="p-6 flex flex-col gap-4">
                    <!-- Pesanan 1 (Baru) -->
                    <div id="order-1" class="pesanan-item border border-gray-200 rounded-xl overflow-hidden hover:border-primary transition border-l-4 border-l-yellow-400" data-status="Perlu Diproses">
                        <div class="bg-gray-50 p-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-user-circle text-gray-500 text-xl"></i>
                                <div>
                                    <span class="font-bold text-gray-900">Andi Saputra</span>
                                    <p class="text-[10px] text-gray-500">INV-20231015-001</p>
                                </div>
                            </div>
                            <span id="badge-order-1" class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded border border-yellow-200 transition">Perlu Diproses</span>
                        </div>
                        <div class="p-4 flex gap-4">
                            <img src="https://picsum.photos/seed/desain/150/150" class="w-20 h-20 rounded-lg object-cover border border-gray-100 shrink-0">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">Jasa Pembuatan Logo Bisnis & E-Sports</h4>
                                <p class="text-xs text-gray-500 mt-1">1 barang x Rp150.000</p>
                                <div class="mt-2 bg-blue-50 text-blue-700 text-xs p-2 rounded-lg border border-blue-100">
                                    <span class="font-bold">Catatan Pembeli:</span> "Tolong logonya warna dominan merah dan hitam ya kak, untuk tim e-sport."
                                </div>
                            </div>
                            <div class="text-right flex flex-col justify-between shrink-0 ml-4">
                                <div>
                                    <p class="text-xs text-gray-500">Total Pembayaran</p>
                                    <p class="font-bold text-primary text-lg">Rp150.000</p>
                                </div>
                            </div>
                        </div>
                        <div id="action-order-1" class="p-4 border-t border-gray-100 flex justify-end gap-2 bg-gray-50">
                            <button onclick="tolakPesanan('order-1')" class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-bold hover:bg-red-50 transition focus:outline-none">Tolak Pesanan</button>
                            <button onclick="terimaPesanan('order-1')" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-sm focus:outline-none">Terima & Proses</button>
                        </div>
                    </div>

                    <!-- Pesanan 2 (Dikirim) -->
                    <div id="order-2" class="pesanan-item border border-gray-200 rounded-xl overflow-hidden hover:border-primary transition" data-status="Sedang Dikirim">
                        <div class="bg-gray-50 p-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-user-circle text-gray-500 text-xl"></i>
                                <div>
                                    <span class="font-bold text-gray-900">Rini Wulandari</span>
                                    <p class="text-[10px] text-gray-500">INV-20231014-089</p>
                                </div>
                            </div>
                            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded border border-blue-200">Sedang Dikirim</span>
                        </div>
                        <div class="p-4 flex gap-4">
                            <img src="https://picsum.photos/seed/makanan/150/150" class="w-20 h-20 rounded-lg object-cover border border-gray-100 shrink-0">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">Keripik Kaca Pedas Level Dewa (100gr)</h4>
                                <p class="text-xs text-gray-500 mt-1">2 barang x Rp12.000</p>
                            </div>
                            <div class="text-right flex flex-col justify-between shrink-0 ml-4">
                                <div>
                                    <p class="text-xs text-gray-500">Total Pembayaran</p>
                                    <p class="font-bold text-primary text-lg">Rp24.000</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border-t border-gray-100 flex justify-end gap-2">
                            <button onclick="cetakResi(this)" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50 transition focus:outline-none">Detail Pembeli</button>
                            <button onclick="lacakPengiriman(this)" class="px-4 py-2 border border-primary text-primary rounded-lg text-sm font-bold hover:bg-blue-50 transition focus:outline-none">Status Transaksi</button>
                        </div>
                    </div>

                    <!-- Pesanan 3 (Selesai) -->
                    <div id="order-3" class="pesanan-item border border-gray-200 rounded-xl overflow-hidden hover:border-primary transition" data-status="Selesai">
                        <div class="bg-gray-50 p-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-user-circle text-gray-500 text-xl"></i>
                                <div>
                                    <span class="font-bold text-gray-900">Budi Santoso</span>
                                    <p class="text-[10px] text-gray-500">INV-20231012-045</p>
                                </div>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded border border-green-200">Pesanan Selesai</span>
                        </div>
                        <div class="p-4 flex gap-4">
                            <div class="w-20 h-20 rounded-lg bg-gray-100 border border-gray-200 shrink-0 flex items-center justify-center text-gray-400">
                                <i class="ph-fill ph-image text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">Casing HP Custom Aesthetic</h4>
                                <p class="text-xs text-gray-500 mt-1">1 barang x Rp25.000</p>
                            </div>
                            <div class="text-right flex flex-col justify-between shrink-0 ml-4">
                                <div>
                                    <p class="text-xs text-gray-500">Total Pembayaran</p>
                                    <p class="font-bold text-primary text-lg">Rp25.000</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border-t border-gray-100 flex justify-end gap-2 bg-gray-50/50">
                            <button onclick="showDynamicToast('Penilaian Pembeli', 'Membuka ulasan pembeli...', 'info')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50 transition focus:outline-none">Lihat Penilaian</button>
                        </div>
                    </div>

                    <!-- Pesanan 4 (Dibatalkan) -->
                    <div id="order-4" class="pesanan-item border border-gray-200 rounded-xl overflow-hidden opacity-75 hover:opacity-100 transition" data-status="Dibatalkan">
                        <div class="bg-red-50/30 p-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-user-circle text-gray-500 text-xl"></i>
                                <div>
                                    <span class="font-bold text-gray-900">Siti Aminah</span>
                                    <p class="text-[10px] text-gray-500">INV-20231010-012</p>
                                </div>
                            </div>
                            <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2 py-1 rounded border border-gray-300">Dibatalkan Pembeli</span>
                        </div>
                        <div class="p-4 flex gap-4 bg-gray-50/30">
                            <img src="https://picsum.photos/seed/makanan/150/150" class="w-20 h-20 rounded-lg object-cover border border-gray-200 shrink-0 grayscale">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 line-through text-gray-500">Keripik Kaca Pedas Level Dewa (100gr)</h4>
                                <p class="text-xs text-gray-500 mt-1">1 barang x Rp12.000</p>
                                <p class="text-xs text-red-500 mt-2 font-medium"><span class="font-bold">Alasan:</span> Berubah pikiran</p>
                            </div>
                            <div class="text-right flex flex-col justify-between shrink-0 ml-4">
                                <div>
                                    <p class="text-xs text-gray-500">Total Pembayaran</p>
                                    <p class="font-bold text-gray-500 text-lg line-through">Rp12.000</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border-t border-gray-100 flex justify-end gap-2 bg-gray-50/50">
                            <button onclick="showDynamicToast('Dihapus', 'Riwayat pesanan dibatalkan berhasil dihapus.', 'success'); document.getElementById('order-4').style.display='none';" class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-bold hover:bg-red-50 transition focus:outline-none">Hapus Catatan</button>
                        </div>
                    </div>

                    <!-- Pesanan 5 (Pengembalian) -->
                    <div id="order-5" class="pesanan-item border border-orange-200 rounded-xl overflow-hidden hover:border-orange-400 transition border-l-4 border-l-orange-400" data-status="Pengembalian">
                        <div class="bg-orange-50/30 p-4 border-b border-orange-100 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-user-circle text-gray-500 text-xl"></i>
                                <div>
                                    <span class="font-bold text-gray-900">Dimas Pratama</span>
                                    <p class="text-[10px] text-gray-500">INV-20231008-111</p>
                                </div>
                            </div>
                            <span class="bg-orange-100 text-orange-700 text-xs font-bold px-2 py-1 rounded border border-orange-200">Ajuan Retur</span>
                        </div>
                        <div class="p-4 flex gap-4">
                            <img src="https://picsum.photos/seed/desain/150/150" class="w-20 h-20 rounded-lg object-cover border border-gray-100 shrink-0">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">Jasa Pembuatan Logo Bisnis & E-Sports</h4>
                                <p class="text-xs text-gray-500 mt-1">1 barang x Rp150.000</p>
                                <div class="mt-2 bg-orange-50 text-orange-700 text-xs p-2 rounded-lg border border-orange-200">
                                    <span class="font-bold">Alasan Retur:</span> "File mentahan resolusinya pecah kak, tidak sesuai deskripsi."
                                </div>
                            </div>
                            <div class="text-right flex flex-col justify-between shrink-0 ml-4">
                                <div>
                                    <p class="text-xs text-gray-500">Total Refund</p>
                                    <p class="font-bold text-orange-600 text-lg">Rp150.000</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border-t border-gray-100 flex justify-end gap-2 bg-gray-50">
                            <button onclick="showDynamicToast('Diskusi', 'Membuka ruang chat komplain dengan pembeli...', 'info')" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50 transition focus:outline-none">Chat Pembeli</button>
                            <button onclick="showDynamicToast('Retur Disetujui', 'Dana akan segera dikembalikan ke pembeli.', 'success')" class="px-4 py-2 bg-orange-500 text-white rounded-lg text-sm font-bold hover:bg-orange-600 transition shadow-sm focus:outline-none">Setujui Retur</button>
                        </div>
                    </div>
                </div>
            </div>
            
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
            <form id="formTambahProduk" onsubmit="submitProduk(event)" action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Info Dasar -->
                <div class="space-y-4">
                    <h4 class="font-bold text-gray-900 border-b border-gray-100 pb-2">1. Informasi Produk</h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Contoh: Jasa Desain Logo Esport" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori / Jurusan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="kategoriUtama" onchange="updateSubKategori()" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 appearance-none focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white transition">
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
                                <select id="subKategori" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 appearance-none focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white transition disabled:bg-gray-100 disabled:cursor-not-allowed" disabled>
                                    <option value="" disabled selected>Pilih Kategori Utama Dulu</option>
                                </select>
                                <i class="ph-bold ph-caret-down absolute right-4 top-3.5 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk <span class="text-red-500">*</span></label>
                        <textarea rows="4" placeholder="Jelaskan detail layanan atau produk yang Anda jual..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required></textarea>
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
                                <input type="number" placeholder="0" class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok (Opsional untuk Jasa)</label>
                            <input type="number" placeholder="Contoh: 10" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                        </div>
                    </div>
                </div>

                <!-- Foto Produk -->
                <div class="space-y-4 pt-2">
                    <h4 class="font-bold text-gray-900 border-b border-gray-100 pb-2">3. Foto Produk</h4>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary transition group cursor-pointer bg-gray-50 hover:bg-blue-50/50" onclick="document.getElementById('imageUpload').click()">
                        <i class="ph-bold ph-upload-simple text-3xl text-gray-400 group-hover:text-primary transition mb-2"></i>
                        <p class="text-sm font-medium text-gray-700">Klik untuk mengunggah atau seret foto ke sini</p>
                        <p class="text-xs text-gray-500 mt-1">Maks. 3 foto (JPG, PNG). Ukuran maks 2MB per foto.</p>
                        <input type="file" id="imageUpload" onchange="previewImages(event)" multiple accept="image/*" class="hidden">
                    </div>
                    <!-- Image Previews -->
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
            <form id="formEditProduk" onsubmit="submitEditProduk(event)" action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Info Dasar -->
                <div class="space-y-4">
                    <h4 class="font-bold text-gray-900 border-b border-gray-100 pb-2">1. Informasi Produk</h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" id="editProductName" placeholder="Contoh: Jasa Desain Logo Esport" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori / Jurusan <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select id="editProductCategory" onchange="updateEditSubKategori()" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 appearance-none focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white transition">
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
                                <select id="editProductSubCategory" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 appearance-none focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary bg-white transition disabled:bg-gray-100 disabled:cursor-not-allowed" disabled>
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
                                <input type="number" id="editProductPrice" placeholder="0" class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition" required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                            <input type="number" placeholder="Contoh: 10" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition">
                        </div>
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
    function openEditProductModal(name, price, category, subCategory) {
        const modal = document.getElementById('editProductModal');
        
        // Pre-fill data
        document.getElementById('editProductName').value = name;
        document.getElementById('editProductPrice').value = price;
        
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
        document.getElementById('tab-' + tabId).classList.remove('hidden');
        document.getElementById('tab-' + tabId).classList.add('block');
        
        // Set active state on clicked nav button
        const activeNav = document.getElementById('nav-' + tabId);
        activeNav.classList.remove('text-gray-600', 'border-transparent');
        activeNav.classList.add('text-primary', 'bg-blue-50', 'border-primary');
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

    // 3. Image Upload Preview
    function previewImages(event) {
        const files = event.target.files;
        const container = document.getElementById('imagePreviewContainer');
        
        if (files.length > 0) {
            container.classList.remove('hidden');
            container.innerHTML = ''; // clear old previews
            
            // Limit to 3 files
            const maxFiles = Math.min(files.length, 3);
            
            for (let i = 0; i < maxFiles; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgDiv = document.createElement('div');
                    imgDiv.className = "relative w-20 h-20 rounded-lg overflow-hidden border border-gray-200 shrink-0 group";
                    imgDiv.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 hidden group-hover:flex items-center justify-center transition cursor-pointer">
                            <i class="ph-bold ph-trash text-white"></i>
                        </div>
                    `;
                    container.appendChild(imgDiv);
                }
                reader.readAsDataURL(files[i]);
            }
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
            if (status === 'Semua' || order.getAttribute('data-status') === status) {
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
    document.getElementById('trackingModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeTrackingModal();
        }
    });

</script>
@endsection
