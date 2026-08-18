    <!-- Top Header -->
    <header class="bg-white shadow-sm relative z-50">
        
        <!-- Desktop Ribbon -->
        <div class="absolute top-0 left-0 w-full h-36 z-0 pointer-events-none overflow-hidden hidden md:block">
            <svg class="w-full h-full opacity-90" preserveAspectRatio="none" viewBox="0 0 1000 144">
                <!-- Top Line (Blue) -->
                <path d="M -10 112 L 200 112 L 260 30 L 1010 30" fill="none" stroke="#0a84d4" stroke-width="4" stroke-linejoin="round" />
                <!-- Bottom Line (Yellow) -->
                <path d="M -10 120 L 200 120 L 260 38 L 1010 38" fill="none" stroke="#ffb900" stroke-width="4" stroke-linejoin="round" />
            </svg>
        </div>

        <!-- Mobile Ribbon (Garis Lurus di bawah) -->
        <div class="absolute bottom-0 left-0 w-full flex flex-col z-0 pointer-events-none block md:hidden">
            <div class="w-full h-[3px] bg-[#0a84d4]"></div>
            <div class="w-full h-[3px] bg-[#ffb900]"></div>
        </div>

        <div class="container mx-auto px-4 py-3 md:py-0 md:h-36 relative z-30 flex flex-col md:flex-row md:items-center gap-4 md:gap-0">
            <!-- Left Logo Area & Mobile Controls -->
            <div class="w-full md:w-[250px] shrink-0 h-auto md:h-full flex items-center justify-between md:justify-start md:pr-4 relative z-[80] md:pb-4 md:-ml-8 lg:-ml-12">
                <a href="{{ url('/') }}" class="flex items-center text-black w-32 md:w-full">
                    <img src="{{ asset('images/Logo_VocaMarket.png') }}" alt="VocaMarket Logo" class="w-full h-auto md:max-h-24 object-contain">
                </a>
                
                <!-- Mobile Only Icons -->
                <div class="flex items-center gap-3 md:hidden">
                    <!-- Mobile Search Toggle -->
                    <button class="search-modal-toggle p-1.5 text-gray-700 hover:text-primary transition flex items-center">
                        <i class="ph-bold ph-magnifying-glass text-2xl"></i>
                    </button>
                    
                    @php
                        $cartCount = Auth::check() ? Auth::user()->cart()->where('is_read', false)->count() : 0;
                    @endphp
                    <a href="{{ url('/cart') }}" class="relative p-1.5 text-gray-700 hover:text-primary transition flex items-center">
                        <i class="ph-bold ph-shopping-cart text-2xl"></i>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-white">{{ $cartCount }}</span>
                        @endif
                    </a>
                    
                    @guest
                        <a href="{{ route('login') }}" class="p-1.5 text-gray-700 hover:text-primary transition">
                            <i class="ph-bold ph-user text-2xl"></i>
                        </a>
                    @else
                        <div class="relative group cursor-pointer" id="mobile-user-dropdown-container">
                            <div class="flex items-center rounded-full hover:opacity-80 transition" id="mobile-user-dropdown-toggle">
                                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm overflow-hidden shrink-0 shadow-sm">
                                    @if(Auth::user()->profile && (Auth::user()->profile->photo || Auth::user()->profile->foto))
                                        <img src="{{ asset('storage/' . (Auth::user()->profile->photo ?? Auth::user()->profile->foto)) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Mobile Dropdown -->
                            <div id="mobile-user-dropdown-menu" class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden transition-all z-[80]">
                                <a href="{{ url('/user') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary rounded-t-lg transition"><i class="ph-bold ph-user mr-2"></i>Profil Saya</a>
                                
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition"><i class="ph-bold ph-squares-four mr-2"></i>Dashboard Admin</a>
                                @elseif(Auth::user()->isSeller())
                                    <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition"><i class="ph-bold ph-storefront mr-2"></i>Dashboard Penjual</a>
                                @endif
                                
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition"><i class="ph-bold ph-receipt mr-2"></i>Pesanan Saya</a>
                                
                                <div class="border-t border-gray-100 my-1"></div>
                                
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition rounded-b-lg">
                                        <i class="ph-bold ph-sign-out mr-2"></i>Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
            
            <!-- Right Area (Search & Navbars) -->
            <div id="mobile-menu" class="hidden md:flex flex-1 flex-col justify-between w-full md:w-auto mt-2 md:mt-0 gap-3 md:gap-0">

                <!-- Top Bar Content (Address) -->
                <div class="hidden md:flex h-12 items-start pt-2 justify-end pr-4 text-[10px] md:text-[11px] text-gray-600 font-medium relative z-40">
                    <a href="https://www.google.com/maps/place/SMK+Bakti+Nusantara+666/@-6.9399542,107.7380657,17.15z/data=!4m6!3m5!1s0x2e68c3407e51c4a3:0x3e434e3f31a8c4b3!8m2!3d-6.941331!4d107.7399631!16s%2Fg%2F1hm4xqyvs?hl=id-ID&entry=ttu&g_ep=EgoyMDI2MDgxMi4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="flex items-start hover:text-primary transition group">
                        <i class="ph-fill ph-map-pin mr-1 text-red-500 text-sm group-hover:scale-110 transition-transform mt-0.5"></i>
                        JL. PERCOBAAN KM. 17 NO. 65 CILEUNYI, Kec. Cileunyi, Kab. Bandung, Prov. Jawa Barat
                    </a>
                </div>

                <!-- Bottom White Navbar Content (Search & Auth) -->
                <!-- Pushed to the right (justify-end) and added padding (pl-24) to avoid the slanted line -->
                <div class="flex flex-col md:flex-row md:h-24 items-center justify-end md:pl-12 lg:pl-24 gap-4 md:gap-6 md:pr-4 w-full">
                    
                    <!-- Search Bar Wrapper (Desktop Only) -->
                    <form action="{{ route('search') }}" method="GET" class="hidden md:block w-full relative" id="desktop-search-container">
                        <!-- Search Bar -->
                        <div class="flex items-center h-12 rounded-lg overflow-hidden shadow-sm border border-gray-200 bg-white relative z-[70]">
                            <input type="text" name="q" value="{{ request('q') }}" id="desktop-search-input" placeholder="Cari kebutuhan sekolah..." class="h-full w-full px-5 text-black outline-none text-sm" autocomplete="off">
                            <button type="submit" class="bg-accent hover:bg-accent-hover h-full px-8 text-gray-900 transition flex items-center justify-center">
                                <i class="ph ph-magnifying-glass text-xl font-bold"></i>
                            </button>
                        </div>
                        
                        <!-- Search Suggestions Dropdown (Hidden by default) -->
                        <div id="desktop-search-dropdown" class="absolute top-[calc(100%-4px)] pt-4 left-0 w-full bg-white rounded-b-lg shadow-lg border border-gray-100 hidden z-[60] pb-2">
                            <!-- All Categories Option -->
                            <a href="#" onclick="event.preventDefault(); document.getElementById('desktop-search-container').submit();" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition border-b border-gray-50 last:border-0">
                                <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                                <span>Cari "<span class="desktop-search-keyword font-bold"></span>"</span>
                            </a>
                            
                            <a href="#" onclick="event.preventDefault(); window.location.href='{{ route('kategori', 'merchandise') }}?q=' + encodeURIComponent(document.getElementById('desktop-search-input').value);" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition border-b border-gray-50 last:border-0">
                                <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                                <span>"<span class="desktop-search-keyword font-bold"></span>" di <span class="font-medium text-primary">Produk Sekolah</span></span>
                            </a>
                            <a href="#" onclick="event.preventDefault(); window.location.href='{{ route('kategori', 'dkv-animasi') }}?q=' + encodeURIComponent(document.getElementById('desktop-search-input').value);" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition border-b border-gray-50 last:border-0">
                                <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                                <span>"<span class="desktop-search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa DKV & Animasi</span></span>
                            </a>
                            <a href="#" onclick="event.preventDefault(); window.location.href='{{ route('kategori', 'pemasaran') }}?q=' + encodeURIComponent(document.getElementById('desktop-search-input').value);" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition border-b border-gray-50 last:border-0">
                                <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                                <span>"<span class="desktop-search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa Pemasaran</span></span>
                            </a>
                            <a href="#" onclick="event.preventDefault(); window.location.href='{{ route('kategori', 'pplg') }}?q=' + encodeURIComponent(document.getElementById('desktop-search-input').value);" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition border-b border-gray-50 last:border-0">
                                <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                                <span>"<span class="desktop-search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa PPLG</span></span>
                            </a>
                            <a href="#" onclick="event.preventDefault(); window.location.href='{{ route('kategori', 'akuntansi') }}?q=' + encodeURIComponent(document.getElementById('desktop-search-input').value);" class="flex items-center px-4 py-3 hover:bg-gray-50 text-gray-700 text-sm transition border-b border-gray-50 last:border-0">
                                <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                                <span>"<span class="desktop-search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa Akuntansi</span></span>
                            </a>
                        </div>
                    </form>
                    
                    <!-- Icons & Login / Register -->
                    <div class="shrink-0 hidden md:flex items-center justify-between md:justify-end gap-3 w-full md:w-auto">

                        @php
                            $cartCount = Auth::check() ? Auth::user()->cart()->where('is_read', false)->count() : 0;
                        @endphp
                        <a href="{{ url('/cart') }}" class="relative p-1.5 text-gray-700 hover:text-primary transition mr-2 flex items-center group">
                            <i class="ph-bold ph-shopping-cart text-2xl group-hover:scale-110 transition-transform"></i>
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-white">{{ $cartCount }}</span>
                            @endif
                        </a>
                        @guest
                            <div class="flex gap-2 w-full md:w-auto">
                                <a href="{{ route('login') }}" class="flex-1 md:flex-none text-center px-4 py-2 text-primary font-bold border border-primary rounded-lg hover:bg-blue-50 transition whitespace-nowrap text-sm">
                                    Masuk
                                </a>
                                <a href="{{ route('register') }}" class="flex-1 md:flex-none text-center px-4 py-2 bg-primary text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-sm whitespace-nowrap text-sm">
                                    Daftar
                                </a>
                            </div>
                        @else
                            <div class="relative w-full md:w-auto group cursor-pointer" id="user-dropdown-container">
                                <div class="flex items-center justify-between md:justify-start gap-2 px-3 py-2 md:px-2 md:py-1 rounded-lg border border-transparent hover:bg-gray-100 transition" id="user-dropdown-toggle">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm overflow-hidden shrink-0">
                                            @if(Auth::user()->profile && (Auth::user()->profile->photo || Auth::user()->profile->foto))
                                                <img src="{{ asset('storage/' . (Auth::user()->profile->photo ?? Auth::user()->profile->foto)) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">{{ explode(' ', Auth::user()->name)[0] }}</span>
                                    </div>
                                    <i class="ph-bold ph-caret-down text-gray-500 text-xs md:block"></i>
                                </div>
                                
                                <!-- Dropdown -->
                                <div id="user-dropdown-menu" class="absolute right-0 top-full mt-2 w-full md:w-48 bg-white border border-gray-200 rounded-lg shadow-lg invisible group-hover:opacity-100 group-hover:visible transition-all z-50 block opacity-100">
                                    <a href="{{ url('/user') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary rounded-t-lg transition"><i class="ph-bold ph-user mr-2"></i>Profil Saya</a>
                                    
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition"><i class="ph-bold ph-squares-four mr-2"></i>Dashboard Admin</a>
                                    @elseif(Auth::user()->isSeller())
                                        <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition"><i class="ph-bold ph-storefront mr-2"></i>Dashboard Penjual</a>
                                    @elseif(Auth::user()->role === 'siswa')
                                        <a href="{{ route('user.submissions') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition"><i class="ph-bold ph-squares-four mr-2"></i>Dashboard</a>
                                    @endif
                                    
                                    <a href="{{ route('orders.index') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-primary transition"><i class="ph-bold ph-receipt mr-2"></i>Pesanan Saya</a>
                                    
                                    <div class="border-t border-gray-100 my-1"></div>
                                    
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition rounded-b-lg">
                                            <i class="ph-bold ph-sign-out mr-2"></i>Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                    
                </div>
            </div>
        </div>
    </header>

    <!-- Fullscreen Search Modal -->
    <div id="search-modal" class="fixed inset-0 z-[100] hidden bg-gray-900/40 backdrop-blur-sm flex items-start justify-center pt-20 px-4 transition-opacity opacity-0 duration-300">
        <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300 flex flex-col" id="search-modal-content">
            <!-- Search Input -->
            <form action="{{ route('search') }}" method="GET" class="flex items-center p-3 border-b border-gray-100 relative bg-white z-20" id="modal-search-form">
                <i class="ph ph-magnifying-glass text-2xl text-gray-400 absolute left-6"></i>
                <input type="text" name="q" id="modal-search-input" placeholder="Cari kebutuhan sekolah..." class="w-full pl-14 pr-4 py-3 text-lg outline-none text-gray-800" autocomplete="off">
                <button type="submit" class="bg-accent hover:bg-accent-hover text-gray-900 px-6 py-2.5 rounded-lg font-bold transition ml-2 shrink-0">
                    Cari
                </button>
                <button type="button" id="close-search-modal" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition ml-2 shrink-0">
                    <i class="ph-bold ph-x text-xl"></i>
                </button>
            </form>
            
            <!-- Search Suggestions -->
            <div id="modal-search-dropdown" class="bg-gray-50 flex-1 overflow-y-auto hidden">
                <div class="p-2">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('modal-search-form').submit();" class="flex items-center px-4 py-3 hover:bg-white hover:shadow-sm rounded-lg text-gray-700 transition mb-1">
                        <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                        <span>Cari "<span class="modal-search-keyword font-bold"></span>"</span>
                    </a>
                    
                    <a href="#" onclick="event.preventDefault(); window.location.href='{{ route('kategori', 'merchandise') }}?q=' + encodeURIComponent(document.getElementById('modal-search-input').value);" class="flex items-center px-4 py-3 hover:bg-white hover:shadow-sm rounded-lg text-gray-700 transition mb-1">
                        <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                        <span>"<span class="modal-search-keyword font-bold"></span>" di <span class="font-medium text-primary">Produk Sekolah</span></span>
                    </a>
                    <a href="#" onclick="event.preventDefault(); window.location.href='{{ route('kategori', 'dkv-animasi') }}?q=' + encodeURIComponent(document.getElementById('modal-search-input').value);" class="flex items-center px-4 py-3 hover:bg-white hover:shadow-sm rounded-lg text-gray-700 transition mb-1">
                        <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                        <span>"<span class="modal-search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa DKV & Animasi</span></span>
                    </a>
                    <a href="#" onclick="event.preventDefault(); window.location.href='{{ route('kategori', 'pemasaran') }}?q=' + encodeURIComponent(document.getElementById('modal-search-input').value);" class="flex items-center px-4 py-3 hover:bg-white hover:shadow-sm rounded-lg text-gray-700 transition mb-1">
                        <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                        <span>"<span class="modal-search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa Pemasaran</span></span>
                    </a>
                    <a href="#" onclick="event.preventDefault(); window.location.href='{{ route('kategori', 'pplg') }}?q=' + encodeURIComponent(document.getElementById('modal-search-input').value);" class="flex items-center px-4 py-3 hover:bg-white hover:shadow-sm rounded-lg text-gray-700 transition mb-1">
                        <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                        <span>"<span class="modal-search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa PPLG</span></span>
                    </a>
                    <a href="#" onclick="event.preventDefault(); window.location.href='{{ route('kategori', 'akuntansi') }}?q=' + encodeURIComponent(document.getElementById('modal-search-input').value);" class="flex items-center px-4 py-3 hover:bg-white hover:shadow-sm rounded-lg text-gray-700 transition mb-1">
                        <i class="ph ph-magnifying-glass text-gray-400 mr-3 text-lg"></i>
                        <span>"<span class="modal-search-keyword font-bold"></span>" di <span class="font-medium text-primary">Jasa Akuntansi</span></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Search Modal Logic
            const searchToggles = document.querySelectorAll('.search-modal-toggle');
            const searchModal = document.getElementById('search-modal');
            const searchModalContent = document.getElementById('search-modal-content');
            const closeSearchModalBtn = document.getElementById('close-search-modal');
            const searchInput = document.getElementById('modal-search-input');
            const searchDropdown = document.getElementById('modal-search-dropdown');
            const searchKeywords = document.querySelectorAll('.modal-search-keyword');

            function openSearchModal() {
                searchModal.classList.remove('hidden');
                // Small delay to allow display:block to apply before animating opacity
                setTimeout(() => {
                    searchModal.classList.remove('opacity-0');
                    searchModalContent.classList.remove('scale-95');
                    searchModalContent.classList.add('scale-100');
                    searchInput.focus();
                }, 10);
            }

            function closeSearchModal() {
                searchModal.classList.add('opacity-0');
                searchModalContent.classList.remove('scale-100');
                searchModalContent.classList.add('scale-95');
                setTimeout(() => {
                    searchModal.classList.add('hidden');
                }, 300);
            }

            searchToggles.forEach(toggle => {
                toggle.addEventListener('click', openSearchModal);
            });

            if (closeSearchModalBtn) {
                closeSearchModalBtn.addEventListener('click', closeSearchModal);
            }

            // Close modal when clicking outside the content box
            if (searchModal) {
                searchModal.addEventListener('click', (e) => {
                    if (e.target === searchModal) {
                        closeSearchModal();
                    }
                });
            }

            // Search Dropdown Logic (Modal)
            if (searchInput && searchDropdown) {
                searchInput.addEventListener('input', function() {
                    if (this.value.trim().length > 0) {
                        searchDropdown.classList.remove('hidden');
                        searchKeywords.forEach(el => el.textContent = this.value);
                    } else {
                        searchDropdown.classList.add('hidden');
                    }
                });
            }

            // Desktop Search Dropdown Logic
            const desktopSearchInput = document.getElementById('desktop-search-input');
            const desktopSearchDropdown = document.getElementById('desktop-search-dropdown');
            const desktopSearchKeywords = document.querySelectorAll('.desktop-search-keyword');

            if (desktopSearchInput && desktopSearchDropdown) {
                desktopSearchInput.addEventListener('input', function() {
                    if (this.value.trim().length > 0) {
                        desktopSearchDropdown.classList.remove('hidden');
                        desktopSearchKeywords.forEach(el => el.textContent = this.value);
                    } else {
                        desktopSearchDropdown.classList.add('hidden');
                    }
                });

                document.addEventListener('click', (e) => {
                    if (!desktopSearchDropdown.contains(e.target) && e.target !== desktopSearchInput) {
                        desktopSearchDropdown.classList.add('hidden');
                    }
                });
                
                desktopSearchInput.addEventListener('focus', function() {
                    if (this.value.trim().length > 0) {
                        desktopSearchDropdown.classList.remove('hidden');
                    }
                });
            }

            // Mobile Menu Logic (Removed old search bar toggle)
            
            const mobileUserDropdownToggle = document.getElementById('mobile-user-dropdown-toggle');
            const mobileUserDropdownMenu = document.getElementById('mobile-user-dropdown-menu');

            if (mobileUserDropdownToggle && mobileUserDropdownMenu) {
                mobileUserDropdownToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    mobileUserDropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!mobileUserDropdownMenu.contains(e.target) && !mobileUserDropdownToggle.contains(e.target)) {
                        mobileUserDropdownMenu.classList.add('hidden');
                    }
                });
            }

            const userDropdownToggle = document.getElementById('user-dropdown-toggle');
            const userDropdownMenu = document.getElementById('user-dropdown-menu');

            if (userDropdownToggle && userDropdownMenu) {
                userDropdownToggle.addEventListener('click', (e) => {
                    // Only toggle on mobile manually, CSS hover handles desktop
                    if (window.innerWidth < 768) {
                        e.stopPropagation();
                        userDropdownMenu.classList.toggle('hidden');
                    }
                });

                document.addEventListener('click', (e) => {
                    if (window.innerWidth < 768 && !userDropdownMenu.contains(e.target) && !userDropdownToggle.contains(e.target)) {
                        userDropdownMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>

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
