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
                @if($seller->profile && ($seller->profile->photo || $seller->profile->foto))
                    <img src="{{ asset('storage/' . ($seller->profile->photo ?? $seller->profile->foto)) }}" alt="{{ $seller->name }}" class="w-full h-full object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($seller->name) }}&background=0a84d4&color=fff&size=128" alt="{{ $seller->name }}" class="w-full h-full object-cover">
                @endif
            </div>
            
            <!-- Info -->
            <div class="flex-grow text-center md:text-left pt-4 md:pt-0">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $seller->profile->nama_toko ?? ('Toko ' . $seller->name) }}</h1>
                <p class="text-gray-500 mt-1 flex items-center justify-center md:justify-start gap-1">
                    <i class="ph-fill ph-graduation-cap text-primary"></i> Siswa / Penjual Aktif
                </p>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-3 text-sm text-gray-600">
                    <span class="flex items-center gap-1"><i class="ph-fill ph-star text-yellow-400 text-lg"></i> {{ $rating }} (Toko Aktif)</span>
                    <span class="flex items-center gap-1"><i class="ph-fill ph-box-arrow-up text-green-500 text-lg"></i> {{ $totalSales }} Terjual</span>
                    <span class="flex items-center gap-1"><i class="ph-fill ph-map-pin text-red-500 text-lg"></i> {{ $seller->profile->alamat ?? 'SMK Bakti Nusantara 666' }}</span>
                </div>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-2 text-sm text-gray-600">
                    <span class="flex items-center gap-1"><i class="ph-fill ph-envelope-simple text-blue-500 text-lg"></i> {{ $seller->email }}</span>
                    <span class="flex items-center gap-1"><i class="ph-fill ph-phone text-green-500 text-lg"></i> {{ $seller->profile->no_telp ?? $seller->profile->no_hp ?? 'Belum ada nomor HP' }}</span>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex items-center gap-3 w-full md:w-auto">
                @if(Auth::check() && Auth::id() == $seller->id)
                    <a href="{{ url('/user#konfigurasitoko') }}" class="flex-1 md:flex-none px-6 py-2.5 bg-primary text-white font-bold rounded-lg shadow-sm hover:bg-blue-700 transition flex items-center justify-center gap-2">
                        <i class="ph-bold ph-pencil-simple"></i> Edit Konfigurasi Toko
                    </a>
                @else
                    <a href="#" onclick="openMiniChat(event)" class="flex-1 md:flex-none px-6 py-2.5 bg-white text-primary font-bold border border-primary rounded-lg shadow-sm hover:bg-blue-50 transition flex items-center justify-center gap-2">
                        <i class="ph-bold ph-chat-circle"></i> Chat
                    </a>
                @endif
            </div>
        </div>
        
        <!-- Bio / Description -->
        <div class="px-6 md:px-10 py-6 border-t border-gray-100 bg-gray-50/50">
            <h3 class="font-bold text-gray-900 mb-2">Tentang Penjual</h3>
            <p class="text-gray-600 text-sm leading-relaxed">
                {{ $seller->profile->deskripsi_toko ?? ('Halo! Ini adalah toko resmi milik ' . $seller->name . '. Di sini saya menyediakan berbagai macam produk dan jasa menarik. Mari dukung karya siswa!') }}
            </p>
        </div>
    </div>

    <!-- Product Tabs -->
    <div class="flex items-center gap-6 border-b border-gray-200 mb-6">
        <button class="pb-3 px-2 border-b-2 border-primary text-primary font-bold text-sm md:text-base">Produk Dijual ({{ $totalProducts }})</button>
        <button class="pb-3 px-2 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm md:text-base transition">Ulasan Pembeli</button>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @forelse($products as $product)
        <a href="{{ route('product.show', $product->id) }}" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition group flex flex-col h-full">
            <div class="relative w-full aspect-square overflow-hidden bg-gray-100 flex items-center justify-center">
                @if($product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @else
                    <i class="ph-fill ph-image text-4xl text-gray-400"></i>
                @endif
                @if($product->stock == 0)
                    <div class="absolute top-2 left-2 bg-gray-500 text-white text-xs font-bold px-2 py-1 rounded">Habis</div>
                @endif
            </div>
            <div class="p-3 md:p-4 flex flex-col flex-grow">
                <h3 class="text-sm text-gray-800 line-clamp-2 leading-tight group-hover:text-primary transition mb-2">{{ $product->name }}</h3>
                <div class="mt-auto">
                    <div class="font-bold text-primary text-lg">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center text-xs text-gray-500 gap-1">
                            <i class="ph-fill ph-star text-yellow-400"></i> 4.9
                        </div>
                        <div class="text-xs text-gray-500">Stok {{ $product->stock }}</div>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-10 text-gray-500">
            Toko ini belum memiliki produk yang dijual.
        </div>
        @endforelse
    </div>
</div>

@endsection
