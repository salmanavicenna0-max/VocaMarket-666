@extends('layouts.app')
@section('title', 'Profil Penjual - VocaMarket')
@section('content')

<div class="container mx-auto px-4 py-8">
    
    <!-- Profile Banner & Info -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
        <div class="h-48 w-full bg-gradient-to-r from-primary to-blue-400 relative">
            <div class="absolute inset-0 bg-black/20"></div>
            <!-- Banner Decoration -->
            <i class="ph-fill ph-storefront absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-9xl text-white/10"></i>
        </div>
        
        <div class="px-6 md:px-10 pb-6 -mt-16 relative z-10 flex flex-col md:flex-row items-center md:items-end gap-6">
            <!-- Avatar -->
            <div class="w-32 h-32 rounded-full border-4 border-white bg-white shadow-md overflow-hidden shrink-0">
                <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=0a84d4&color=fff&size=128" alt="Profile" class="w-full h-full object-cover">
            </div>
            
            <!-- Info -->
            <div class="flex-grow text-center md:text-left pt-4 md:pt-0">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Toko Budi Santoso</h1>
                <p class="text-gray-500 mt-1 flex items-center justify-center md:justify-start gap-1">
                    <i class="ph-fill ph-graduation-cap text-primary"></i> Siswa Kelas X PPLG
                </p>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-3 text-sm text-gray-600">
                    <span class="flex items-center gap-1"><i class="ph-fill ph-star text-yellow-400 text-lg"></i> 4.9 (120 Ulasan)</span>
                    <span class="flex items-center gap-1"><i class="ph-fill ph-box-arrow-up text-green-500 text-lg"></i> 345 Terjual</span>
                    <span class="flex items-center gap-1"><i class="ph-fill ph-map-pin text-red-500 text-lg"></i> SMK Bakti Nusantara 666</span>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                <a href="#" onclick="openMiniChat(event)" class="flex-1 md:flex-none px-6 py-2.5 bg-white text-primary font-bold border border-primary rounded-lg shadow-sm hover:bg-blue-50 transition flex items-center justify-center gap-2">
                    <i class="ph-bold ph-chat-circle"></i> Chat
                </a>
            </div>
        </div>
        
        <!-- Bio / Description -->
        <div class="px-6 md:px-10 py-6 border-t border-gray-100 bg-gray-50/50">
            <h3 class="font-bold text-gray-900 mb-2">Tentang Penjual</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
                Halo! Ini adalah toko resmi milik Budi Santoso, siswa kelas X PPLG. Di sini saya menyediakan berbagai macam karya dan jasa, mulai dari pembuatan website, desain grafis, hingga merchandise unik SMK. Mari dukung karya siswa!
            </p>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="flex items-center gap-6 border-b border-gray-200 mb-6">
        <button class="pb-3 px-2 border-b-2 border-primary text-primary font-bold text-sm md:text-base">Produk Dijual (4)</button>
        <button class="pb-3 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm md:text-base transition">Ulasan Pembeli</button>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        
        <!-- Product Card 1 -->
        <a href="#" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group flex flex-col h-full">
            <div class="relative w-full aspect-square overflow-hidden bg-gray-100">
                <img src="https://picsum.photos/seed/seragam/300/300" alt="Produk" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                <div class="absolute top-2 left-2 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded">Promo</div>
            </div>
            <div class="p-3 md:p-4 flex flex-col flex-grow">
                <h3 class="text-sm text-gray-800 line-clamp-2 leading-tight group-hover:text-primary transition mb-2">Seragam SD Merah Putih Lengan Pendek</h3>
                <div class="mt-auto">
                    <div class="font-bold text-primary text-lg">Rp55.000</div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center text-xs text-gray-500 gap-1">
                            <i class="ph-fill ph-star text-yellow-400"></i> 4.8
                        </div>
                        <div class="text-xs text-gray-500">Terjual 120</div>
                    </div>
                </div>
            </div>
        </a>

        <!-- Product Card 2 -->
        <a href="#" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group flex flex-col h-full">
            <div class="relative w-full aspect-square overflow-hidden bg-gray-100">
                <img src="https://picsum.photos/seed/desain/300/300" alt="Produk" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
            </div>
            <div class="p-3 md:p-4 flex flex-col flex-grow">
                <h3 class="text-sm text-gray-800 line-clamp-2 leading-tight group-hover:text-primary transition mb-2">Jasa Pembuatan Logo Bisnis & E-Sports</h3>
                <div class="mt-auto">
                    <div class="font-bold text-primary text-lg">Rp150.000</div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center text-xs text-gray-500 gap-1">
                            <i class="ph-fill ph-star text-yellow-400"></i> 5.0
                        </div>
                        <div class="text-xs text-gray-500">Terjual 34</div>
                    </div>
                </div>
            </div>
        </a>

        <!-- Product Card 3 -->
        <a href="#" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group flex flex-col h-full">
            <div class="relative w-full aspect-square overflow-hidden bg-gray-100">
                <img src="https://picsum.photos/seed/sepatu/300/300" alt="Produk" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
            </div>
            <div class="p-3 md:p-4 flex flex-col flex-grow">
                <h3 class="text-sm text-gray-800 line-clamp-2 leading-tight group-hover:text-primary transition mb-2">Sepatu Sekolah Hitam Polos Anti Slip</h3>
                <div class="mt-auto">
                    <div class="font-bold text-primary text-lg">Rp120.000</div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center text-xs text-gray-500 gap-1">
                            <i class="ph-fill ph-star text-yellow-400"></i> 4.5
                        </div>
                        <div class="text-xs text-gray-500">Terjual 89</div>
                    </div>
                </div>
            </div>
        </a>
        
        <!-- Product Card 4 -->
        <a href="#" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group flex flex-col h-full">
            <div class="relative w-full aspect-square overflow-hidden bg-gray-100">
                <img src="https://picsum.photos/seed/buku/300/300" alt="Produk" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
            </div>
            <div class="p-3 md:p-4 flex flex-col flex-grow">
                <h3 class="text-sm text-gray-800 line-clamp-2 leading-tight group-hover:text-primary transition mb-2">Buku Tulis Sinar Dunia 38 Lembar (10 Pcs)</h3>
                <div class="mt-auto">
                    <div class="font-bold text-primary text-lg">Rp35.000</div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center text-xs text-gray-500 gap-1">
                            <i class="ph-fill ph-star text-yellow-400"></i> 4.9
                        </div>
                        <div class="text-xs text-gray-500">Terjual 210</div>
                    </div>
                </div>
            </div>
        </a>

    </div>
</div>

@endsection
