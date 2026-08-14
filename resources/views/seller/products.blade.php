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
            
            <!-- TAB: Dashboard (Dummy) -->
            <div id="tab-dashboard" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Dashboard Toko</h2>
                        <p class="text-gray-500 text-sm mt-1">Ringkasan performa toko Anda hari ini</p>
                    </div>
                </div>
                <div class="p-6 text-center text-gray-500">
                    Fitur ini dalam tahap pengembangan.
                </div>
            </div>

            <!-- TAB: Produk Saya -->
            <div id="tab-produk" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content block">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center flex-wrap gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Produk Saya</h2>
                        <p class="text-gray-500 text-sm mt-1">Kelola daftar produk, stok, dan harga jualan Anda</p>
                    </div>
                    <button class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-sm transition flex items-center gap-2">
                        <i class="ph-bold ph-plus"></i> Tambah Produk Baru
                    </button>
                </div>
                
                <div class="p-4 border-b border-gray-100 flex gap-4">
                    <div class="relative flex-1 max-w-sm">
                        <i class="ph ph-magnifying-glass absolute left-3 top-2.5 text-gray-400 text-lg"></i>
                        <input type="text" placeholder="Cari nama produk..." class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:border-primary text-sm">
                    </div>
                    <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-primary bg-white">
                        <option>Semua Kategori</option>
                        <option>Barang Fisik</option>
                        <option>Jasa</option>
                        <option>Makanan</option>
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
                            <tr class="hover:bg-gray-50 transition">
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
                                        <button class="p-2 text-blue-600 hover:bg-blue-100 rounded transition tooltip" title="Edit">
                                            <i class="ph-bold ph-pencil-simple text-lg"></i>
                                        </button>
                                        <button class="p-2 text-red-600 hover:bg-red-100 rounded transition tooltip" title="Hapus">
                                            <i class="ph-bold ph-trash text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Produk 2 -->
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <div class="flex gap-4 items-center">
                                        <img src="https://picsum.photos/seed/makanan/100/100" class="w-16 h-16 rounded-lg object-cover border border-gray-200 shrink-0">
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm line-clamp-2">Keripik Kaca Pedas Level Dewa (100gr)</h4>
                                            <p class="text-xs text-gray-500 mt-1">Kategori: Makanan</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="font-bold text-primary">Rp12.000</span>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="text-gray-900 font-bold text-sm">45 <span class="text-xs text-gray-500 font-normal">pcs</span></span>
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

                            <!-- Produk 3 -->
                            <tr class="hover:bg-gray-50 transition">
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
                <div class="flex overflow-x-auto border-b border-gray-200 whitespace-nowrap">
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-primary text-primary font-bold text-sm">Semua</button>
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition relative">
                        Perlu Diproses
                        <span class="absolute top-2 right-2 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">1</span>
                    </button>
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Perlu Dikirim</button>
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Selesai</button>
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Dibatalkan</button>
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Pengembalian</button>
                </div>
                
                <div class="p-6 flex flex-col gap-4">
                    <!-- Pesanan 1 (Baru) -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden hover:border-primary transition border-l-4 border-l-yellow-400">
                        <div class="bg-gray-50 p-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-user-circle text-gray-500 text-xl"></i>
                                <div>
                                    <span class="font-bold text-gray-900">Andi Saputra</span>
                                    <p class="text-[10px] text-gray-500">INV-20231015-001</p>
                                </div>
                            </div>
                            <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded border border-yellow-200">Perlu Diproses</span>
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
                        <div class="p-4 border-t border-gray-100 flex justify-end gap-2 bg-gray-50">
                            <button class="px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-bold hover:bg-red-50 transition">Tolak Pesanan</button>
                            <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">Terima & Proses</button>
                        </div>
                    </div>

                    <!-- Pesanan 2 (Dikirim) -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden hover:border-primary transition">
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
                            <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50 transition">Cetak Label</button>
                            <button class="px-4 py-2 border border-primary text-primary rounded-lg text-sm font-bold hover:bg-blue-50 transition">Lacak Pengiriman</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
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
</script>
@endsection
