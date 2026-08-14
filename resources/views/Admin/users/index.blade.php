<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - Voca Market</title>
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
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3">
                    <div class="flex-1">
                        <h1 class="font-bold text-xl leading-tight whitespace-nowrap">Voca Market <span class="text-accent">666</span></h1>
                        <p class="text-[9px] uppercase tracking-wider text-white/70 whitespace-nowrap">Marketplace SMK Bakti Nusantara</p>
                    </div>
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
            <div>
                <h1 class="text-xl font-bold text-gray-800">Manajemen Pengguna</h1>
                <p class="text-xs text-gray-500">Kelola data pengguna, siswa, dan penjual Voca Market</p>
            </div>

            <div class="flex items-center gap-4">
                <a 
                    href="{{ route('users.create') }}" 
                    class="px-5 py-2.5 bg-primary text-white font-bold text-sm rounded-xl shadow-md hover:bg-blue-600 transition flex items-center gap-2"
                >
                    <i class="ph-bold ph-plus-circle text-lg"></i>
                    Tambah User Baru
                </a>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8">
            
            <!-- Success Message Alert -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg text-green-700 text-sm flex items-center justify-between">
                    <div class="flex items-center gap-2 font-semibold">
                        <i class="ph-bold ph-check-circle text-lg"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- User Table Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                
                <!-- Table Header Actions -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                    <div class="flex items-center gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                        <a href="{{ route('users.index') }}" class="whitespace-nowrap px-4 py-2 text-sm font-bold rounded-lg transition {{ !request('status') ? 'bg-primary text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Semua Pengguna</a>
                        <a href="{{ route('users.index', ['status' => 'pending']) }}" class="whitespace-nowrap px-4 py-2 text-sm font-bold rounded-lg transition {{ request('status') == 'pending' ? 'bg-primary text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            Pending Seller
                            @if(request('status') != 'pending')
                                <span class="ml-1 bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ \App\Models\User::where('seller_status', 'pending')->count() }}</span>
                            @endif
                        </a>
                    </div>
                    
                    <form action="{{ route('users.index') }}" method="GET" class="relative w-full md:w-80">
                        @if(request('status'))
                            <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari nama, NIS, atau email..." 
                            class="w-full bg-gray-50 border border-gray-200 text-sm rounded-xl pl-10 pr-4 py-2.5 outline-none focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
                        >
                        <i class="ph-bold ph-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </form>

                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500 font-medium">Total Pengguna: <strong class="text-gray-800">{{ $users->count() }}</strong></span>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3.5 rounded-l-xl">PENGGUNA</th>
                                <th class="px-5 py-3.5">NIS / ID</th>
                                <th class="px-5 py-3.5">EMAIL</th>
                                <th class="px-5 py-3.5">ROLE</th>
                                <th class="px-5 py-3.5">SELLER VERIFIED</th>
                                <th class="px-5 py-3.5 text-right rounded-r-xl">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50/80 transition">
                                    <td class="px-5 py-4 font-bold text-gray-800 flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-100 text-primary font-bold flex items-center justify-center text-xs">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $user->name }}</p>
                                            <span class="text-[10px] text-gray-400">Dibuat {{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-gray-700">
                                        {{ $user->nis ?? '-' }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-600">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($user->role === 'admin')
                                            <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">Admin</span>
                                        @elseif($user->role === 'siswa')
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Siswa</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">Pembeli</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($user->seller_status === 'approved' || $user->verification_seller)
                                            <span class="bg-green-100 text-green-700 px-2.5 py-1 rounded-md text-xs font-bold inline-flex items-center gap-1">
                                                <i class="ph-bold ph-check"></i> Ya
                                            </span>
                                        @elseif($user->seller_status === 'pending')
                                            <span class="bg-yellow-100 text-yellow-700 px-2.5 py-1 rounded-md text-xs font-bold inline-flex items-center gap-1">
                                                <i class="ph-bold ph-clock"></i> Pending
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-400 px-2.5 py-1 rounded-md text-xs font-bold">
                                                Tidak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus User">
                                                <i class="ph-bold ph-trash text-base"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-8 text-center text-gray-400">
                                        Belum ada data pengguna. Klik tombol <strong>+ Tambah User Baru</strong> di atas untuk menambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
