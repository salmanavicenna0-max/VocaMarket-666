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
                        primary: '#0a84d4', 
                        accent: '#ffb900',  
                        'primary-dark': '#0a84d4',
                        'accent-hover': '#ffb900',
                        blue: {
                            50: '#eef8ff',
                            100: '#d9efff',
                            200: '#bce4ff',
                            300: '#8ed4ff',
                            400: '#59bcff',
                            500: '#32a2ff',
                            600: '#0a84d4', // The exact requested color
                            700: '#0267ad',
                            800: '#06578e',
                            900: '#0b4875',
                        },
                        yellow: {
                            50: '#fffdf2',
                            100: '#fff8db',
                            200: '#fff0b0',
                            300: '#ffe580',
                            400: '#ffd64d',
                            500: '#ffb900',
                            600: '#d99c00',
                            700: '#ad7c00',
                            800: '#805c00',
                            900: '#523a00',
                        }
                    },
                    borderRadius: {
                        'md': '0.25rem',  // 4px
                        'lg': '0.375rem', // 6px
                        'xl': '0.375rem', // 6px (less blunt than default 12px)
                        '2xl': '0.5rem',  // 8px (less blunt than default 16px)
                        '3xl': '0.5rem',  // 8px (less blunt than default 24px)
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
                <path d="M -10 112 L 260 112 L 320 55 L 1010 55" fill="none" stroke="#0a84d4" stroke-width="4" stroke-linejoin="round" />
                <!-- Bottom Line (Yellow) -->
                <path d="M -10 120 L 260 120 L 320 63 L 1010 63" fill="none" stroke="#ffb900" stroke-width="4" stroke-linejoin="round" />
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
                        @guest
                            <a href="{{ route('login') }}" class="px-4 py-2 text-primary font-bold border border-primary rounded-lg hover:bg-blue-50 transition whitespace-nowrap text-sm">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-primary text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-sm whitespace-nowrap text-sm">
                                Daftar
                            </a>
                        @else
                            <div class="relative group cursor-pointer ml-2">
                                <a href="{{ url('/user') }}" class="flex items-center gap-2 px-2 py-1 rounded-lg hover:bg-gray-50 transition border border-transparent hover:border-gray-200">
                                    <div class="w-9 h-9 rounded-full bg-blue-100 text-primary font-bold flex items-center justify-center text-xs shadow-sm">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                    <div class="hidden md:flex flex-col items-start leading-none justify-center h-full pt-1">
                                        <span class="text-xs font-bold text-gray-800">{{ Auth::user()->name }}</span>
                                        <span class="text-[10px] text-gray-500 capitalize">{{ Auth::user()->role }}</span>
                                    </div>
                                </a>
                                <!-- Dropdown -->
                                <div class="absolute right-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-[80]">
                                    @if(Auth::user()->role === 'admin')
                                    <a href="{{ url('/admin/dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition border-b border-gray-50 rounded-t-lg">
                                        <i class="ph-bold ph-squares-four mr-2"></i> Dashboard Admin
                                    </a>
                                    @else
                                    <a href="{{ url('/user') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition border-b border-gray-50 rounded-t-lg">
                                        <i class="ph-bold ph-user mr-2"></i> Profil Saya
                                    </a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition rounded-b-lg">
                                            <i class="ph-bold ph-sign-out mr-2"></i> Keluar
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



    <!-- Floating Chat Trigger (Stuck to Right Edge) -->
    <div onclick="openMiniChat(event)" class="fixed top-1/2 right-0 -translate-y-1/2 bg-primary text-white p-2 rounded-l-xl shadow-lg cursor-pointer hover:bg-primary-dark transition z-[90] flex flex-col items-center gap-1 group">
        <i class="ph-bold ph-chat-circle-dots text-2xl group-hover:scale-110 transition-transform"></i>
        <span class="text-[10px] font-bold" style="writing-mode: vertical-rl; text-orientation: mixed;">CHAT</span>
    </div>

    <!-- Floating Mini Chat Widget (Shopee Style: Bottom Right, Two Columns) -->
    <div id="mini-chat-widget" class="fixed bottom-0 right-6 z-[100] w-[600px] max-w-[90vw] bg-white rounded-t-lg shadow-[0_-4px_20px_rgba(0,0,0,0.2)] border border-gray-200 flex-col overflow-hidden hidden transition-all duration-300 transform translate-y-0" style="display: none;">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200 p-2 flex justify-between items-center shadow-sm z-10">
            <div class="flex items-center gap-2 text-primary px-2">
                <i class="ph-fill ph-chat-circle-dots text-xl"></i>
                <span class="font-bold text-sm">Chat</span>
            </div>
            <div class="flex items-center gap-1 text-gray-500">
                <button class="hover:bg-gray-100 p-1.5 rounded transition" onclick="closeMiniChat(event)"><i class="ph-bold ph-arrows-in-simple"></i></button>
                <button class="hover:bg-gray-100 p-1.5 rounded transition" onclick="closeMiniChat(event)"><i class="ph-bold ph-caret-down"></i></button>
            </div>
        </div>
        
        <!-- Chat Body (Two Columns, Always visible when widget is open) -->
        <div class="h-[450px] flex bg-white relative w-full" id="mini-chat-body">
            
            <!-- Left Column: Chat List -->
            <div class="w-2/5 border-r border-gray-200 flex flex-col bg-white">
                <!-- Search -->
                <div class="p-2 border-b border-gray-100 flex items-center gap-2">
                    <div class="relative flex-1">
                        <i class="ph-bold ph-magnifying-glass absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" placeholder="Cari nama" class="w-full bg-gray-50 text-xs rounded border border-gray-200 pl-7 pr-2 py-1.5 outline-none focus:border-primary transition">
                    </div>
                    <button class="text-xs text-gray-500 flex items-center gap-1 hover:text-gray-700">Semua <i class="ph-bold ph-caret-down"></i></button>
                </div>
                <!-- List -->
                <div class="flex-1 overflow-y-auto hide-scrollbar">
                    
                    <!-- Chat Item 1 (Active) -->
                    <div class="flex items-start gap-2 p-3 bg-blue-50/50 cursor-pointer border-l-2 border-primary">
                        <div class="relative shrink-0 mt-0.5">
                            <img src="https://ui-avatars.com/api/?name=Siswa+Esemka" class="w-10 h-10 rounded-full border border-gray-200 object-cover">
                            <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-0.5">
                                <h4 class="font-bold text-gray-900 text-xs truncate">Toko Siswa Esemka</h4>
                                <span class="text-[10px] text-gray-400">10:42</span>
                            </div>
                            <p class="text-xs text-gray-800 truncate font-medium">Baik kak, pesanannya ak...</p>
                        </div>
                    </div>

                    <!-- Chat Item 2 -->
                    <div class="flex items-start gap-2 p-3 hover:bg-gray-50 cursor-pointer transition border-l-2 border-transparent">
                        <div class="relative shrink-0 mt-0.5">
                            <img src="https://picsum.photos/seed/toko-alat-tulis-kita/100/100" class="w-10 h-10 rounded-full border border-gray-200 object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-0.5">
                                <h4 class="font-bold text-gray-900 text-xs truncate">Toko Alat Tulis Kita</h4>
                                <span class="text-[10px] text-gray-400">Kemarin</span>
                            </div>
                            <p class="text-xs text-gray-500 truncate">Sama-sama kak, terima...</p>
                        </div>
                    </div>
                    
                    <!-- Chat Item 3 -->
                    <div class="flex items-start gap-2 p-3 hover:bg-gray-50 cursor-pointer transition border-l-2 border-transparent">
                        <div class="relative shrink-0 mt-0.5">
                            <img src="https://picsum.photos/seed/desain/100/100" class="w-10 h-10 rounded-full border border-gray-200 object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-0.5">
                                <h4 class="font-bold text-gray-900 text-xs truncate">Studio Animasi 666</h4>
                                <span class="text-[10px] text-gray-400">26/07</span>
                            </div>
                            <p class="text-xs text-gray-500 truncate">Revisi sudah dikirim ke...</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Column: Active Chat Area -->
            <div class="w-3/5 flex flex-col bg-gray-50/50">
                
                <!-- Chat Header -->
                <div class="p-2 border-b border-gray-200 flex items-center justify-between bg-white shrink-0">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-gray-900 text-sm">Toko Siswa Esemka</span>
                    </div>
                    <button class="text-gray-400 hover:text-primary transition"><i class="ph-bold ph-dots-three text-xl"></i></button>
                </div>
                
                <!-- Pinned Product Info -->
                <div class="bg-white p-2 border-b border-gray-100 flex items-center justify-between shrink-0 shadow-sm z-10">
                    <div class="flex items-center gap-2">
                        <img src="https://picsum.photos/seed/seragam/50/50" class="w-10 h-10 rounded object-cover border border-gray-200">
                        <div class="flex flex-col">
                            <span class="text-xs font-medium text-gray-800 line-clamp-1">Seragam SD Merah Putih</span>
                            <span class="text-xs font-bold text-primary">Rp55.000</span>
                        </div>
                    </div>
                    <button class="px-3 py-1 bg-white border border-primary text-primary text-xs rounded hover:bg-blue-50 transition">Kirim Link</button>
                </div>

                <!-- Messages -->
                <div class="flex-1 p-3 overflow-y-auto flex flex-col gap-3">
                    <div class="text-center my-1">
                        <span class="text-[10px] bg-gray-200/70 text-gray-500 px-2 py-0.5 rounded">Hari Ini</span>
                    </div>
                    
                    <!-- Bubble Self -->
                    <div class="flex flex-col items-end gap-1">
                        <div class="bg-blue-100 text-gray-800 rounded-lg rounded-tr-sm px-3 py-2 text-xs max-w-[80%] border border-blue-200/50">
                            Halo min, apakah seragam ini ready stock ukuran L?
                        </div>
                        <span class="text-[9px] text-gray-400">10:40</span>
                    </div>
                    
                    <!-- Bubble Other -->
                    <div class="flex flex-col items-start gap-1">
                        <div class="flex gap-2">
                            <img src="https://ui-avatars.com/api/?name=Siswa+Esemka" class="w-6 h-6 rounded-full shrink-0">
                            <div class="bg-white text-gray-800 border border-gray-200 rounded-lg rounded-tl-sm px-3 py-2 text-xs max-w-[80%]">
                                Halo kak! Ready stok banyak, silakan langsung diorder ya 😊
                            </div>
                        </div>
                        <span class="text-[9px] text-gray-400 ml-8">10:42</span>
                    </div>
                </div>

                <!-- Chat Input Box -->
                <div class="p-2 bg-white border-t border-gray-200 flex flex-col gap-2 shrink-0">
                    <div class="flex items-center gap-3 px-1 text-gray-400">
                        <button class="hover:text-primary transition"><i class="ph-bold ph-image text-lg"></i></button>
                        <button class="hover:text-primary transition"><i class="ph-bold ph-smiley text-lg"></i></button>
                        <button class="hover:text-primary transition"><i class="ph-bold ph-plus-circle text-lg"></i></button>
                    </div>
                    <textarea rows="2" placeholder="Tulis pesan..." class="w-full bg-transparent border-none outline-none resize-none text-xs text-gray-800 placeholder-gray-400 px-1"></textarea>
                    <div class="flex justify-end">
                        <button class="px-5 py-1.5 bg-gray-100 text-gray-400 font-medium text-xs rounded hover:bg-primary hover:text-white transition">Kirim</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

<script>
    function openMiniChat(event) {
        if(event) event.preventDefault();
        const widget = document.getElementById('mini-chat-widget');
        widget.style.display = 'flex';
    }

    function closeMiniChat(event) {
        if(event) event.stopPropagation();
        const widget = document.getElementById('mini-chat-widget');
        widget.style.display = 'none';
    }

    function toggleMiniChatBody(event) {
        // Now toggles the whole widget display instead of just the body
        if(event) event.stopPropagation();
        const widget = document.getElementById('mini-chat-widget');
        if (widget.style.display === 'none') {
            openMiniChat();
        } else {
            closeMiniChat();
        }
    }

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
