@extends('layouts.app')
@section('title', $categoryName . ' - VocaMarket')
@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Breadcrumb / Header -->
    <div class="mb-6">
        <nav class="flex text-sm text-gray-500 mb-2">
            <a href="{{ url('/') }}" class="hover:text-primary transition">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">{{ $categoryName }}</span>
        </nav>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $categoryName }}</h1>
        <p class="text-gray-500 text-sm mt-1 mb-4">Menampilkan produk untuk kategori {{ $categoryName }}</p>
        
        <!-- Filter Subkategori -->
        @if(count($currentSubcategories) > 0)
        <div class="flex items-center gap-2 overflow-x-auto hide-scrollbar pb-2">
            <a href="#" class="px-4 py-1.5 bg-primary text-white rounded-full text-sm font-medium whitespace-nowrap shadow-sm">Semua</a>
            @foreach($currentSubcategories as $sub)
            <a href="#" class="px-4 py-1.5 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 hover:border-gray-300 rounded-full text-sm font-medium whitespace-nowrap transition shadow-sm">{{ $sub }}</a>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3 mb-8">
        @forelse($products as $product)
        <a href="{{ url('/product/' . $product->id) }}" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
            <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                <img src="{{ $product->thumbnail }}" alt="Product" class="w-full h-full object-cover">
                @if($product->is_promo)
                <!-- Top left badge -->
                <div class="absolute top-0 left-0 bg-accent text-gray-900 text-[9px] font-bold px-1.5 py-0.5 z-10 flex flex-col items-center uppercase shadow-sm">
                    <span>Promo</span>
                    <span>Extra</span>
                </div>
                @endif
                @if($product->discount_percentage)
                <!-- Top right badge -->
                <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-1 z-10 shadow-sm rounded-bl-sm">
                    -{{ $product->discount_percentage }}%
                </div>
                @endif
            </div>
            <div class="p-2.5 flex flex-col flex-1">
                <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                    {{ $product->name }}
                </h3>
                <div class="mt-2 flex flex-col justify-end mt-auto gap-1">
                    <span class="text-primary font-bold text-sm md:text-base">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] text-gray-500 flex items-center gap-1">
                            <i class="ph-fill ph-storefront"></i> 
                            {{ $product->seller ? $product->seller->name : ($product->store_name ?: 'Toko Esemka') }}
                        </span>
                        <span class="text-[11px] font-medium text-primary bg-blue-50 px-2 py-0.5 rounded">{{ ucfirst($product->type ?? 'Produk') }}</span>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full py-12 text-center text-gray-500">
            <i class="ph-fill ph-package text-4xl text-gray-300 mb-2"></i>
            <p>Belum ada produk di kategori ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
