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

    @include('layout.header')

        @if(session('success'))
            <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-[100] w-full max-w-md px-4" id="global-alert">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <i class="ph-fill ph-check-circle text-2xl"></i>
                        <p class="font-medium text-sm">{{ session('success') }}</p>
                    </div>
                    <button onclick="document.getElementById('global-alert').remove()" class="text-green-700 hover:text-green-900 ml-4">
                        <i class="ph-bold ph-x text-lg"></i>
                    </button>
                </div>
                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('global-alert');
                        if (alert) {
                            alert.style.transition = 'opacity 0.5s ease';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 3000);
                </script>
            </div>
        @endif
        
        @if(session('error') || $errors->any())
            <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-[100] w-full max-w-md px-4" id="global-error-alert">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <i class="ph-fill ph-warning-circle text-2xl"></i>
                        <div class="text-sm font-medium">
                            @if(session('error'))
                                <p>{{ session('error') }}</p>
                            @endif
                            @if($errors->any())
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <button onclick="document.getElementById('global-error-alert').remove()" class="text-red-700 hover:text-red-900 ml-4 shrink-0">
                        <i class="ph-bold ph-x text-lg"></i>
                    </button>
                </div>
                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('global-error-alert');
                        if (alert) {
                            alert.style.transition = 'opacity 0.5s ease';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 500);
                        }
                    }, 5000);
                </script>
            </div>
        @endif

        @yield('content')
        
    </main>

    @include('layout.footer')



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
