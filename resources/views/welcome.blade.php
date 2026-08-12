<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Sekolah</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#007DCC', // Amazon-like Blue requested
                        accent: '#FFB900',  // Amazon-like Yellow requested
                        'primary-dark': '#0065a6',
                        'accent-hover': '#e6a600'
                    }
                }
            }
        }
    </script>
    <!-- Phosphor Icons for easy UI icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            background-color: #E3E6E6; /* Light gray background like Amazon */
        }
        /* Utility to hide scrollbar for carousel */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .text-shadow {
            text-shadow: 1px 1px 4px rgba(0,0,0,0.8);
        }
        .text-shadow-sm {
            text-shadow: 1px 1px 2px rgba(0,0,0,0.6);
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    <!-- Top Header -->
    <header class="bg-white shadow-sm relative z-50">
        
        <!-- Decorative Ribbon (Two parallel lines) -->
        <!-- Placed in an exact 144px container (h-36) so coordinates map perfectly -->
        <div class="absolute top-0 left-0 w-full h-36 z-0 pointer-events-none overflow-hidden">
            <svg class="w-full h-full opacity-90" preserveAspectRatio="none" viewBox="0 0 1000 144">
                <!-- Top Line (Blue) -->
                <!-- Slanting earlier (260 to 320) to stay clear of the Search Bar -->
                <path d="M -10 102 L 260 102 L 320 45 L 1010 45" fill="none" stroke="#007DCC" stroke-width="10" stroke-linejoin="round" />
                <!-- Bottom Line (Yellow) -->
                <path d="M -10 118 L 260 118 L 320 61 L 1010 61" fill="none" stroke="#FFB900" stroke-width="10" stroke-linejoin="round" />
            </svg>
        </div>

        <div class="container mx-auto px-4 h-36 relative z-10 flex items-center">
            <!-- Left Logo Area -->
            <!-- Aligned to top so it sits above the y=110 ribbon on the left -->
            <div class="w-auto lg:w-1/4 h-full flex items-start pt-6 pr-4 shrink-0">
                <a href="#" class="flex items-center gap-2 text-black">
                    <i class="ph-fill ph-graduation-cap text-4xl md:text-5xl text-primary"></i>
                    <span class="font-bold text-xl md:text-2xl lg:text-3xl tracking-tight">Toko Sekolah</span>
                </a>
            </div>
            
            <!-- Right Area (Search & Navbars) -->
            <div class="flex-1 h-full flex flex-col justify-between">

                <!-- Top Bar Content -->
                <div class="h-12 flex items-center justify-end text-gray-600 text-xs md:text-sm px-4 gap-5">
                    <a href="#" class="hover:text-primary transition font-bold">Promo Hari Ini</a>
                    <span class="text-gray-300">|</span>
                    <a href="#" class="hover:text-primary transition font-bold">Bantuan</a>
                    <span class="text-gray-300">|</span>
                    <a href="#" class="flex items-center gap-1 hover:text-primary transition text-gray-800 font-bold">
                        <i class="ph-fill ph-user text-lg"></i>
                        Masuk / Daftar
                    </a>
                </div>

                <!-- Bottom White Navbar Content (Search & Cart) -->
                <!-- Pushed to the right (justify-end) and added padding (pl-24) to avoid the slanted line -->
                <div class="h-24 flex items-center justify-end pl-12 lg:pl-24">
                    
                    <!-- Search Bar -->
                    <div class="w-full max-w-2xl flex items-center h-12 rounded-lg overflow-hidden shadow-sm border border-gray-200 bg-white">
                        <select class="h-full bg-gray-50 text-gray-700 px-4 text-sm outline-none hover:bg-gray-100 cursor-pointer hidden md:block border-none font-medium">
                            <option>Semua Kategori</option>
                            <option>Seragam</option>
                            <option>Alat Tulis</option>
                        </select>
                        <input type="text" placeholder="Cari kebutuhan sekolah..." class="h-full w-full px-5 text-black outline-none text-sm border-l border-gray-200">
                        <button class="bg-accent hover:bg-accent-hover h-full px-8 text-gray-900 transition flex items-center justify-center">
                            <i class="ph ph-magnifying-glass text-xl font-bold"></i>
                        </button>
                    </div>
                    
                    <!-- Orders & Cart -->
                    <div class="flex items-center gap-6 ml-8 shrink-0 text-gray-700">
                        <!-- Notifications (Removed) -->

                        <!-- Cart -->
                        <a href="#" class="flex items-center gap-2 hover:text-primary transition group">
                            <div class="relative">
                                <span class="absolute -top-1.5 -right-2 bg-accent text-gray-900 text-xs font-bold px-1.5 py-0.5 rounded-full shadow-sm z-10">0</span>
                                <i class="ph ph-shopping-cart text-3xl text-gray-700 group-hover:text-primary"></i>
                            </div>
                            <span class="font-bold text-sm hidden md:block text-gray-800 group-hover:text-primary ml-1">Keranjang</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Navbar (Categories) -->
        <div class="bg-primary-dark text-white text-sm relative z-20">
            <div class="container mx-auto px-4 py-2 flex items-center gap-2 overflow-x-auto whitespace-nowrap hide-scrollbar">
                <a href="#" class="flex items-center gap-1 hover:text-accent font-bold shrink-0">
                    <i class="ph ph-list text-lg"></i> Kategori
                </a>
                <span class="text-white/30 mx-2 shrink-0">|</span>
                <a href="#" class="hover:text-accent shrink-0">Seragam Sekolah</a>
                <a href="#" class="hover:text-accent ml-4 shrink-0">Buku & Alat Tulis</a>
                <a href="#" class="hover:text-accent ml-4 shrink-0">Atribut Pramuka</a>
                <a href="#" class="hover:text-accent ml-4 shrink-0">Tas & Sepatu</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 relative bg-gray-50">
        
        <!-- Carousel Section -->
        <div class="relative w-full overflow-hidden bg-white" id="main-carousel">
            <!-- Carousel Container -->
            <div class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar scroll-smooth" id="carousel-track">
                
                <!-- Slide 1: Promo Seragam -->
                <div class="w-full shrink-0 snap-center relative">
                    <img src="{{ asset('images/banner_seragam_1786530000359.png') }}" alt="Promo Seragam Sekolah" class="w-full h-[300px] md:h-[450px] object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end">
                        <div class="container mx-auto px-6 pb-12 md:pb-16 text-white">
                            <span class="bg-accent text-gray-900 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide mb-3 inline-block">Special Promo</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold mb-2 text-shadow">Promo Seragam Sekolah</h2>
                            <p class="text-sm md:text-lg font-medium text-gray-100 max-w-xl text-shadow-sm">Beli seragam baru dengan kualitas terbaik harga terjangkau untuk tahun ajaran baru.</p>
                            <button class="mt-4 bg-primary text-white font-bold px-6 py-2.5 rounded shadow hover:bg-primary-dark transition">Belanja Sekarang</button>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: Diskon Buku Tulis -->
                <div class="w-full shrink-0 snap-center relative">
                    <img src="{{ asset('images/banner_buku_1786530030265.png') }}" alt="Diskon Buku Tulis" class="w-full h-[300px] md:h-[450px] object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end">
                        <div class="container mx-auto px-6 pb-12 md:pb-16 text-white">
                            <span class="bg-accent text-gray-900 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide mb-3 inline-block">Diskon Terbesar</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold mb-2 text-shadow">Gudang Alat Tulis</h2>
                            <p class="text-sm md:text-lg font-medium text-gray-100 max-w-xl text-shadow-sm">Lengkapi kebutuhan alat tulis dan buku pelajaran kamu di sini.</p>
                            <button class="mt-4 bg-primary text-white font-bold px-6 py-2.5 rounded shadow hover:bg-primary-dark transition">Belanja Sekarang</button>
                        </div>
                    </div>
                </div>

                <!-- Slide 3: Atribut Pramuka -->
                <div class="w-full shrink-0 snap-center relative">
                    <img src="{{ asset('images/banner_pramuka_1786530042974.png') }}" alt="Atribut Pramuka Lengkap" class="w-full h-[300px] md:h-[450px] object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end">
                        <div class="container mx-auto px-6 pb-12 md:pb-16 text-white">
                            <span class="bg-accent text-gray-900 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide mb-3 inline-block">Pramuka Lengkap</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold mb-2 text-shadow">Koleksi Atribut Pramuka</h2>
                            <p class="text-sm md:text-lg font-medium text-gray-100 max-w-xl text-shadow-sm">Dari topi hingga sabuk, temukan semua atribut pramuka dengan mudah.</p>
                            <button class="mt-4 bg-primary text-white font-bold px-6 py-2.5 rounded shadow hover:bg-primary-dark transition">Belanja Sekarang</button>
                        </div>
                    </div>
                </div>

                <!-- Slide 4: Tas & Sepatu -->
                <div class="w-full shrink-0 snap-center relative">
                    <img src="{{ asset('images/banner_tas_1786530062086.png') }}" alt="Tas & Sepatu Sekolah" class="w-full h-[300px] md:h-[450px] object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end">
                        <div class="container mx-auto px-6 pb-12 md:pb-16 text-white">
                            <span class="bg-accent text-gray-900 font-bold px-3 py-1 rounded-full text-xs uppercase tracking-wide mb-3 inline-block">Koleksi Baru</span>
                            <h2 class="text-3xl md:text-5xl font-extrabold mb-2 text-shadow">Tas & Sepatu Sekolah</h2>
                            <p class="text-sm md:text-lg font-medium text-gray-100 max-w-xl text-shadow-sm">Tampil lebih gaya di sekolah dengan koleksi sepatu dan tas terbaru kami.</p>
                            <button class="mt-4 bg-primary text-white font-bold px-6 py-2.5 rounded shadow hover:bg-primary-dark transition">Belanja Sekarang</button>
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
                    
                    <!-- Cat 1 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-t-shirt text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Seragam SD</span>
                    </a>
                    <!-- Cat 2 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-t-shirt text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Seragam SMP</span>
                    </a>
                    <!-- Cat 3 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-t-shirt text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Seragam SMA</span>
                    </a>
                    <!-- Cat 4 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-sneaker text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Sepatu Sekolah</span>
                    </a>
                    <!-- Cat 5 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-backpack text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Tas Sekolah</span>
                    </a>
                    <!-- Cat 6 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-notebook text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Buku Tulis</span>
                    </a>
                    <!-- Cat 7 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-pen-nib text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Alat Tulis</span>
                    </a>
                    <!-- Cat 8 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-tent text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Pramuka</span>
                    </a>
                    
                    <!-- Cat 9 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-palette text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Alat Lukis</span>
                    </a>
                    <!-- Cat 10 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-book-open text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Buku Pelajaran</span>
                    </a>
                    <!-- Cat 11 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-baseball-cap text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Topi & Dasi</span>
                    </a>
                    <!-- Cat 12 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-basketball text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Olahraga</span>
                    </a>
                    <!-- Cat 13 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-socks text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Kaos Kaki</span>
                    </a>
                    <!-- Cat 14 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-chalkboard text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Perlengkapan</span>
                    </a>
                    <!-- Cat 15 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-laptop text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Aksesoris IT</span>
                    </a>
                    <!-- Cat 16 -->
                    <a href="#" class="flex flex-col items-center justify-center p-4 border-r border-b border-gray-100 bg-white hover:shadow-lg transition relative hover:-translate-y-0.5 hover:z-10 group">
                        <i class="ph-fill ph-dots-three-circle text-4xl text-gray-600 group-hover:text-primary mb-2 transition"></i>
                        <span class="text-[12px] md:text-[13px] text-gray-700 text-center leading-tight">Lainnya</span>
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
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
                
                <!-- Product 1 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/seragam/300/300" alt="Product" class="w-full h-full object-cover">
                        <!-- Top left badge -->
                        <div class="absolute top-0 left-0 bg-accent text-gray-900 text-[9px] font-bold px-1.5 py-0.5 z-10 flex flex-col items-center uppercase shadow-sm">
                            <span>Promo</span>
                            <span>Extra</span>
                        </div>
                        <!-- Top right badge -->
                        <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-1 z-10 shadow-sm rounded-bl-sm">
                            -15%
                        </div>
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            <span class="bg-primary text-white text-[9px] font-bold px-1 py-0.5 rounded-sm mr-1 align-middle">Star+</span>
                            Seragam SD Merah Putih Lengan Pendek Berkualitas
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp55.000</span>
                            <span class="text-[11px] text-gray-500">10RB+ terjual</span>
                        </div>
                    </div>
                </a>

                <!-- Product 2 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/buku/300/300" alt="Product" class="w-full h-full object-cover">
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            <span class="bg-primary text-white text-[9px] font-bold px-1 py-0.5 rounded-sm mr-1 align-middle">Star</span>
                            Buku Tulis Sinar Dunia 38 Lembar (Pack isi 10)
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp28.500</span>
                            <span class="text-[11px] text-gray-500">5,4RB terjual</span>
                        </div>
                    </div>
                </a>

                <!-- Product 3 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/sepatu/300/300" alt="Product" class="w-full h-full object-cover">
                        <!-- Top left badge -->
                        <div class="absolute top-0 left-0 bg-accent text-gray-900 text-[9px] font-bold px-1.5 py-0.5 z-10 flex flex-col items-center uppercase shadow-sm">
                            <span>Promo</span>
                            <span>Extra</span>
                        </div>
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            Sepatu Sekolah Hitam Polos Anti Slip PX Style
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp120.000</span>
                            <span class="text-[11px] text-gray-500">2RB+ terjual</span>
                        </div>
                    </div>
                </a>

                <!-- Product 4 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/tas/300/300" alt="Product" class="w-full h-full object-cover">
                        <!-- Top right badge -->
                        <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-1 z-10 shadow-sm rounded-bl-sm">
                            -30%
                        </div>
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            <span class="bg-primary text-white text-[9px] font-bold px-1 py-0.5 rounded-sm mr-1 align-middle">Star+</span>
                            Tas Ransel Sekolah Pria Wanita SMP SMA / Tas Backpack
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp85.000</span>
                            <span class="text-[11px] text-gray-500">1RB+ terjual</span>
                        </div>
                    </div>
                </a>

                <!-- Product 5 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/pensil/300/300" alt="Product" class="w-full h-full object-cover">
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            Pensil 2B Faber Castell Hitam Isi 12 pcs / 1 Lusin
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp18.500</span>
                            <span class="text-[11px] text-gray-500">20RB+ terjual</span>
                        </div>
                    </div>
                </a>

                <!-- Product 6 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/topi/300/300" alt="Product" class="w-full h-full object-cover">
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            <span class="bg-primary text-white text-[9px] font-bold px-1 py-0.5 rounded-sm mr-1 align-middle">Star</span>
                            Topi Pramuka Penggalang SD SMP SMA Logo Bordir
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp12.000</span>
                            <span class="text-[11px] text-gray-500">800 terjual</span>
                        </div>
                    </div>
                </a>

                <!-- Product 7 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/smp/300/300" alt="Product" class="w-full h-full object-cover">
                        <!-- Top right badge -->
                        <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-1 z-10 shadow-sm rounded-bl-sm">
                            -10%
                        </div>
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            Seragam SMP Putih Biru Setelan Lengkap Pria/Wanita
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp110.000</span>
                            <span class="text-[11px] text-gray-500">1,5RB terjual</span>
                        </div>
                    </div>
                </a>

                <!-- Product 8 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/penggaris/300/300" alt="Product" class="w-full h-full object-cover">
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            <span class="bg-primary text-white text-[9px] font-bold px-1 py-0.5 rounded-sm mr-1 align-middle">Star+</span>
                            Penggaris Besi 30cm / Mistar Baja Stainless Steel
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp5.000</span>
                            <span class="text-[11px] text-gray-500">10RB+ terjual</span>
                        </div>
                    </div>
                </a>

                <!-- Product 9 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/bukugambar/300/300" alt="Product" class="w-full h-full object-cover">
                        <!-- Top left badge -->
                        <div class="absolute top-0 left-0 bg-accent text-gray-900 text-[9px] font-bold px-1.5 py-0.5 z-10 flex flex-col items-center uppercase shadow-sm">
                            <span>Promo</span>
                            <span>Extra</span>
                        </div>
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            Buku Gambar A3 Kiky Kertas Tebal Tidak Mudah Tembus
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp8.500</span>
                            <span class="text-[11px] text-gray-500">3,2RB terjual</span>
                        </div>
                    </div>
                </a>

                <!-- Product 10 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/kaoskaki/300/300" alt="Product" class="w-full h-full object-cover">
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            Kaos Kaki Putih Telapak Hitam SD SMP SMA Anti Kotor
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp10.000</span>
                            <span class="text-[11px] text-gray-500">5RB+ terjual</span>
                        </div>
                    </div>
                </a>
                
                <!-- Product 11 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/ikatpinggang/300/300" alt="Product" class="w-full h-full object-cover">
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            <span class="bg-primary text-white text-[9px] font-bold px-1 py-0.5 rounded-sm mr-1 align-middle">Star</span>
                            Ikat Pinggang Sabuk Sekolah Hitam Logo OSIS Standar
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp15.000</span>
                            <span class="text-[11px] text-gray-500">4,1RB terjual</span>
                        </div>
                    </div>
                </a>

                <!-- Product 12 -->
                <a href="#" class="bg-white rounded-sm border border-gray-200 hover:border-primary hover:shadow-md transition flex flex-col group relative overflow-hidden">
                    <div class="w-full aspect-square bg-gray-100 relative flex items-center justify-center text-gray-300">
                        <img src="https://picsum.photos/seed/pena/300/300" alt="Product" class="w-full h-full object-cover">
                        <!-- Top right badge -->
                        <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-1.5 py-1 z-10 shadow-sm rounded-bl-sm">
                            -25%
                        </div>
                    </div>
                    <div class="p-2.5 flex flex-col flex-1">
                        <h3 class="text-[13px] text-gray-800 line-clamp-2 leading-tight min-h-[38px] group-hover:text-primary transition">
                            <span class="bg-primary text-white text-[9px] font-bold px-1 py-0.5 rounded-sm mr-1 align-middle">Star+</span>
                            Pena Ballpoint Hitam Standard AE-7 Isi 12 Pcs
                        </h3>
                        <div class="mt-2 flex items-center justify-between mt-auto">
                            <span class="text-primary font-bold text-sm md:text-base">Rp14.500</span>
                            <span class="text-[11px] text-gray-500">15RB+ terjual</span>
                        </div>
                    </div>
                </a>

            </div>
            
            <div class="flex justify-center mt-8">
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

    </main>

    <!-- Footer E-Commerce -->
    <footer class="bg-[#f5f5f5] border-t-4 border-primary pt-12 pb-8 mt-auto text-gray-600 text-[13px]">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-10">
                
                <!-- Layanan Pelanggan -->
                <div class="lg:col-span-1">
                    <h4 class="font-bold text-gray-800 mb-4 uppercase text-xs tracking-wider">Layanan Pelanggan</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-primary transition">Bantuan</a></li>
                        <li><a href="#" class="hover:text-primary transition">Metode Pembayaran</a></li>
                        <li><a href="#" class="hover:text-primary transition">Lacak Pesanan Pembeli</a></li>
                        <li><a href="#" class="hover:text-primary transition">Gratis Ongkir</a></li>
                        <li><a href="#" class="hover:text-primary transition">Pengembalian Barang</a></li>
                        <li><a href="#" class="hover:text-primary transition">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Jelajahi -->
                <div class="lg:col-span-1">
                    <h4 class="font-bold text-gray-800 mb-4 uppercase text-xs tracking-wider">Jelajahi E-Sekolah</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="hover:text-primary transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-primary transition">Karir</a></li>
                        <li><a href="#" class="hover:text-primary transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-primary transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-primary transition">Blog</a></li>
                    </ul>
                </div>

                <!-- Pembayaran & Pengiriman -->
                <div class="lg:col-span-2">
                    <h4 class="font-bold text-gray-800 mb-4 uppercase text-xs tracking-wider">Pembayaran</h4>
                    <div class="flex flex-wrap gap-2 mb-8">
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-blue-800 hover:shadow-md transition">BCA</div>
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-blue-600 hover:shadow-md transition">MANDIRI</div>
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-orange-500 hover:shadow-md transition">BNI</div>
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-blue-900 hover:shadow-md transition">BRI</div>
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-green-500 hover:shadow-md transition">GOPAY</div>
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-purple-600 hover:shadow-md transition">OVO</div>
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-blue-400 hover:shadow-md transition">DANA</div>
                    </div>

                    <h4 class="font-bold text-gray-800 mb-4 uppercase text-xs tracking-wider">Pengiriman</h4>
                    <div class="flex flex-wrap gap-2">
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-red-600 hover:shadow-md transition">JNE</div>
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-red-500 hover:shadow-md transition">J&T</div>
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-blue-500 hover:shadow-md transition">TIKI</div>
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-red-700 hover:shadow-md transition">SICEPAT</div>
                        <div class="w-14 h-8 bg-white border border-gray-200 rounded shadow-sm flex items-center justify-center text-[10px] font-bold text-green-600 hover:shadow-md transition">GOSEND</div>
                    </div>
                </div>

                <!-- Ikuti Kami & Download App -->
                <div class="lg:col-span-1">
                    <h4 class="font-bold text-gray-800 mb-4 uppercase text-xs tracking-wider">Ikuti Kami</h4>
                    <ul class="space-y-4 mb-8">
                        <li><a href="#" class="flex items-center gap-3 hover:text-primary transition"><i class="ph-fill ph-facebook-logo text-xl text-blue-600"></i> Facebook</a></li>
                        <li><a href="#" class="flex items-center gap-3 hover:text-primary transition"><i class="ph-fill ph-instagram-logo text-xl text-pink-600"></i> Instagram</a></li>
                        <li><a href="#" class="flex items-center gap-3 hover:text-primary transition"><i class="ph-fill ph-twitter-logo text-xl text-blue-400"></i> Twitter</a></li>
                    </ul>

                    <h4 class="font-bold text-gray-800 mb-4 uppercase text-xs tracking-wider">Download App E-Sekolah</h4>
                    <div class="flex flex-col gap-2">
                        <a href="#" class="w-32 h-10 bg-gray-800 text-white rounded flex items-center justify-center gap-2 hover:bg-gray-700 transition">
                            <i class="ph-fill ph-google-play-logo text-lg"></i>
                            <div class="flex flex-col items-start leading-none">
                                <span class="text-[8px]">GET IT ON</span>
                                <span class="text-[11px] font-bold">Google Play</span>
                            </div>
                        </a>
                        <a href="#" class="w-32 h-10 bg-gray-800 text-white rounded flex items-center justify-center gap-2 hover:bg-gray-700 transition">
                            <i class="ph-fill ph-apple-logo text-lg"></i>
                            <div class="flex flex-col items-start leading-none">
                                <span class="text-[8px]">Download on the</span>
                                <span class="text-[11px] font-bold">App Store</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="border-t border-gray-300 pt-6 flex flex-col md:flex-row items-center justify-between text-xs text-gray-500">
                <p>&copy; 2026 E-Commerce Sekolah. Hak Cipta Dilindungi.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <span>Negara: Indonesia</span>
                    <span>Bahasa: Indonesia</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>