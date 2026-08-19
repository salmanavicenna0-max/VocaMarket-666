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
        
        <!-- LEFT COLUMN: Image & Video Gallery (Sticky) -->
        <div class="md:col-span-4">
            <div class="flex flex-col gap-3">
                <!-- Main Media Box -->
                <div class="w-full aspect-square bg-gray-100 rounded-2xl overflow-hidden border border-gray-100 relative group flex items-center justify-center" id="main-media-container">
                    @if($product->primaryImage() && $product->primaryImage()->is_video)
                        <video controls src="{{ asset('storage/' . $product->primaryImage()->path) }}" class="w-full h-full object-cover" id="main-product-media"></video>
                    @else
                        <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-105" id="main-product-media">
                    @endif
                    @if($product->is_promo)
                    <div class="absolute top-2 left-2 bg-accent text-gray-900 text-xs font-bold px-3 py-1 rounded-full shadow-sm z-10">Promo Extra</div>
                    @endif
                    @if($product->discount_percentage)
                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-sm z-10">{{ $product->discount_percentage }}% OFF</div>
                    @endif
                </div>

                <!-- Thumbnails Gallery (Max 6 Media) -->
                @if($product->images->count() > 0)
                <div class="grid grid-cols-6 gap-2" id="thumb-gallery-container">
                    @foreach($product->images->take(6) as $index => $img)
                    <div class="aspect-square bg-gray-100 rounded-xl border-2 {{ $index === 0 ? 'border-primary' : 'border-gray-200 hover:border-primary' }} overflow-hidden cursor-pointer relative group transition flex items-center justify-center thumb-media-item" onclick="changeMainMedia('{{ asset('storage/' . $img->path) }}', {{ $img->is_video ? 'true' : 'false' }}, this)">
                        @if($img->is_video)
                            <video src="{{ asset('storage/' . $img->path) }}" class="w-full h-full object-cover pointer-events-none"></video>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center pointer-events-none">
                                <i class="ph-fill ph-play-circle text-white text-lg"></i>
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
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
                @if(!$product->isJasa())
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
                @endif
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
                    @if($product->seller && $product->seller->profile && ($product->seller->profile->foto || $product->seller->profile->photo))
                        <img src="{{ asset('storage/' . ($product->seller->profile->foto ?? $product->seller->profile->photo)) }}" alt="{{ $product->seller->name }}" class="w-14 h-14 rounded-full object-cover border border-gray-200 shadow-sm hover:opacity-80 transition">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($product->seller->name ?? 'Toko') }}&background=0a84d4&color=fff&size=128" alt="{{ $product->seller->name ?? 'Toko' }}" class="w-14 h-14 rounded-full object-cover border border-gray-200 shadow-sm hover:opacity-80 transition">
                    @endif
                </a>
                <div class="flex flex-col flex-1">
                    <a href="{{ route('seller.profile', $product->user_id ?? 1) }}" class="font-bold text-gray-900 text-base flex items-center gap-1.5 hover:text-primary transition w-fit">
                        <i class="ph-fill ph-check-circle text-primary"></i> 
                        {{ $product->seller && $product->seller->profile && $product->seller->profile->nama_toko ? $product->seller->profile->nama_toko : ($product->seller ? ('Toko ' . $product->seller->name) : ($product->store_name ?: 'Toko Esemka')) }}
                    </a>
                </div>
                <a href="#" onclick="event.preventDefault(); startNewChat({{ $product->user_id ?? 1 }}, {{ $product->id }})" class="px-5 py-2 border border-primary text-primary font-bold rounded-xl hover:bg-blue-50 transition text-sm flex items-center gap-1.5">
                    <i class="ph-bold ph-chat-circle text-lg"></i> Chat Langsung
                </a>
            </div>

        </div>

        <!-- RIGHT COLUMN: Checkout Card -->
        <div class="md:col-span-3">
            @if($product->isJasa())
            <div class="bg-white rounded-2xl shadow-lg shadow-gray-100/50 border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-5">
                    <span class="text-gray-500 text-sm">Harga Mulai Dari</span>
                    <span class="font-bold text-gray-900 text-lg">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                  <div class="flex flex-col gap-2">
                      @if(isset($activeServiceRequest))
                          @if($activeServiceRequest->status === 'quoted')
                              <a href="{{ route('orders.index') }}?tab=jasa" class="w-full text-center py-2.5 bg-blue-500 text-white font-bold rounded-xl hover:bg-blue-600 transition shadow-sm flex items-center justify-center gap-2">
                                  <i class="ph-bold ph-bell-ringing"></i> Penawaran Tersedia (Lihat)
                              </a>
                          @else
                              <a href="{{ route('orders.index') }}?tab=jasa" class="w-full text-center py-2.5 bg-yellow-500 text-white font-bold rounded-xl hover:bg-yellow-600 transition shadow-sm flex items-center justify-center gap-2">
                                  <i class="ph-bold ph-hourglass"></i> Menunggu Penawaran
                              </a>
                          @endif
                      @else
                          <button type="button" onclick="openServiceModal()" class="w-full py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-sm">
                              Ajukan Pemesanan Jasa
                          </button>
                      @endif
                  </div>
                <div class="mt-4 flex items-center justify-between text-xs text-gray-500">
                    <span class="flex items-center gap-1"><i class="ph-bold ph-shield-check text-green-500 text-sm"></i> Aman & Terpercaya</span>
                    <span class="flex items-center gap-1"><i class="ph-bold ph-chat-circle text-blue-500 text-sm"></i> Bisa Diskusi</span>
                </div>
            </div>
            @else
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="bg-white rounded-2xl shadow-lg shadow-gray-100/50 border border-gray-200 p-5">
                @csrf
                <input type="hidden" name="quantity" value="1">
                
                <!-- Subtotal -->
                <div class="flex items-center justify-between mb-5">
                    <span class="text-gray-500 text-sm">Subtotal</span>
                    <span class="font-bold text-gray-900 text-lg">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-2.5">
                    <button type="submit" class="w-full py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-sm flex items-center justify-center gap-1.5">
                        <i class="ph-bold ph-shopping-cart-simple text-lg"></i> + Keranjang
                    </button>
                    <button type="submit" name="buy_now" value="1" class="w-full py-2.5 bg-white text-primary font-bold border-2 border-primary rounded-xl hover:bg-blue-50 transition flex items-center justify-center gap-1.5">
                        <i class="ph-bold ph-lightning text-lg"></i> Beli Langsung
                    </button>
                </div>
            </form>
            @endif
        </div>

    </div>
</div>

<script>
function changeMainMedia(mediaUrl, isVideo, thumbEl) {
    const container = document.getElementById('main-media-container');
    
    // Reset borders on all thumbnails
    document.querySelectorAll('.thumb-media-item').forEach(el => {
        el.classList.remove('border-primary');
        el.classList.add('border-gray-200');
    });
    
    // Highlight clicked thumbnail
    if (thumbEl) {
        thumbEl.classList.remove('border-gray-200');
        thumbEl.classList.add('border-primary');
    }

    if (isVideo) {
        container.innerHTML = `
            <video controls autoplay src="${mediaUrl}" class="w-full h-full object-cover" id="main-product-media"></video>
        `;
    } else {
        container.innerHTML = `
            <img src="${mediaUrl}" class="w-full h-full object-cover transition duration-300 group-hover:scale-105" id="main-product-media">
        `;
    }
}
</script>
@endsection

@section('scripts')
    @if($product->isJasa())
    <!-- Modal Ajukan Jasa -->
    <div id="serviceModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-lg text-gray-900">Ajukan Pemesanan Jasa</h3>
                <button type="button" onclick="closeServiceModal()" class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors">X</button>
            </div>
            <form action="{{ url('/service-request/' . $product->id) }}" method="POST" class="p-6">
                @csrf
                <p class="text-sm text-gray-600 mb-4">Deskripsikan spesifikasi, ukuran, tema, atau permintaan khusus Anda untuk jasa <b>{{ $product->name }}</b> secara detail agar penjual dapat memberikan penawaran harga yang akurat.</p>
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Kebutuhan</label>
                    <textarea name="description" rows="5" required class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition" placeholder="Contoh: Saya membutuhkan jasa ini untuk..."></textarea>
                </div>
                <div class="flex gap-3 justify-end mt-6">
                    <button type="button" onclick="closeServiceModal()" class="px-5 py-2.5 text-gray-600 font-bold hover:bg-gray-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-primary text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-md">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openServiceModal() { document.getElementById('serviceModal').classList.remove('hidden'); }
        function closeServiceModal() { document.getElementById('serviceModal').classList.add('hidden'); }
    </script>
    @endif
@endsection
