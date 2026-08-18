@extends('layouts.app')
@section('title', $product->name . ' - VocaMarket')

@section('content')
<div class="container mx-auto px-4 pt-8 pb-24 text-gray-800 max-w-7xl flex-1">
    
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex items-center gap-2 font-medium">
        <a href="{{ url('/') }}" class="hover:text-primary transition">Beranda</a>
        <i class="ph-bold ph-caret-right text-[10px] text-gray-400"></i>
        <a href="#" class="hover:text-primary transition">Kategori</a>
        <i class="ph-bold ph-caret-right text-[10px] text-gray-400"></i>
        <a href="#" class="hover:text-primary transition">{{ $product->type == 'produk' ? 'Produk Sekolah' : 'Jasa' }}</a>
        <i class="ph-bold ph-caret-right text-[10px] text-gray-400"></i>
        <span class="text-primary truncate w-32 md:w-auto">{{ $product->name }}</span>
    </div>

    <!-- 3-Column Modern Grid Layout -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 relative">
        
        <!-- LEFT COLUMN: Image Gallery (Sticky) -->
        <div class="md:col-span-4">
            <div class="flex flex-col gap-3">
                <!-- Main Image -->
                <div class="w-full aspect-square bg-gray-100 rounded-2xl overflow-hidden border border-gray-100 relative group">
                    <img src="{{ $product->thumbnail }}" alt="Product Image" class="w-full h-full object-cover transition duration-300 group-hover:scale-105" id="main-product-image">
                    @if($product->is_promo)
                    <div class="absolute top-2 left-2 bg-accent text-gray-900 text-xs font-bold px-3 py-1 rounded-full shadow-sm">Promo Extra</div>
                    @endif
                    @if($product->discount_percentage)
                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-sm">{{ $product->discount_percentage }}% OFF</div>
                    @endif
                </div>
                <!-- Thumbnails -->
                <div class="grid grid-cols-4 gap-3">
                    <div class="aspect-square bg-gray-100 rounded-xl border-2 border-primary overflow-hidden cursor-pointer">
                        <img src="{{ $product->thumbnail }}" class="w-full h-full object-cover">
                    </div>
                    <div class="aspect-square bg-gray-50 rounded-xl border border-gray-200 hover:border-primary overflow-hidden cursor-pointer transition flex items-center justify-center text-gray-400 hover:text-primary hover:bg-blue-50">
                        <i class="ph ph-image text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- MIDDLE COLUMN: Product Details & Store Info -->
        <div class="md:col-span-5 flex flex-col pb-10">
            
            <!-- Title -->
            <h1 class="text-xl md:text-2xl font-bold leading-snug mb-3 text-gray-900">
                {{ $product->name }}
            </h1>
            
            <!-- Rating & Sales -->
            <div class="flex flex-wrap items-center gap-4 text-sm mb-4 text-gray-600">
                @if($product->sales_count > 0)
                <div class="flex items-center gap-1 font-bold">
                    Terjual <span class="text-gray-900 ml-1">{{ $product->sales_count >= 10000 ? floor($product->sales_count / 1000) . 'RB+' : number_format($product->sales_count, 0, ',', '.') }}</span>
                </div>
                <div class="w-1.5 h-1.5 rounded-full bg-gray-300 hidden md:block"></div>
                @endif
                <div class="flex items-center gap-1.5">
                    @php
                        $avgRating = $product->reviews->avg('rating') ?? 0;
                        $totalReviews = $product->reviews->count();
                    @endphp
                    <i class="ph-fill ph-star text-accent text-lg"></i>
                    <span class="font-bold text-gray-900">{{ number_format($avgRating, 1) }}</span> 
                    <span class="text-gray-500">({{ number_format($totalReviews, 0, ',', '.') }} rating)</span>
                </div>
            </div>

            <!-- Price Section -->
            <div class="mb-6">
                <div class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                </div>
                @if($product->original_price)
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-gray-400 line-through text-sm">Rp{{ number_format($product->original_price, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>

            <!-- Divider -->
            <hr class="border-gray-200 mb-6">

            <!-- Detail Spesifikasi -->
            <h2 class="text-lg font-bold text-gray-900 mb-3">Detail Produk</h2>
            <div class="flex flex-col gap-3 text-sm text-gray-600 mb-6">
                <div class="flex items-center">
                    <span class="w-32 text-gray-500">Kondisi</span>
                    <span class="font-medium text-gray-900 bg-gray-100 px-2 py-0.5 rounded-md">Baru</span>
                </div>
                <div class="flex items-center">
                    <span class="w-32 text-gray-500">Min. Pemesanan</span>
                    <span class="font-medium text-gray-900">1 Buah</span>
                </div>
                <div class="flex items-center">
                    <span class="w-32 text-gray-500">Stok</span>
                    <span class="font-medium text-gray-900">{{ number_format($product->stock, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-32 text-gray-500">Etalase</span>
                    <a href="#" class="font-medium text-primary hover:underline">{{ $product->category }}</a>
                </div>
            </div>

            <!-- Deskripsi -->
            <h2 class="text-lg font-bold text-gray-900 mb-3">Deskripsi</h2>
            <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line mb-8">
                {{ $product->description }}
            </div>
            
            <hr class="border-gray-200 mb-6">

            <!-- Store Profile (Tokopedia Style inside middle column) -->
            <div class="flex items-center gap-4 py-2">
                <a href="{{ route('seller.profile', $product->user_id ?? 1) }}" class="shrink-0 block">
                    <img src="https://picsum.photos/seed/{{ Str::slug($product->seller ? $product->seller->name : 'Toko') }}/100/100" class="w-14 h-14 rounded-full object-cover border border-gray-200 shadow-sm hover:opacity-80 transition">
                </a>
                <div class="flex flex-col flex-1">
                    <a href="{{ route('seller.profile', $product->user_id ?? 1) }}" class="font-bold text-gray-900 text-base flex items-center gap-1.5 hover:text-primary transition w-fit">
                        <i class="ph-fill ph-check-circle text-primary"></i> 
                        {{ $product->seller ? 'Toko ' . $product->seller->name : ($product->store_name ?: 'Toko Esemka') }}
                    </a>
                </div>
                <a href="#" onclick="openMiniChat(event)" class="px-5 py-2 border border-primary text-primary font-bold rounded-xl hover:bg-blue-50 transition text-sm flex items-center gap-1.5">
                    <i class="ph-bold ph-chat-circle text-lg"></i> Chat Langsung
                </a>
            </div>

        </div>

        <!-- RIGHT COLUMN: Checkout Card -->
        <div class="md:col-span-3">
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="bg-white rounded-2xl shadow-lg shadow-gray-100/50 border border-gray-200 p-5">
                @csrf
                <input type="hidden" name="quantity" value="1">
                
                <!-- Subtotal -->
                <div class="flex items-center justify-between mb-5">
                    <span class="text-gray-500 text-sm">Subtotal</span>
                    <span class="font-bold text-gray-900 text-lg">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-2">
                    <button type="submit" class="w-full py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-sm">
                        + Keranjang
                    </button>
                    <a href="{{ url('/checkout') }}" class="w-full py-2.5 bg-white text-primary font-bold border border-primary rounded-xl hover:bg-blue-50 transition flex items-center justify-center">
                        Beli Langsung
                    </a>
                </div>
                
                <!-- Extras -->
                <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                    <button type="button" class="flex items-center gap-1 hover:text-gray-800 transition">
                        <i class="ph-bold ph-share-network"></i> Share
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
