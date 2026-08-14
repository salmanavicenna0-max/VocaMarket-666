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
                <ul class="flex flex-col">
                    <li>
                        <a href="#" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-squares-four text-xl"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="w-full text-left flex items-center gap-3 px-5 py-4 text-primary font-medium bg-blue-50 border-l-4 border-primary transition">
                            <i class="ph-fill ph-package text-xl"></i> Produk Saya
                        </a>
                    </li>
                    <li>
                        <a href="#" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent flex justify-between">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-shopping-bag text-xl"></i> Pesanan Masuk
                            </div>
                            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">3</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-wallet text-xl"></i> Saldo Penjual
                        </a>
                    </li>
                    <li class="border-t border-gray-100">
                        <a href="{{ url('/user') }}" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 transition border-l-4 border-transparent">
                            <i class="ph-bold ph-arrow-left text-xl"></i> Kembali ke Pembeli
                        </a>
                    </li>
                </ul>
            </div>
            
        </div>

        <!-- Konten Kanan: Kelola Produk -->
        <div class="lg:col-span-3">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
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
            
        </div>
    </div>
</div>
@endsection
