<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna - Voca Market</title>
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
            <div class="h-20 flex items-center justify-center border-b border-white/10 px-6">
                <img src="{{ asset('assets/images/Logo_VocaMarket.png') }}" alt="VocaMarket Logo" class="h-10 object-contain drop-shadow-md">
            </div>

            <!-- Nav -->
            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white/80 hover:bg-white/10 hover:text-white transition font-medium">
                    <i class="ph-bold ph-squares-four text-xl"></i>
                    Overview
                </a>
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white text-primary shadow-sm font-bold">
                    <i class="ph-bold ph-users text-xl"></i>
                    Pengguna
                </a>
                <a href="#" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-receipt text-lg"></i>
                        <span>Transaksi</span>
                    </div>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Header -->
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-8 shrink-0 relative z-50">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Detail Pengguna</h1>
                <p class="text-sm text-gray-500">Informasi lengkap pengguna VocaMarket</p>
            </div>

            <!-- Right -->
            <div class="flex items-center gap-6 relative group cursor-pointer">
                <a href="{{ route('users.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-800 transition mr-4">
                    Kembali
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
            </div>
        </header>

        <!-- Content Scrollable -->
        <div class="flex-1 overflow-y-auto p-8">
            <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-100 bg-gray-50 flex items-start gap-6">
                    <div class="w-24 h-24 rounded-full bg-blue-100 text-primary font-bold flex items-center justify-center text-4xl shadow-md border-4 border-white shrink-0">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                            @if($user->role === 'admin')
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-bold">Admin</span>
                            @elseif($user->role === 'siswa')
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Siswa</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">Pembeli</span>
                            @endif
                        </div>
                        <p class="text-gray-500 text-sm mt-1 flex items-center gap-2">
                            <i class="ph-bold ph-envelope-simple"></i> {{ $user->email }}
                        </p>
                        <p class="text-gray-500 text-sm mt-1 flex items-center gap-2">
                            <i class="ph-bold ph-identification-card"></i> NIS: {{ $user->nis ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="p-8">
                    <h3 class="font-bold text-gray-800 text-lg mb-6 border-b border-gray-100 pb-2">Status Toko & Verifikasi</h3>
                    
                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Status Penjual (Toko)</p>
                            @if($user->seller_status === 'approved' || $user->verification_seller)
                                <span class="bg-green-100 text-green-700 px-3 py-1.5 rounded-md text-sm font-bold inline-flex items-center gap-2">
                                    <i class="ph-bold ph-check-circle text-lg"></i> Disetujui (Aktif)
                                </span>
                            @elseif($user->seller_status === 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-md text-sm font-bold inline-flex items-center gap-2">
                                    <i class="ph-bold ph-clock text-lg"></i> Menunggu Persetujuan
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-500 px-3 py-1.5 rounded-md text-sm font-bold inline-flex items-center gap-2">
                                    <i class="ph-bold ph-minus-circle text-lg"></i> Belum Mengajukan
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Bergabung</p>
                            <p class="font-semibold text-gray-800">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</p>
                        </div>
                    </div>

                    @if($user->seller_status === 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 p-5 rounded-xl mb-6">
                            <h4 class="font-bold text-yellow-800 mb-2 flex items-center gap-2">
                                <i class="ph-bold ph-info"></i> Tindakan Diperlukan
                            </h4>
                            <p class="text-sm text-yellow-700 mb-4">Pengguna ini telah mengajukan diri untuk menjadi penjual. Silakan periksa data siswa jika diperlukan, lalu setujui pengajuan ini.</p>
                            
                            <form action="{{ route('users.approve_seller', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-sm flex items-center gap-2">
                                    <i class="ph-bold ph-check-circle text-lg"></i> Setujui Buka Toko
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </main>

</body>
</html>
