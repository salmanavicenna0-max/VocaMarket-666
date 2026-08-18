@extends('layouts.app')
@section('title', 'Beranda - VocaMarket')
@section('content')
    <!-- Carousel Section -->
            <div class="relative w-full overflow-hidden bg-white" id="main-carousel">
                <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar scroll-smooth" id="carousel-track">
                    
                    @if($homepageBanners->isNotEmpty())
                        @foreach($homepageBanners as $banner)
                        <div class="w-full shrink-0 snap-center relative">
                            <img src="{{ str_starts_with($banner->image_path, 'images/') ? asset($banner->image_path) : asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}" class="w-full h-[300px] md:h-[450px] object-cover object-center">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end">
                                <div class="container mx-auto px-6 pb-12 md:pb-16 text-white">
                                    @if($banner->badge_text)
                                        <span class="bg-accent text-gray-900 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide mb-3 inline-block">{{ $banner->badge_text }}</span>
                                    @endif
                                    @if($banner->title)
                                        <h2 class="text-3xl md:text-5xl font-extrabold mb-2 text-shadow">{{ $banner->title }}</h2>
                                    @endif
                                    @if($banner->subtitle)
                                        <p class="text-sm md:text-lg font-medium text-gray-100 max-w-xl text-shadow-sm">{{ $banner->subtitle }}</p>
                                    @endif
                                    @if($banner->button_link)
                                        <a href="{{ $banner->button_link }}" class="mt-4 inline-block bg-primary text-white font-bold px-6 py-2.5 rounded shadow hover:bg-primary-dark transition">{{ $banner->button_text }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif

                </div>

                <!-- Controls -->
                <button id="btn-prev"
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/40 hover:bg-white text-gray-900 p-2 rounded-full backdrop-blur transition shadow hover:shadow-lg">
                    <i class="ph-bold ph-caret-left text-xl md:text-2xl"></i>
                </button>
                <button id="btn-next"
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/40 hover:bg-white text-gray-900 p-2 rounded-full backdrop-blur transition shadow hover:shadow-lg">
                    <i class="ph-bold ph-caret-right text-xl md:text-2xl"></i>
                </button>

                <!-- Indicators -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-2" id="carousel-indicators">
                    @php $slideCount = $homepageBanners->isNotEmpty() ? $homepageBanners->count() : 5; @endphp
                    @for($i = 0; $i < $slideCount; $i++)
                        <button class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full {{ $i === 0 ? 'bg-white' : 'bg-white/50 hover:bg-white' }} transition indicator-dot" data-index="{{ $i }}"></button>
                    @endfor
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const track = document.getElementById('carousel-track');
                    const btnPrev = document.getElementById('btn-prev');
                    const btnNext = document.getElementById('btn-next');
                    const dots = document.querySelectorAll('.indicator-dot');

                    let currentIndex = 0;
                    const slideCount = {{ $slideCount }};

                    const updateDots = (index) => {
                        dots.forEach((dot, i) => {
                            dot.classList.toggle('bg-white', i === index);
                            dot.classList.toggle('bg-white/50', i !== index);
                        });
                    };

                    const scrollToIndex = (index) => {
                        if (index < 0) index = slideCount - 1;
                        if (index >= slideCount) index = 0;
                        currentIndex = index;
                        track.scrollTo({
                            left: track.clientWidth * currentIndex,
                            behavior: 'smooth'
                        });
                        updateDots(currentIndex);
                    };

                    btnNext.addEventListener('click', () => scrollToIndex(currentIndex + 1));
                    btnPrev.addEventListener('click', () => scrollToIndex(currentIndex - 1));

                    dots.forEach(dot => {
                        dot.addEventListener('click', (e) => {
                            scrollToIndex(parseInt(e.target.dataset.index));
                        });
                    });

                    let autoScrollInterval = setInterval(() => {
                        scrollToIndex(currentIndex + 1);
                    }, 4000);

                    const carousel = document.getElementById('main-carousel');
                    carousel.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
                    carousel.addEventListener('mouseleave', () => {
                        autoScrollInterval = setInterval(() => scrollToIndex(currentIndex + 1), 4000);
                    });

                    let scrollTimeout;
                    track.addEventListener('scroll', () => {
                        clearTimeout(scrollTimeout);
                        scrollTimeout = setTimeout(() => {
                            const index = Math.round(track.scrollLeft / track.clientWidth);
                            if (index !== currentIndex) {
                                currentIndex = index;
                                updateDots(currentIndex);
                            }
                        }, 150);
                    });
                });
            </script>

            <div class="container mx-auto px-4 relative z-10 pt-6">
                <div class="bg-white rounded-sm shadow-sm border border-gray-200">
                    <div class="p-4 border-b border-gray-100">
                        <h2 class="text-gray-500 font-medium text-sm md:text-base">KATEGORI</h2>
                    </div>
                    <!-- Grid 7 cols on desktop, 1 on mobile -->
                    <!-- Added divide-y-4 for mobile and divide-x-4 for desktop to create a clear boundary -->
                    <div class="grid grid-cols-1 lg:grid-cols-7 border-l border-t border-gray-100 divide-y-4 lg:divide-y-0 lg:divide-x-4 divide-gray-100">

                        <!-- ============================================== -->
                        <!-- PRODUK SEKOLAH (3 columns) -->
                        <!-- ============================================== -->
                        <div class="lg:col-span-3 flex flex-col">
                            <div class="px-4 py-2.5 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                                <span class="text-[11px] md:text-xs font-bold text-gray-500 uppercase tracking-wider">Produk Sekolah</span>
                            </div>
                            <div class="grid grid-cols-3 flex-grow">
                                <a href="{{ route('kategori', 'aksesoris') }}" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                                    <i class="ph-fill ph-handbag text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                                    <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Aksesoris</span>
                                </a>
                                <a href="{{ route('kategori', 'merchandise') }}" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                                    <i class="ph-fill ph-t-shirt text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                                    <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Merchandise</span>
                                </a>
                                <a href="{{ route('kategori', 'hardware') }}" class="flex flex-col items-center justify-center p-4 border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                                    <i class="ph-fill ph-cpu text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                                    <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Hardware</span>
                                </a>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- JASA SETIAP JURUSAN (4 columns) -->
                        <!-- ============================================== -->
                        <div class="lg:col-span-4 flex flex-col">
                            <div class="px-4 py-2.5 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                                <span class="text-[11px] md:text-xs font-bold text-gray-500 uppercase tracking-wider">Jasa Setiap Jurusan</span>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 flex-grow">
                                <a href="{{ route('kategori', 'dkv-animasi') }}" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                                    <i class="ph-fill ph-video-camera text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                                    <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">DKV & Animasi</span>
                                </a>
                                <a href="{{ route('kategori', 'pemasaran') }}" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 md:border-r bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                                    <i class="ph-fill ph-megaphone text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                                    <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Pemasaran</span>
                                </a>
                                <a href="{{ route('kategori', 'pplg') }}" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                                    <i class="ph-fill ph-code text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                                    <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">PPLG</span>
                                </a>
                                <a href="{{ route('kategori', 'akuntansi') }}" class="flex flex-col items-center justify-center p-4 border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                                    <i class="ph-fill ph-calculator text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                                    <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Akuntansi</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        <!-- REKOMENDASI SECTION -->
        <div class="container mx-auto px-4 relative z-10 pt-8 pb-16">
            
            <!-- Sticky/Tab Header -->
            <div class="bg-white rounded-t-sm shadow-sm border-b border-gray-200 flex mb-2 sticky top-0 z-40">
                <div class="py-4 px-8 border-b-4 border-primary text-primary font-bold text-base md:text-lg text-center flex-1 md:flex-none uppercase tracking-wide">
                    Rekomendasi Untuk Anda
                </div>
            </div>
            
            <!-- Product Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2 mb-8">
                @foreach($products as $product)
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
                                    {{ $product->seller && $product->seller->profile && $product->seller->profile->nama_toko ? $product->seller->profile->nama_toko : ($product->seller ? ('Toko ' . $product->seller->name) : ($product->store_name ?: 'Toko Esemka')) }}
                                </span>
                                <span class="text-[11px] font-medium text-primary bg-blue-50 px-2 py-0.5 rounded">{{ ucfirst($product->type ?? 'Produk') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div><div class="flex justify-center mt-8">
                <button class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-12 py-2 rounded-sm shadow-sm transition font-medium">Muat Lebih Banyak</button>
            </div>
        </div>

            <!-- LOKASI TOKO SECTION -->
            <div class="container mx-auto px-4 relative z-10 pt-4 pb-12">
                <div class="bg-white rounded-sm shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 flex items-center gap-2">
                        <i class="ph-fill ph-map-pin-line text-2xl text-primary"></i>
                        <h2 class="text-gray-800 font-bold text-base uppercase tracking-wide">Lokasi Toko Kami</h2>
                    </div>
                    <div class="w-full h-80 relative bg-gray-100">
                        <iframe
                            src="https://maps.google.com/maps?q=SMK%20Bakti%20Nusantara%20666&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" class="absolute inset-0 w-full h-full">
                        </iframe>
                    </div>
                    <div
                        class="p-5 bg-gray-50 text-[13px] text-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-start gap-2">
                            <i class="ph-fill ph-buildings text-lg text-gray-400 mt-0.5"></i>
                            <p><strong>SMK Bakti Nusantara 666</strong><br>JL. PERCOBAAN KM. 17 NO. 65 CILEUNYI, Kec. Cileunyi, Kab. Bandung, Prov. Jawa Barat</p>
                        </div>
                        <a href="https://www.google.com/maps/place/SMK+Bakti+Nusantara+666/@-6.9399542,107.7380657,17.15z/data=!4m6!3m5!1s0x2e68c3407e51c4a3:0x3e434e3f31a8c4b3!8m2!3d-6.941331!4d107.7399631!16s%2Fg%2F1hm4xqyvs?hl=id-ID&entry=ttu&g_ep=EgoyMDI2MDgxMi4wIKXMDSoASAFQAw%3D%3D" target="_blank"
                            class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded text-xs font-bold transition flex items-center gap-1 shrink-0">
                            <i class="ph-bold ph-arrow-square-out text-sm"></i> Buka di Maps
                        </a>
                    </div>
                </div>
            </div>


@endsection


