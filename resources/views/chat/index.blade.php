@extends('layouts.app')
@section('title', 'Pesan - VocaMarket')
@section('content')

<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex h-[75vh]">
        
        <!-- Sidebar: Chat List -->
        <div class="w-full md:w-1/3 lg:w-1/4 border-r border-gray-200 flex flex-col bg-gray-50/50">
            <!-- Header -->
            <div class="p-4 border-b border-gray-200 bg-white">
                <h2 class="text-lg font-bold text-gray-900">Pesan</h2>
                <div class="mt-3 relative">
                    <i class="ph-bold ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Cari percakapan..." class="w-full bg-gray-100 text-sm rounded-lg pl-9 pr-4 py-2 outline-none focus:ring-2 focus:ring-primary/20 transition">
                </div>
            </div>
            
            <!-- Chat List -->
            <div class="flex-1 overflow-y-auto hide-scrollbar bg-white">
                
                <!-- Chat Item 1 (Active) -->
                <a href="#" class="flex items-center gap-3 p-4 border-b border-gray-100 bg-blue-50/50 hover:bg-blue-50 transition cursor-pointer relative">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary rounded-r-md"></div>
                    <div class="relative shrink-0">
                        <img src="https://ui-avatars.com/api/?name=Siswa+Esemka&background=random" class="w-12 h-12 rounded-full object-cover border border-gray-200">
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="font-bold text-gray-900 text-sm truncate">Toko Siswa Esemka</h3>
                            <span class="text-xs text-gray-500">10:42</span>
                        </div>
                        <p class="text-sm text-gray-600 truncate font-medium text-gray-800">Baik kak, pesanannya akan segera kami proses ya!</p>
                    </div>
                </a>

                <!-- Chat Item 2 -->
                <a href="#" class="flex items-center gap-3 p-4 border-b border-gray-100 hover:bg-gray-50 transition cursor-pointer">
                    <div class="relative shrink-0">
                        <img src="https://picsum.photos/seed/toko-alat-tulis-kita/100/100" class="w-12 h-12 rounded-full object-cover border border-gray-200">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="font-bold text-gray-900 text-sm truncate">Toko Alat Tulis Kita</h3>
                            <span class="text-xs text-gray-500">Kemarin</span>
                        </div>
                        <p class="text-sm text-gray-500 truncate">Sama-sama kak, terima kasih sudah order!</p>
                    </div>
                </a>

                <!-- Chat Item 3 -->
                <a href="#" class="flex items-center gap-3 p-4 border-b border-gray-100 hover:bg-gray-50 transition cursor-pointer">
                    <div class="relative shrink-0">
                        <img src="https://picsum.photos/seed/desain/100/100" class="w-12 h-12 rounded-full object-cover border border-gray-200">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="font-bold text-gray-900 text-sm truncate">Studio Animasi 666</h3>
                            <span class="text-xs text-gray-500">Senin</span>
                        </div>
                        <p class="text-sm text-gray-500 truncate">Untuk revisi desain logo sudah saya kirim ke email ya kak.</p>
                    </div>
                </a>

            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="hidden md:flex flex-col flex-1 bg-white">
            
            <!-- Chat Header -->
            <div class="p-4 border-b border-gray-200 flex items-center justify-between bg-white shrink-0">
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Siswa+Esemka&background=random" class="w-10 h-10 rounded-full border border-gray-200 object-cover">
                    <div>
                        <a href="{{ url('/seller/1') }}" class="font-bold text-gray-900 text-base hover:text-primary transition">Toko Siswa Esemka</a>
                        <p class="text-xs text-green-500 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Sedang Online</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-gray-500">
                    <button class="hover:text-primary transition"><i class="ph-bold ph-magnifying-glass text-xl"></i></button>
                    <button class="hover:text-primary transition"><i class="ph-bold ph-info text-xl"></i></button>
                    <button class="hover:text-primary transition"><i class="ph-bold ph-dots-three-vertical text-xl"></i></button>
                </div>
            </div>

            <!-- Chat Product Card (Pinned Context) -->
            <div class="bg-blue-50/50 p-3 border-b border-blue-100 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <img src="https://picsum.photos/seed/seragam/100/100" class="w-10 h-10 rounded-md object-cover border border-gray-200">
                    <div class="flex flex-col">
                        <span class="text-sm font-medium text-gray-800 line-clamp-1">Seragam SD Merah Putih Lengan Pendek Berkualitas</span>
                        <span class="text-xs font-bold text-primary">Rp55.000</span>
                    </div>
                </div>
                <button class="px-4 py-1.5 bg-white border border-primary text-primary text-xs font-bold rounded hover:bg-blue-50 transition">Beli Sekarang</button>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 p-4 overflow-y-auto bg-gray-50 flex flex-col gap-4">
                
                <div class="text-center my-2">
                    <span class="text-xs bg-gray-200 text-gray-600 px-3 py-1 rounded-full">Hari Ini</span>
                </div>

                <!-- Message (Self) -->
                <div class="flex items-end justify-end gap-2">
                    <div class="flex flex-col items-end max-w-[70%]">
                        <div class="bg-primary text-white rounded-2xl rounded-br-sm px-4 py-2 shadow-sm">
                            <p class="text-sm">Halo min, untuk seragam ukuran XL apakah ready stock?</p>
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1">10:30 <i class="ph-bold ph-checks text-primary"></i></span>
                    </div>
                </div>

                <!-- Message (Other) -->
                <div class="flex items-end gap-2">
                    <img src="https://ui-avatars.com/api/?name=Siswa+Esemka&background=random" class="w-8 h-8 rounded-full mb-4">
                    <div class="flex flex-col items-start max-w-[70%]">
                        <div class="bg-white text-gray-800 border border-gray-200 rounded-2xl rounded-bl-sm px-4 py-2 shadow-sm">
                            <p class="text-sm">Halo kak! Selamat pagi 🙏</p>
                        </div>
                        <div class="bg-white text-gray-800 border border-gray-200 rounded-2xl rounded-bl-sm px-4 py-2 shadow-sm mt-1">
                            <p class="text-sm">Untuk ukuran XL saat ini masih ready stock ya kak, silakan langsung diorder sebelum kehabisan.</p>
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1">10:35</span>
                    </div>
                </div>
                
                <!-- Message (Self) -->
                <div class="flex items-end justify-end gap-2">
                    <div class="flex flex-col items-end max-w-[70%]">
                        <div class="bg-primary text-white rounded-2xl rounded-br-sm px-4 py-2 shadow-sm">
                            <p class="text-sm">Oke mantap, saya order 2 pcs ya.</p>
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1">10:40 <i class="ph-bold ph-checks text-primary"></i></span>
                    </div>
                </div>

                <!-- Message (Other) -->
                <div class="flex items-end gap-2">
                    <img src="https://ui-avatars.com/api/?name=Siswa+Esemka&background=random" class="w-8 h-8 rounded-full mb-4">
                    <div class="flex flex-col items-start max-w-[70%]">
                        <div class="bg-white text-gray-800 border border-gray-200 rounded-2xl rounded-bl-sm px-4 py-2 shadow-sm">
                            <p class="text-sm">Baik kak, pesanannya akan segera kami proses ya!</p>
                        </div>
                        <span class="text-[10px] text-gray-400 mt-1">10:42</span>
                    </div>
                </div>

            </div>

            <!-- Chat Input -->
            <div class="p-4 bg-white border-t border-gray-200 shrink-0">
                <div class="flex items-end gap-2 bg-gray-100 rounded-xl p-2 border border-gray-200 focus-within:border-primary/50 focus-within:ring-2 focus-within:ring-primary/20 transition">
                    <button class="p-2 text-gray-500 hover:text-primary transition shrink-0">
                        <i class="ph-bold ph-plus text-xl"></i>
                    </button>
                    <button class="p-2 text-gray-500 hover:text-primary transition shrink-0">
                        <i class="ph-bold ph-image text-xl"></i>
                    </button>
                    <textarea rows="1" placeholder="Tulis pesan..." class="w-full bg-transparent border-none outline-none resize-none text-sm py-2 px-2 max-h-32 text-gray-800 placeholder-gray-500"></textarea>
                    <button class="p-2.5 bg-primary text-white rounded-lg hover:bg-primary-dark transition shrink-0 shadow-sm flex items-center justify-center">
                        <i class="ph-bold ph-paper-plane-right text-lg"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
