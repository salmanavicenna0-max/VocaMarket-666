<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Commerce Sekolah')</title>
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
        @yield('styles')
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
                <path d="M -10 112 L 260 112 L 320 55 L 1010 55" fill="none" stroke="#007DCC" stroke-width="4" stroke-linejoin="round" />
                <!-- Bottom Line (Yellow) -->
                <path d="M -10 120 L 260 120 L 320 63 L 1010 63" fill="none" stroke="#FFB900" stroke-width="4" stroke-linejoin="round" />
            </svg>
        </div>

        <div class="container mx-auto px-4 h-36 relative z-30 flex items-center">
            <!-- Left Logo Area -->
            <!-- Aligned to top so it sits above the y=110 ribbon on the left -->
            <div class="w-auto lg:w-1/4 h-full flex items-center justify-start pr-4 shrink-0">
                <a href="{{ url('/') }}" class="flex items-center text-black">
                    <img src="{{ asset('images/Logo_VocaMarket.png') }}" alt="VocaMarket Logo" class="h-12 md:h-16 lg:h-18 w-auto object-contain">
                </a>
            </div>
            
            <!-- Right Area (Search & Navbars) -->
            <div class="flex-1 h-full flex flex-col justify-between">

                <!-- Top Bar Content (Empty to maintain vertical spacing) -->
                <div class="h-12"></div>

                <!-- Bottom White Navbar Content (Search & Auth) -->
                <!-- Pushed to the right (justify-end) and added padding (pl-24) to avoid the slanted line -->
                <div class="h-24 flex items-center justify-end pl-12 lg:pl-24 gap-6 pr-4">
                    
                    <!-- Search Bar Wrapper -->
                    <div class="w-full max-w-2xl relative" id="search-container">
                        <!-- Search Bar -->
                        <div class="flex items-center h-12 rounded-lg overflow-hidden shadow-sm border border-gray-200 bg-white relative z-[70]">
                            <input type="text" id="search-input" placeholder="Cari kebutuhan sekolah..." class="h-full w-full px-5 text-black outline-none text-sm" autocomplete="off">
                            <button class="bg-accent hover:bg-accent-hover h-full px-8 text-gray-900 transition flex items-center justify-center">
                                <i class="ph ph-magnifying-glass text-xl font-bold"></i>
                            </button>
                        </div>
                        
                        <!-- Search Suggestions Dropdown (Hidden by default) -->
                        <div id="search-dropdown" class="absolute top-[calc(100%-4px)] pt-4 left-0 w-full bg-white rounded-b-lg shadow-lg border border-gray-100 hidden z-[60] pb-2">
                            <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition border-b border-gray-50 last:border-0">
                                <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                                <span>"<span class="search-keyword font-bold"></span>" di <span class="font-medium text-primary">Produk Sekolah</span></span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition border-b border-gray-50 last:border-0">
                                <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                                <span>"<span class="search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa DKV & Animasi</span></span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition border-b border-gray-50 last:border-0">
                                <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                                <span>"<span class="search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa Pemasaran</span></span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition border-b border-gray-50 last:border-0">
                                <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                                <span>"<span class="search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa PPLG</span></span>
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition border-b border-gray-50 last:border-0">
                                <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                                <span>"<span class="search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa Akuntansi</span></span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Login / Register -->
                    <div class="shrink-0">
                        <a href="#" class="flex items-center gap-2 hover:text-primary transition text-gray-800 font-bold whitespace-nowrap">
                            <i class="ph-fill ph-user text-xl"></i>
                            Masuk / Daftar
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow relative bg-gray-50 flex flex-col">
        
        <!-- Secondary Navbar (Categories) -->
        <div class="bg-primary-dark text-white text-sm relative z-20">
            <div class="container mx-auto px-4 py-2 flex items-center gap-2 overflow-x-auto whitespace-nowrap hide-scrollbar">
                <a href="#" class="flex items-center gap-1 hover:text-accent font-bold shrink-0">
                    <i class="ph ph-list text-lg"></i> Kategori
                </a>
                <span class="text-white/30 mx-2 shrink-0">|</span>
                <a href="#" class="hover:text-accent shrink-0">Produk Sekolah</a>
                <a href="#" class="hover:text-accent ml-4 shrink-0">DKV & Animasi</a>
                <a href="#" class="hover:text-accent ml-4 shrink-0">Pemasaran</a>
                <a href="#" class="hover:text-accent ml-4 shrink-0">PPLG</a>
                <a href="#" class="hover:text-accent ml-4 shrink-0">Akuntansi</a>
            </div>
        </div>

        @yield('content')
        
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search Auto-suggest Logic
        const searchInput = document.getElementById('search-input');
        const searchDropdown = document.getElementById('search-dropdown');
        const keywordSpans = document.querySelectorAll('.search-keyword');
        const searchContainer = document.getElementById('search-container');
        
        if (searchInput && searchDropdown) {
            function updateDropdown() {
                const val = searchInput.value.trim();
                if (val.length > 0) {
                    keywordSpans.forEach(span => {
                        span.textContent = val;
                    });
                    searchDropdown.classList.remove('hidden');
                } else {
                    searchDropdown.classList.add('hidden');
                }
            }

            searchInput.addEventListener('input', updateDropdown);
            searchInput.addEventListener('focus', updateDropdown);

            document.addEventListener('click', function(e) {
                if (!searchContainer.contains(e.target)) {
                    searchDropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
@yield('scripts')
</body>
</html>
