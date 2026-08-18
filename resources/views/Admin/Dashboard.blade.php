<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Voca Market</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6', // Sidebar blue
                        accent: '#ffb900',  // Yellow
                        body: '#f4f7f6'     // Light gray background
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
    <aside class="w-64 bg-primary text-white flex flex-col justify-between shrink-0 h-full shadow-lg z-20">
        <div>
            <!-- Logo -->
            <div class="p-6 border-b border-white/10">
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center justify-center bg-white rounded-xl p-3 shadow-sm transform transition hover:scale-105">
                    <img src="{{ asset('images/Logo_VocaMarket.png') }}" alt="VocaMarket Logo" class="h-10 md:h-12 w-auto object-contain">
                </a>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 flex flex-col px-4 gap-2">
                <a href="{{ url('/admin/dashboard') }}" class="block px-4 py-3 bg-white/10 rounded-xl text-white font-medium border-l-4 border-accent relative shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-squares-four text-xl text-accent"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
                <a href="{{ route('users.index') }}" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-white/5 rounded-xl transition font-medium group">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-users text-xl group-hover:scale-110 transition-transform"></i>
                        <span>Pengguna</span>
                    </div>
                </a>
                <a href="#" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-white/5 rounded-xl transition font-medium group">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-graduation-cap text-xl group-hover:scale-110 transition-transform"></i>
                        <span>Jurusan</span>
                    </div>
                </a>
                <a href="#" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-white/5 rounded-xl transition font-medium group">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-package text-xl group-hover:scale-110 transition-transform"></i>
                        <span>Produk</span>
                    </div>
                </a>
                <a href="#" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-white/5 rounded-xl transition font-medium group">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-shopping-bag-open text-xl group-hover:scale-110 transition-transform"></i>
                        <span>Jasa</span>
                    </div>
                </a>
                <a href="{{ url('/admin/transactions') }}" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-white/5 rounded-xl transition font-medium group">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-receipt text-xl group-hover:scale-110 transition-transform"></i>
                        <span>Transaksi</span>
                    </div>
                </a>
            </nav>
        </div>
        
        <div class="p-6 border-t border-white/10 text-center">
            <h3 class="font-bold text-xs tracking-wider text-white/70">SMK BAKTI NUSANTARA 666</h3>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Header -->
        <header class="h-20 px-8 flex items-center justify-between shrink-0 bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-10 shadow-sm">
            <div>
                <h1 class="text-2xl font-black text-gray-800 tracking-tight">Dashboard Admin</h1>
                <p class="text-sm text-gray-500 font-medium">Ringkasan aktivitas Voca Market hari ini</p>
            </div>

            <div class="flex items-center gap-6 relative group cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block">
                        <p class="font-bold text-sm text-gray-800">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-[11px] text-gray-500 capitalize">{{ Auth::user()->role ?? 'admin' }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-primary to-blue-400 text-white font-bold flex items-center justify-center text-sm shadow-md border-2 border-white">
                        {{ strtoupper(substr(Auth::user()->name ?? 'AD', 0, 2)) }}
                    </div>
                </div>
                
                <!-- Dropdown -->
                <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-[80] transform origin-top-right scale-95 group-hover:scale-100">
                    <a href="{{ url('/') }}" class="block px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-primary transition border-b border-gray-50 rounded-t-xl flex items-center">
                        <i class="ph-bold ph-house mr-3 text-lg"></i> Home Market
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="w-full text-left block px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition rounded-b-xl flex items-center">
                            <i class="ph-bold ph-sign-out mr-3 text-lg"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8 space-y-8 bg-[#f4f7f6]">
            
            <!-- Summary Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card: Pendapatan -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-50 rounded-full group-hover:scale-150 transition-transform duration-500 z-0"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-gray-500 mb-1">Pendapatan Bulan Ini</p>
                            <h3 class="text-2xl font-black text-gray-800 tracking-tight">Rp {{ number_format($revenueMonth, 0, ',', '.') }}</h3>
                            <div class="mt-2 flex items-center text-xs font-bold {{ $revenueChange >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                <i class="ph-bold {{ $revenueChange >= 0 ? 'ph-trend-up' : 'ph-trend-down' }} mr-1 text-sm"></i>
                                <span>{{ abs($revenueChange) }}% dari bulan lalu</span>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                            <i class="ph-bold ph-money text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card: Total Pengguna -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500 z-0"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-gray-500 mb-1">Total Pengguna</p>
                            <h3 class="text-2xl font-black text-gray-800 tracking-tight">{{ number_format($totalUsers) }}</h3>
                            <div class="mt-2 text-xs font-medium text-gray-400">Seluruh pengguna terdaftar</div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-primary flex items-center justify-center shrink-0">
                            <i class="ph-bold ph-users text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card: Produk & Jasa -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-150 transition-transform duration-500 z-0"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-gray-500 mb-1">Katalog Aktif</p>
                            <div class="flex items-end gap-3">
                                <div>
                                    <h3 class="text-xl font-black text-gray-800">{{ number_format($totalProducts) }}</h3>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Produk</span>
                                </div>
                                <div class="w-px h-6 bg-gray-200 mb-1"></div>
                                <div>
                                    <h3 class="text-xl font-black text-gray-800">{{ number_format($totalServices) }}</h3>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jasa</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                            <i class="ph-bold ph-storefront text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Card: Pending Action -->
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-3xl shadow-md relative overflow-hidden text-white group">
                    <div class="absolute -right-10 -bottom-10 opacity-20">
                        <i class="ph-fill ph-bell-ringing text-9xl"></i>
                    </div>
                    <div class="relative z-10">
                        <p class="text-sm font-bold text-gray-300 mb-4">Butuh Perhatian</p>
                        <div class="flex items-center justify-between mb-3 border-b border-gray-700 pb-3">
                            <span class="text-sm font-medium">Pembayaran Tertunda</span>
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-lg">{{ $pendingPayments }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Review Tertunda</span>
                            <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-0.5 rounded-lg">{{ $pendingReviews }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Recent Orders Section -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Transaksi Terbaru</h2>
                        <p class="text-xs text-gray-500 mt-1">Daftar 5 pesanan terakhir yang masuk ke sistem.</p>
                    </div>
                    <a href="{{ url('/admin/transactions') }}" class="text-sm font-bold text-primary hover:text-blue-700 transition flex items-center gap-1">
                        Lihat Semua <i class="ph-bold ph-arrow-right"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50/50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">ORDER ID / WAKTU</th>
                                <th class="px-6 py-4">PEMBELI & PENJUAL</th>
                                <th class="px-6 py-4">ITEM</th>
                                <th class="px-6 py-4">TOTAL</th>
                                <th class="px-6 py-4">STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800">{{ $order->order_number ?? '#ORD-'.$order->id }}</div>
                                        <div class="text-[11px] text-gray-400 mt-1"><i class="ph-bold ph-calendar-blank"></i> {{ $order->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm"><span class="text-gray-400 text-xs w-12 inline-block">Beli:</span> <span class="font-bold text-gray-700">{{ $order->user->name ?? 'User' }}</span></div>
                                        <div class="text-sm mt-1"><span class="text-gray-400 text-xs w-12 inline-block">Jual:</span> <span class="font-bold text-primary">{{ $order->seller->name ?? 'Seller' }}</span></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-700">
                                            @if($order->items && $order->items->count() > 0)
                                                {{ $order->items->first()->product->name ?? 'Produk' }}
                                                @if($order->items->count() > 1)
                                                    <span class="text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded-md ml-1">+{{ $order->items->count() - 1 }} item</span>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-800">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColor = 'bg-gray-100 text-gray-600';
                                            if(in_array($order->status, ['selesai'])) $statusColor = 'bg-green-100 text-green-700';
                                            elseif(in_array($order->status, ['dikirim', 'diproses'])) $statusColor = 'bg-blue-100 text-blue-700';
                                            elseif(in_array($order->status, ['menunggu_pembayaran'])) $statusColor = 'bg-yellow-100 text-yellow-700';
                                            elseif(in_array($order->status, ['dibatalkan'])) $statusColor = 'bg-red-100 text-red-700';
                                        @endphp
                                        <span class="{{ $statusColor }} px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide inline-block">
                                            {{ str_replace('_', ' ', $order->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="ph-thin ph-package text-4xl mb-2 text-gray-300"></i>
                                            <p>Belum ada transaksi.</p>
                                        </div>
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
