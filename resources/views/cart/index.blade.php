@extends('layouts.app')
@section('title', 'Keranjang Belanja - VocaMarket')

@section('content')
<div class="container mx-auto px-4 pt-6 text-gray-800 max-w-5xl flex-1">
    
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center">
            <li class="inline-flex items-center">
                <a href="{{ url('/') }}" class="inline-flex items-center hover:text-primary transition">
                    Beranda
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="ph-bold ph-caret-right text-xs mx-2"></i>
                    <span class="text-gray-900 font-medium">Keranjang</span>
                </div>
            </li>
        </ol>
    </nav>

    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6">Keranjang Belanja</h1>

    <div class="flex flex-col gap-6">
        
        <!-- Header List (Toko/Produk) - Desktop Only -->
        <div class="hidden md:flex bg-white p-4 rounded-xl shadow-sm border border-gray-200 items-center justify-between text-gray-500 text-sm font-medium">
            <div class="flex items-center gap-3 w-1/2">
                <input type="checkbox" class="w-5 h-5 border-2 border-gray-300 rounded cursor-pointer text-primary" checked>
                <span>Produk</span>
            </div>
            <div class="flex items-center justify-between w-1/2">
                <span class="w-1/3 text-center">Harga Satuan</span>
                <span class="w-1/3 text-center">Kuantitas</span>
                <span class="w-1/3 text-center">Total Harga</span>
                <span class="w-16 text-center">Aksi</span>
            </div>
        </div>

        @forelse($groupedItems as $sellerId => $items)
            @php 
                $seller = $items->first()->product->seller; 
                $sellerName = $seller ? $seller->name : 'Toko VocaMarket';
            @endphp
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex flex-col">
                <!-- Nama Toko -->
                <div class="flex items-center gap-3 border-b border-gray-100 pb-4 mb-4">
                    <input type="checkbox" class="w-5 h-5 border-2 border-gray-300 rounded cursor-pointer text-primary" checked>
                    <i class="ph-fill ph-storefront text-gray-700 text-xl"></i>
                    <a href="{{ url('/seller/' . $sellerId) }}" class="font-bold text-gray-900 text-sm md:text-base hover:text-primary transition">{{ $sellerName }}</a>
                </div>
                
                @foreach($items as $item)
                    <!-- Produk -->
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-4 w-full mt-4 first:mt-0">
                        <div class="flex items-start gap-4 md:w-1/2">
                            <input type="checkbox" class="w-5 h-5 border-2 border-gray-300 rounded cursor-pointer mt-8 md:mt-0 text-primary" checked>
                            <img src="{{ $item->product->thumbnail }}" alt="Produk" class="w-20 h-20 rounded-lg object-cover border border-gray-100 shrink-0">
                            <div class="flex flex-col">
                                <a href="{{ route('product.show', $item->product->id) }}" class="text-sm font-medium text-gray-800 line-clamp-2 hover:text-primary cursor-pointer transition">{{ $item->product->name }}</a>
                                <span class="text-xs text-gray-500 mt-1">Sisa Stok: {{ $item->product->stock }}</span>
                            </div>
                        </div>
                        
                        <div class="flex flex-col md:flex-row items-center justify-between w-full md:w-1/2 gap-4 md:gap-0 mt-4 md:mt-0">
                            <div class="text-gray-700 font-medium md:w-1/3 text-center">Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
                            
                            <!-- Quantity -->
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center justify-center md:w-1/3">
                                @csrf
                                @method('PATCH')
                                <div class="flex items-center border border-gray-300 bg-white overflow-hidden h-8 rounded-sm">
                                    <button type="submit" name="action" value="decrease" class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition border-r border-gray-300"><i class="ph-bold ph-minus text-xs"></i></button>
                                    <input type="text" value="{{ $item->quantity }}" readonly class="w-10 h-full text-center outline-none text-gray-800 text-sm font-medium">
                                    <button type="submit" name="action" value="increase" class="w-8 h-full flex items-center justify-center text-gray-500 hover:bg-gray-100 transition border-l border-gray-300"><i class="ph-bold ph-plus text-xs"></i></button>
                                </div>
                            </form>

                            <div class="text-primary font-bold md:w-1/3 text-center">Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                            
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="md:w-16 text-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-500 hover:text-red-500 transition text-sm">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-200 text-center flex flex-col items-center justify-center">
                <i class="ph-fill ph-shopping-cart text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-bold text-gray-800">Keranjang belanja Anda kosong</h3>
                <p class="text-gray-500 mt-2 mb-6">Silakan telusuri produk yang Anda inginkan dan tambahkan ke keranjang.</p>
                <a href="{{ url('/') }}" class="px-6 py-2 bg-primary hover:bg-blue-700 text-white font-bold rounded-lg transition">Mulai Belanja</a>
            </div>
        @endforelse

    </div>

    <!-- Checkout Summary Bar -->
    @if($cartItems->isNotEmpty())
    <div class="w-full bg-white rounded-xl border border-gray-200 shadow-sm mt-6 mb-12">
        <div class="px-4 md:px-6">
            
            <!-- Main Checkout Row -->
            <div class="flex flex-col md:flex-row items-center justify-between py-4 gap-4">
                
                <!-- Left Actions -->
                <div class="flex items-center gap-6 w-full md:w-auto text-sm text-gray-700">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="w-5 h-5 border-2 border-gray-300 rounded cursor-pointer text-primary" checked>
                        <span>Pilih Semua ({{ $cartItems->count() }})</span>
                    </label>
                </div>
                
                <!-- Right Actions (Total & Button) -->
                <div class="flex items-center justify-between w-full md:w-auto gap-6">
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-700">Total ({{ $cartItems->count() }} produk):</span>
                        <span class="text-xl md:text-2xl font-bold text-primary">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ url('/checkout') }}" class="px-8 py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm text-sm transition">
                        Beli Sekarang
                    </a>
                </div>
                
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
