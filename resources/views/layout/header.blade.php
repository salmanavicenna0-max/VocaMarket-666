    <!-- Top Header -->
    <header class="bg-white shadow-sm relative z-50">
        
        <!-- Decorative Ribbon (Two parallel lines) -->
        <!-- Placed in an exact 144px container (h-36) so coordinates map perfectly -->
        <div class="absolute top-0 left-0 w-full h-36 z-0 pointer-events-none overflow-hidden">
            <svg class="w-full h-full opacity-90" preserveAspectRatio="none" viewBox="0 0 1000 144">
                <!-- Top Line (Blue) -->
                <!-- Slanting earlier to the left (200 to 260) and going higher (y=30) to fill the empty top space -->
                <path d="M -10 112 L 200 112 L 260 30 L 1010 30" fill="none" stroke="#0a84d4" stroke-width="4" stroke-linejoin="round" />
                <!-- Bottom Line (Yellow) -->
                <path d="M -10 120 L 200 120 L 260 38 L 1010 38" fill="none" stroke="#ffb900" stroke-width="4" stroke-linejoin="round" />
            </svg>
        </div>

        <div class="container mx-auto px-4 h-36 relative z-30 flex items-center">
            <!-- Left Logo Area -->
            <!-- Aligned to top so it sits above the y=110 ribbon on the left -->
            <div class="w-[250px] shrink-0 h-full flex items-center justify-start pr-4 relative z-40 pb-4">
                <a href="{{ url('/') }}" class="flex items-center text-black w-full">
                    <img src="{{ asset('images/Logo_VocaMarket.png') }}" alt="VocaMarket Logo" class="w-full h-auto max-h-24 object-contain">
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
                    
                    <!-- Icons & Login / Register -->
                    <div class="shrink-0 flex items-center gap-3">
                        <a href="{{ url('/cart') }}" class="relative p-1.5 text-gray-700 hover:text-primary transition mr-2 flex items-center group">
                            <i class="ph-bold ph-shopping-cart text-2xl group-hover:scale-110 transition-transform"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-white">2</span>
                        </a>
                        <a href="{{ route('login') }}" class="px-4 py-2 text-primary font-bold border border-primary rounded-lg hover:bg-blue-50 transition whitespace-nowrap text-sm">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-primary text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-sm whitespace-nowrap text-sm">
                            Daftar
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow relative bg-gray-50 flex flex-col">
        
        <!-- Secondary Navbar (Popular Searches) -->
        <div class="bg-primary-dark text-white text-xs md:text-sm relative z-20">
            <div class="container mx-auto px-4 py-2 flex items-center gap-2 overflow-x-auto whitespace-nowrap hide-scrollbar">
                <span class="flex items-center gap-1 font-bold shrink-0 text-white/80">
                    <i class="ph-bold ph-trend-up text-lg"></i> Pencarian Populer:
                </span>
                <a href="{{ route('kategori', 'ganci') }}" class="hover:text-accent shrink-0 ml-2">Ganci</a>
                <a href="{{ route('kategori', 'kaos-sekolah') }}" class="hover:text-accent ml-4 shrink-0">Kaos Sekolah</a>
                <a href="{{ route('kategori', 'desain-grafis') }}" class="hover:text-accent ml-4 shrink-0">Desain Grafis</a>
                <a href="{{ route('kategori', 'website') }}" class="hover:text-accent ml-4 shrink-0">Pembuatan Website</a>
                <a href="{{ route('kategori', 'animasi') }}" class="hover:text-accent ml-4 shrink-0">Jasa Animasi</a>
            </div>
        </div>
