<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Baru - Voca Market</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0a84d4', // Sidebar blue
                        accent: '#ffb900',  // Yellow
                        body: '#eaeaea'     // Light gray background
                    }
                }
            }
        }
    </script>
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-body antialiased flex h-screen overflow-hidden text-gray-800 font-sans">

    <!-- Sidebar -->
    <aside class="w-64 bg-primary text-white flex flex-col justify-between shrink-0 h-full">
        <div>
            <!-- Logo -->
            <div class="p-6">
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center justify-center bg-white rounded-lg p-2 shadow-sm">
                    <img src="{{ asset('images/Logo_VocaMarket.png') }}" alt="VocaMarket Logo" class="h-10 md:h-12 w-auto object-contain">
                </a>
            </div>

            <!-- Navigation -->
            <nav class="mt-4 flex flex-col px-4 gap-1">
                <a href="{{ url('/admin/dashboard') }}" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-squares-four text-lg"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
                <a href="{{ route('users.index') }}" class="block px-4 py-3 bg-black/10 rounded-lg text-accent font-medium border border-white/5 relative">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-accent rounded-r-md"></div>
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-users text-lg"></i>
                        <span>Pengguna</span>
                    </div>
                </a>
                <a href="#" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-graduation-cap text-lg"></i>
                        <span>Jurusan</span>
                    </div>
                </a>
                <a href="#" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-package text-lg"></i>
                        <span>Produk</span>
                    </div>
                </a>
                <a href="#" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-shopping-bag-open text-lg"></i>
                        <span>Jasa</span>
                    </div>
                </a>
                <a href="#" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-receipt text-lg"></i>
                        <span>Transaksi</span>
                    </div>
                </a>
            </nav>
        </div>
        
        <div class="p-6 border-t border-white/10">
            <h3 class="font-bold text-xs">SMK BAKTI NUSANTARA 666</h3>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Header -->
        <header class="h-20 px-8 flex items-center justify-between shrink-0 bg-white/50 backdrop-blur border-b border-gray-200">
            <div class="flex items-center gap-4">
                <a href="{{ route('users.index') }}" class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 transition">
                    <i class="ph-bold ph-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Tambah Pengguna Baru</h1>
                    <p class="text-xs text-gray-500">Isi formulir berikut untuk mendaftarkan akun pengguna baru</p>
                </div>
            </div>

            <!-- Right -->
            <div class="flex items-center gap-6 relative group cursor-pointer">
                <a href="{{ route('users.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-800 transition mr-4">
                    Batal
                </a>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block">
                        <p class="font-bold text-sm text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-primary font-bold flex items-center justify-center text-sm shadow-sm border-2 border-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>
                
                <!-- Dropdown -->
                <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-[80]">
                    <a href="{{ url('/') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition border-b border-gray-50 rounded-t-lg">
                        <i class="ph-bold ph-house mr-2"></i> Home
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition rounded-b-lg">
                            <i class="ph-bold ph-sign-out mr-2"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-3xl mx-auto">
                
                <!-- Notification Alerts -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg text-red-700 text-sm">
                        <div class="flex items-center gap-2 font-bold mb-1">
                            <i class="ph-bold ph-warning-circle text-lg"></i>
                            Terdapat kesalahan pada pengisian form:
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Card Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Nama Lengkap -->
                            <div class="col-span-2 md:col-span-1">
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="ph-bold ph-user text-base"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name') }}"
                                        placeholder="Masukkan nama lengkap" 
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl pl-10 pr-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                        required
                                    >
                                </div>
                            </div>

                            <!-- NIS / Nomor Induk -->
                            <div class="col-span-2 md:col-span-1">
                                <label for="nis" class="block text-sm font-semibold text-gray-700 mb-2">
                                    NIS / ID Pengguna <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="ph-bold ph-card-holder text-base"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="nis" 
                                        name="nis" 
                                        value="{{ old('nis') }}"
                                        maxlength="12"
                                        placeholder="Contoh: 123456789012" 
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl pl-10 pr-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                        required
                                    >
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-span-2 md:col-span-1">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Alamat Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="ph-bold ph-envelope-simple text-base"></i>
                                    </div>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        value="{{ old('email') }}"
                                        placeholder="nama@smkbaktinusantara.sch.id" 
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl pl-10 pr-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                        required
                                    >
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-span-2 md:col-span-1">
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="ph-bold ph-lock-key text-base"></i>
                                    </div>
                                    <input 
                                        type="password" 
                                        id="password" 
                                        name="password" 
                                        placeholder="Minimal 6 karakter" 
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl pl-10 pr-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                                        required
                                    >
                                </div>
                            </div>

                            <!-- Role Pengguna -->
                            <div class="col-span-2 md:col-span-1">
                                <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Role / Peran <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="ph-bold ph-shield-check text-base"></i>
                                    </div>
                                    <select 
                                        id="role" 
                                        name="role" 
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl pl-10 pr-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition appearance-none cursor-pointer"
                                        required
                                    >
                                        <option value="" disabled selected>Pilih Role Pengguna</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola)</option>
                                        <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa (Penjual / Kreator)</option>
                                        <option value="pembeli" {{ old('role') == 'pembeli' ? 'selected' : '' }}>Pembeli (Pengunjung)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="ph-bold ph-caret-down text-sm"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Verifikasi Email -->
                            <div class="col-span-2 md:col-span-1">
                                <label for="email_verification" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Status Verifikasi Email
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="ph-bold ph-seal-check text-base"></i>
                                    </div>
                                    <select 
                                        id="email_verification" 
                                        name="email_verification" 
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl pl-10 pr-4 py-3 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition appearance-none cursor-pointer"
                                    >
                                        <option value="verified" selected>Verified (Terverifikasi)</option>
                                        <option value="unverified">Unverified (Belum Verifikasi)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-gray-400">
                                        <i class="ph-bold ph-caret-down text-sm"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Verifikasi Penjual (Verification Seller) -->
                            <div class="col-span-2 bg-gray-50 rounded-xl p-4 border border-gray-200 flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-sm text-gray-800">Verifikasi Penjual (Seller Status)</h4>
                                    <p class="text-xs text-gray-500">Izinkan akun ini untuk menjual produk & jasa di Voca Market</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        name="verification_seller" 
                                        value="1" 
                                        class="sr-only peer"
                                        {{ old('verification_seller') ? 'checked' : '' }}
                                    >
                                    <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                </label>
                            </div>

                        </div>

                        <!-- Buttons -->
                        <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                            <a 
                                href="{{ route('users.index') }}" 
                                class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition"
                            >
                                Batal
                            </a>
                            <button 
                                type="submit" 
                                class="px-6 py-2.5 rounded-xl bg-primary text-white font-bold text-sm shadow-md hover:bg-blue-600 focus:ring-4 focus:ring-primary/20 transition flex items-center gap-2"
                            >
                                <i class="ph-bold ph-plus-circle text-lg"></i>
                                Simpan User
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
