@extends('layouts.app')
@section('title', 'Beranda - VocaMarket')
@section('content')
<!-- Carousel Section -->
        <div class="relative w-full overflow-hidden bg-white" id="main-carousel">
            <!-- Carousel Container -->
            <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar scroll-smooth" id="carousel-track">
                
                <!-- Slide 1: Promo Seragam -->
                <div class="w-full shrink-0 snap-center relative">
                    <img src="{{ asset('images/banner_seragam_1786530000359.png') }}" alt="Promo Produk Sekolah" class="w-full h-[300px] md:h-[450px] object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end">
                        <div class="container mx-auto px-6 pb-12 md:pb-16 text-white">
                            <span class="bg-accent text-gray-900 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide mb-3 inline-block">Produk Esemka</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold mb-2 text-shadow">Koleksi Produk Sekolah</h2>
                            <p class="text-sm md:text-lg font-medium text-gray-100 max-w-xl text-shadow-sm">Temukan Aksesoris, Merchandise, dan perlengkapan lainnya karya siswa Esemka.</p>
                            <button class="mt-4 bg-primary text-white font-bold px-6 py-2.5 rounded shadow hover:bg-primary-dark transition">Lihat Katalog</button>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: Diskon Buku Tulis -->
                <div class="w-full shrink-0 snap-center relative">
                    <img src="{{ asset('images/banner_buku_1786530030265.png') }}" alt="Jasa DKV dan Animasi" class="w-full h-[300px] md:h-[450px] object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end">
                        <div class="container mx-auto px-6 pb-12 md:pb-16 text-white">
                            <span class="bg-accent text-gray-900 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide mb-3 inline-block">Jasa Profesional</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold mb-2 text-shadow">Layanan DKV & Animasi</h2>
                            <p class="text-sm md:text-lg font-medium text-gray-100 max-w-xl text-shadow-sm">Butuh Desain Grafis, Video Promosi, atau Motion Graphic? Serahkan pada ahlinya.</p>
                            <button class="mt-4 bg-primary text-white font-bold px-6 py-2.5 rounded shadow hover:bg-primary-dark transition">Pesan Jasa</button>
                        </div>
                    </div>
                </div>

                <!-- Slide 3: Atribut Pramuka -->
                <div class="w-full shrink-0 snap-center relative">
                    <img src="{{ asset('images/banner_pramuka_1786530042974.png') }}" alt="Jasa PPLG" class="w-full h-[300px] md:h-[450px] object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end">
                        <div class="container mx-auto px-6 pb-12 md:pb-16 text-white">
                            <span class="bg-accent text-gray-900 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide mb-3 inline-block">Solusi IT</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold mb-2 text-shadow">Layanan Jasa PPLG</h2>
                            <p class="text-sm md:text-lg font-medium text-gray-100 max-w-xl text-shadow-sm">Pembuatan Website, Aplikasi Mobile, Hosting, hingga Game Development.</p>
                            <button class="mt-4 bg-primary text-white font-bold px-6 py-2.5 rounded shadow hover:bg-primary-dark transition">Konsultasi Sekarang</button>
                        </div>
                    </div>
                </div>

                <!-- Slide 4: Tas & Sepatu -->
                <div class="w-full shrink-0 snap-center relative">
                    <img src="{{ asset('images/banner_tas_1786530062086.png') }}" alt="Jasa Pemasaran & Akuntansi" class="w-full h-[300px] md:h-[450px] object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end">
                        <div class="container mx-auto px-6 pb-12 md:pb-16 text-white">
                            <span class="bg-accent text-gray-900 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide mb-3 inline-block">Bisnis & Finansial</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold mb-2 text-shadow">Pemasaran & Akuntansi</h2>
                            <p class="text-sm md:text-lg font-medium text-gray-100 max-w-xl text-shadow-sm">Solusi Digital Marketing, Pembukuan, hingga Konsultasi Pajak untuk bisnis Anda.</p>
                            <button class="mt-4 bg-primary text-white font-bold px-6 py-2.5 rounded shadow hover:bg-primary-dark transition">Pelajari Lebih Lanjut</button>
                        </div>
                    </div>
                </div>

                <!-- Slide 5: Flash Sale -->
                <div class="w-full shrink-0 snap-center relative">
                    <img src="{{ asset('images/banner_flashsale_1786530082778.png') }}" alt="Flash Sale Kebutuhan Sekolah" class="w-full h-[300px] md:h-[450px] object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end">
                        <div class="container mx-auto px-6 pb-12 md:pb-16 text-white">
                            <span class="bg-red-500 text-white font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide mb-3 inline-block">Waktu Terbatas</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold mb-2 text-shadow">Flash Sale Up to 50%</h2>
                            <p class="text-sm md:text-lg font-medium text-gray-100 max-w-xl text-shadow-sm">Jangan lewatkan diskon besar-besaran untuk kebutuhan sekolah hari ini!</p>
                            <button class="mt-4 bg-primary text-white font-bold px-6 py-2.5 rounded shadow hover:bg-primary-dark transition">Belanja Sekarang</button>
                        </div>
                    </div>
                </div>

            </div>
            
            <!-- Controls -->
            <button id="btn-prev" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/40 hover:bg-white text-gray-900 p-2 rounded-full backdrop-blur transition shadow hover:shadow-lg">
                <i class="ph-bold ph-caret-left text-xl md:text-2xl"></i>
            </button>
            <button id="btn-next" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/40 hover:bg-white text-gray-900 p-2 rounded-full backdrop-blur transition shadow hover:shadow-lg">
                <i class="ph-bold ph-caret-right text-xl md:text-2xl"></i>
            </button>

            <!-- Indicators -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-2" id="carousel-indicators">
                <button class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-white transition indicator-dot" data-index="0"></button>
                <button class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-white/50 hover:bg-white transition indicator-dot" data-index="1"></button>
                <button class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-white/50 hover:bg-white transition indicator-dot" data-index="2"></button>
                <button class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-white/50 hover:bg-white transition indicator-dot" data-index="3"></button>
                <button class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-white/50 hover:bg-white transition indicator-dot" data-index="4"></button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const track = document.getElementById('carousel-track');
                const btnPrev = document.getElementById('btn-prev');
                const btnNext = document.getElementById('btn-next');
                const dots = document.querySelectorAll('.indicator-dot');
                
                let currentIndex = 0;
                const slideCount = 5;

                const updateDots = (index) => {
                    dots.forEach((dot, i) => {
                        dot.classList.toggle('bg-white', i === index);
                        dot.classList.toggle('bg-white/50', i !== index);
                    });
                };

                const scrollToIndex = (index) => {
                    if(index < 0) index = slideCount - 1;
                    if(index >= slideCount) index = 0;
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

                // Auto Scroll
                let autoScrollInterval = setInterval(() => {
                    scrollToIndex(currentIndex + 1);
                }, 4000);

                // Pause on hover
                const carousel = document.getElementById('main-carousel');
                carousel.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
                carousel.addEventListener('mouseleave', () => {
                    autoScrollInterval = setInterval(() => scrollToIndex(currentIndex + 1), 4000);
                });

                // Sync indicator on manual scroll
                let scrollTimeout;
                track.addEventListener('scroll', () => {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => {
                        const index = Math.round(track.scrollLeft / track.clientWidth);
                        if(index !== currentIndex) {
                            currentIndex = index;
                            updateDots(currentIndex);
                        }
                    }, 150);
                });
            });
        </script>

        <!-- KATEGORI SECTION -->
        <div class="container mx-auto px-4 relative z-10 pt-6">
            <div class="bg-white rounded-sm shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-100">
                    <h2 class="text-gray-500 font-medium text-sm md:text-base">KATEGORI</h2>
                </div>
                <!-- Grid 8 cols on desktop, 4 on mobile -->
                <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 border-l border-t border-gray-100">
                    
                    <!-- Kategori: Produk Sekolah -->
                    <div class="col-span-full px-4 py-2.5 bg-gray-50 border-r border-b border-gray-100">
                        <span class="text-[11px] md:text-xs font-bold text-gray-500 uppercase tracking-wider">Produk Sekolah</span>
                    </div>

                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-handbag text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Aksesoris</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-t-shirt text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Merchandise</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-cpu text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Hardware</span>
                    </a>

                    <!-- Kategori: Jasa / Produk Jurusan -->
                    <div class="col-span-full px-4 py-2.5 bg-gray-50 border-r border-b border-gray-100">
                        <span class="text-[11px] md:text-xs font-bold text-gray-500 uppercase tracking-wider">Jasa & Produk Jurusan</span>
                    </div>

                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-palette text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">DKV</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-film-strip text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Animasi</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-megaphone text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Pemasaran</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-code text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">PPLG</span>
                    </a>
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-calculator text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Akuntansi</span>
                    </a>

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
                        <img src="{{ $product->image_path }}" alt="Product" class="w-full h-full object-cover">
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
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-[11px] text-gray-500">{{ $product->sales_count >= 10000 ? floor($product->sales_count / 1000) . 'RB+' : $product->sales_count }} terjual</span>
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
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.24009715112!2d106.74100645000001!3d-6.2297464999999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x100c5e82dd4b820!2sJakarta%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sid!2sid!4v1689150000000!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="absolute inset-0 w-full h-full">
                    </iframe>
                </div>
                <div class="p-5 bg-gray-50 text-[13px] text-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-2">
                        <i class="ph-fill ph-buildings text-lg text-gray-400 mt-0.5"></i>
                        <p><strong>Pusat E-Commerce Sekolah</strong><br>Jl. Pendidikan No. 123, Sudirman, Daerah Khusus Ibukota Jakarta 10110</p>
                    </div>
                    <a href="https://maps.google.com" target="_blank" class="bg-primary hover:bg-blue-700 text-white px-4 py-2 rounded text-xs font-bold transition flex items-center gap-1 shrink-0">
                        <i class="ph-bold ph-arrow-square-out text-sm"></i> Buka di Maps
                    </a>
                </div>
            </div>
        </div>

    
@endsection


