@extends('layouts.app')
@section('title', 'Checkout - VocaMarket')
@section('content')

<div class="container mx-auto px-4 py-8 max-w-6xl">
    
    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
        <i class="ph-bold ph-receipt text-3xl text-primary"></i>
        <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kiri: Detail Pesanan -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            
            <!-- 1. Alamat Pengiriman -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <i class="ph-fill ph-map-pin text-primary text-xl"></i> Alamat Pengiriman
                    </h3>
                    <button class="text-sm font-bold text-primary hover:text-blue-700 transition">Ubah</button>
                </div>
                
                <div class="border-l-4 border-primary pl-4 py-1">
                    <p class="font-bold text-gray-900">Budi Santoso <span class="font-normal text-gray-500">(+62 812-3456-7890)</span></p>
                    <p class="text-gray-600 text-sm mt-1">
                        Jalan Merdeka No. 45, RT 01 / RW 02, Kel. Suka Maju<br>
                        Kecamatan Sukaresmi, Kota Bandung, Jawa Barat 40123
                    </p>
                </div>
            </div>

            <!-- 2. Pesanan Anda -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-bold text-gray-900 flex items-center gap-2">
                        <i class="ph-fill ph-package text-primary text-xl"></i> Pesanan Anda
                    </h3>
                </div>
                
                <!-- Toko 1 -->
                <div class="p-5 border-b border-gray-200">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="ph-fill ph-storefront text-gray-700"></i>
                        <span class="font-bold text-gray-900">Toko Seragam Esemka</span>
                    </div>
                    
                    <div class="flex gap-4">
                        <img src="https://picsum.photos/seed/seragam/150/150" alt="Produk" class="w-16 h-16 rounded-lg object-cover border border-gray-100 shrink-0">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-800">Seragam SD Merah Putih Lengan Pendek Berkualitas</h4>
                            <p class="text-xs text-gray-500 mt-1">Variasi: Ukuran M</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-bold text-primary">Rp55.000</span>
                                <span class="text-sm text-gray-600">x1</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-dashed border-gray-200">
                        <div class="flex items-center justify-between gap-4">
                            <div class="w-1/2">
                                <label class="text-xs font-bold text-gray-700 mb-1 block">Opsi Pengiriman:</label>
                                <select class="w-full text-sm border border-gray-300 rounded-lg p-2 outline-none focus:border-primary">
                                    <option>Reguler (Rp15.000)</option>
                                    <option>Hemat (Rp10.000)</option>
                                    <option>Cargo (Rp35.000)</option>
                                </select>
                            </div>
                            <div class="w-1/2">
                                <label class="text-xs font-bold text-gray-700 mb-1 block">Pesan untuk Penjual:</label>
                                <input type="text" placeholder="Silakan tinggalkan pesan..." class="w-full text-sm border border-gray-300 rounded-lg p-2 outline-none focus:border-primary">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Toko 2 -->
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="ph-fill ph-storefront text-gray-700"></i>
                        <span class="font-bold text-gray-900">Studio Animasi 666</span>
                    </div>
                    
                    <div class="flex gap-4">
                        <img src="https://picsum.photos/seed/desain/150/150" alt="Produk" class="w-16 h-16 rounded-lg object-cover border border-gray-100 shrink-0">
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-800">Jasa Pembuatan Logo Bisnis & E-Sports Profesional</h4>
                            <div class="flex items-center justify-between mt-2">
                                <span class="font-bold text-primary">Rp150.000</span>
                                <span class="text-sm text-gray-600">x1</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-dashed border-gray-200">
                        <div class="flex items-center justify-between gap-4">
                            <div class="w-1/2">
                                <label class="text-xs font-bold text-gray-700 mb-1 block">Opsi Pengiriman:</label>
                                <select class="w-full text-sm border border-gray-300 rounded-lg p-2 outline-none focus:border-primary bg-gray-100 text-gray-500" disabled>
                                    <option>Termasuk Ongkos Kirim (Gratis)</option>
                                </select>
                                <span class="text-[10px] text-gray-500">* Produk digital/jasa tidak dikenakan ongkir</span>
                            </div>
                            <div class="w-1/2">
                                <label class="text-xs font-bold text-gray-700 mb-1 block">Pesan untuk Penjual:</label>
                                <input type="text" placeholder="Email untuk pengiriman file..." class="w-full text-sm border border-gray-300 rounded-lg p-2 outline-none focus:border-primary">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 3. Metode Pembayaran -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h3 class="font-bold text-gray-900 flex items-center gap-2 mb-4">
                    <i class="ph-fill ph-credit-card text-primary text-xl"></i> Metode Pembayaran
                </h3>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <label class="border-2 border-primary bg-blue-50 p-3 rounded-lg flex flex-col items-center justify-center gap-2 cursor-pointer relative">
                        <input type="radio" name="payment" class="absolute top-2 right-2" checked>
                        <i class="ph-fill ph-wallet text-3xl text-primary"></i>
                        <span class="text-xs font-bold text-center">VocaPay</span>
                    </label>
                    <label class="border border-gray-200 hover:border-primary p-3 rounded-lg flex flex-col items-center justify-center gap-2 cursor-pointer transition relative">
                        <input type="radio" name="payment" class="absolute top-2 right-2">
                        <i class="ph-fill ph-bank text-3xl text-gray-500"></i>
                        <span class="text-xs font-bold text-center">Transfer Bank</span>
                    </label>
                    <label class="border border-gray-200 hover:border-primary p-3 rounded-lg flex flex-col items-center justify-center gap-2 cursor-pointer transition relative">
                        <input type="radio" name="payment" class="absolute top-2 right-2">
                        <i class="ph-fill ph-storefront text-3xl text-gray-500"></i>
                        <span class="text-xs font-bold text-center">Alfamart / Indomaret</span>
                    </label>
                    <label class="border border-gray-200 hover:border-primary p-3 rounded-lg flex flex-col items-center justify-center gap-2 cursor-pointer transition relative opacity-50">
                        <input type="radio" name="payment" class="absolute top-2 right-2" disabled>
                        <i class="ph-fill ph-truck text-3xl text-gray-500"></i>
                        <span class="text-xs font-bold text-center">COD</span>
                        <span class="absolute -bottom-2 bg-red-100 text-red-600 text-[8px] font-bold px-1 rounded">Tidak Tersedia</span>
                    </label>
                </div>
            </div>

        </div>

        <!-- Kanan: Ringkasan Belanja -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sticky top-24">
                <h3 class="font-bold text-gray-900 mb-4 pb-4 border-b border-gray-100">Ringkasan Belanja</h3>
                
                <div class="flex flex-col gap-3 text-sm text-gray-600 mb-4 pb-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <span>Total Harga (2 barang)</span>
                        <span class="text-gray-900 font-medium">Rp205.000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Total Ongkos Kirim</span>
                        <span class="text-gray-900 font-medium">Rp15.000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Asuransi Pengiriman</span>
                        <span class="text-gray-900 font-medium">Rp1.000</span>
                    </div>
                    <div class="flex justify-between items-center text-green-600">
                        <span>Voucher Toko</span>
                        <span class="font-medium">-Rp5.000</span>
                    </div>
                </div>
                
                <div class="flex flex-col gap-1 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-900 text-base">Total Tagihan</span>
                        <span class="font-bold text-primary text-xl">Rp216.000</span>
                    </div>
                    <div class="flex justify-end mt-1">
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <i class="ph-fill ph-wallet text-primary"></i> Saldo VocaPay: <span class="font-bold">Rp250.000</span>
                        </span>
                    </div>
                </div>
                
                <button class="w-full py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition">
                    Buat Pesanan
                </button>
                <p class="text-[10px] text-gray-500 text-center mt-3">
                    Dengan membuat pesanan, Anda menyetujui <a href="#" class="text-primary hover:underline">Syarat & Ketentuan VocaMarket</a>
                </p>
            </div>
        </div>

    </div>
</div>

@endsection
