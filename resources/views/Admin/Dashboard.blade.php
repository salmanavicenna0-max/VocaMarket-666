<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Voca Market</title>
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
</head>

<body class="bg-body antialiased flex h-screen overflow-hidden text-gray-800 font-sans">

    <!-- Sidebar -->
    <aside class="w-64 bg-primary text-white flex flex-col justify-between shrink-0 h-full">
        <div>
            <!-- Logo -->
            <div class="p-6">
                <a href="{{ url('/admin/dashboard') }}"
                    class="flex items-center justify-center bg-white rounded-lg p-2 shadow-sm">
                    <img src="{{ asset('images/Logo_VocaMarket.png') }}" alt="VocaMarket Logo"
                        class="h-10 md:h-12 w-auto object-contain">
                </a>
            </div>

            <!-- Navigation -->
            <nav class="mt-4 flex flex-col px-4 gap-1">
                <a href="#"
                    class="block px-4 py-3 bg-black/10 rounded-lg text-accent font-medium border border-white/5 relative">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-accent rounded-r-md"></div>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('users.index') }}"
                    class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <span>Pengguna</span>
                </a>
                <a href="#"
                    class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <span>Jurusan</span>
                </a>
                <a href="#"
                    class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <span>Produk</span>
                </a>
                <a href="#"
                    class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <span>Jasa</span>
                </a>
                <a href="{{ route('admin.transactions') }}"
                    class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <span>Transaksi</span>
                </a>
                <a href="#"
                    class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <span>Laporan</span>
                </a>
                <a href="#"
                    class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <span>Pengaturan</span>
                </a>
            </nav>
        </div>

        <div class="p-6">
            <h3 class="font-bold text-xs">SMK BAKTI NUSANTARA 666</h3>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">

        <!-- Header -->
        <header class="h-20 px-8 flex items-center justify-between shrink-0">
            <!-- Search -->
            <div class="relative w-96">
                <input type="text" placeholder="Cari transaksi, siswa, produk..."
                    class="w-full bg-gray-200/60 text-sm rounded-lg px-4 py-2.5 outline-none focus:bg-white focus:ring-2 focus:ring-primary/20 transition">
            </div>

            <!-- Right -->
            <div class="flex items-center gap-6 relative group cursor-pointer">
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="font-bold text-sm text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-gray-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-blue-100 text-primary font-bold flex items-center justify-center text-sm shadow-sm border-2 border-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>

                <!-- Dropdown -->
                <div
                    class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-[80]">
                    <a href="{{ url('/') }}"
                        class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition border-b border-gray-50 rounded-t-lg">
                        <i class="ph-bold ph-house mr-2"></i> Home
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition rounded-b-lg">
                            <i class="ph-bold ph-sign-out mr-2"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Content Scrollable -->
        <div class="flex-1 overflow-y-auto px-8 pb-8">

            <!-- Stats Grid -->
            <div class="grid grid-cols-4 gap-6 mb-6">
                <!-- Stat 1 -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="mb-4">
                        <h3 class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Total Pengguna</h3>
                    </div>
                    <div class="text-3xl font-extrabold text-gray-800 mb-2">{{ number_format($totalUsers, 0, ',' , '.') }}</div>
                    <div class="text-[11px] text-gray-500 flex items-center gap-1">
                        <span class="text-green-500 font-bold">+12.4%</span> dari bulan lalu
                    </div>
                </div>
                <!-- Stat 2 -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="mb-4">
                        <h3 class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Total Produk</h3>
                    </div>
                    <div class="text-3xl font-extrabold text-gray-800 mb-2">{{ number_format($totalProducts,0, ',' , '.') }}</div>
                    <div class="text-[11px] text-gray-500 flex items-center gap-1">
                        <span class="text-green-500 font-bold">+8.1%</span> dari bulan lalu
                    </div>
                </div>
                <!-- Stat 3 -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="mb-4">
                        <h3 class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Total Jasa</h3>
                    </div>
                    <div class="text-3xl font-extrabold text-gray-800 mb-2">{{ number_format($totalServices,0, ',' , '.') }}</div>
                    <div class="text-[11px] text-gray-500 flex items-center gap-1">
                        <span class="text-green-500 font-bold">+15.3%</span> dari bulan lalu
                    </div>
                </div>
                <!-- Stat 4 -->
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="mb-4">
                        <h3 class="text-[11px] font-bold text-gray-500 uppercase tracking-wide">Pendapatan Bulan Ini
                        </h3>
                    </div>
                    <div class="text-3xl font-extrabold text-gray-800 mb-2">Rp {{ number_format($revenueMonth, 0, ',', '.') }}</div>
                    <div class="text-[11px] text-gray-500 flex items-center gap-1">
                        @if($revenueChange > 0)
                            <span class="text-green-500 font-bold">+{{ $revenueChange }}%</span> dari bulan lalu
                        @elseif($revenueChange < 0)
                            <span class="text-red-500 font-bold">{{ $revenueChange }}%</span> dari bulan lalu
                        @else
                            <span class="text-gray-500 font-bold">0%</span> dari bulan lalu
                        @endif
                    </div>
                </div>
            </div>

            <!-- Middle Grid -->
            <div class="grid grid-cols-3 gap-6 mb-6">
                <!-- Left Chart -->
                <div class="col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h2 class="font-bold text-gray-800 text-base mb-1">Grafik Transaksi Bulanan</h2>
                            <p class="text-xs text-gray-500">Total volume penjualan produk & jasa siswa 6 bulan terakhir
                            </p>
                        </div>
                        <button
                            class="bg-blue-50 text-blue-600 font-bold px-4 py-2 rounded-lg text-xs hover:bg-blue-100 transition">
                            Unduh Laporan
                        </button>
                    </div>
                    <div class="flex-1 w-full relative mt-4">
                        <!-- Horizontal Grid Lines -->
                        <div class="absolute inset-0 flex flex-col justify-between pt-4 pb-8">
                            <div class="border-t border-gray-100 w-full"></div>
                            <div class="border-t border-gray-100 w-full"></div>
                            <div class="border-t border-gray-100 w-full"></div>
                            <div class="border-t border-gray-100 w-full"></div>
                            <div class="border-t border-gray-100 w-full"></div>
                        </div>

                        <!-- SVG Line Chart -->
                        <svg class="w-full h-[calc(100%-2rem)] absolute bottom-8 left-0 z-10 overflow-visible"
                            preserveAspectRatio="none" viewBox="0 0 100 100">
                            <!-- Line -->
                            <polyline points="0,85 20,70 40,80 60,55 80,60 100,35" fill="none" stroke="#0a84d4"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <!-- Dots -->
                            <circle cx="0" cy="85" r="1.5" fill="#0a84d4" />
                            <circle cx="20" cy="70" r="1.5" fill="#0a84d4" />
                            <circle cx="40" cy="80" r="1.5" fill="#0a84d4" />
                            <circle cx="60" cy="55" r="1.5" fill="#0a84d4" />
                            <circle cx="80" cy="60" r="1.5" fill="#0a84d4" />
                            <circle cx="100" cy="35" r="1.5" fill="#0a84d4" />
                        </svg>

                        <!-- X Axis Labels -->
                        <div
                            class="absolute bottom-0 left-0 w-full flex justify-between text-[11px] text-gray-500 font-medium font-sans px-1">
                            <span>Jul</span>
                            <span>Agu</span>
                            <span>Sep</span>
                            <span>Okt</span>
                            <span>Nov</span>
                            <span>Des</span>
                        </div>
                    </div>
                </div>

                <!-- Right Stats -->
                <div class="col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col">
                    <h2 class="font-bold text-gray-800 text-base mb-1">Produk & Jasa per Jurusan</h2>
                    <p class="text-[11px] text-gray-500 mb-6">Pembagian penawaran siswa tiap konsentrasi keahlian</p>

                    <div class="flex flex-col gap-4 flex-1 justify-center">
                        <!-- PPLG -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-[9px] font-bold bg-blue-500 text-white px-1.5 py-0.5 rounded">PPLG</span>
                                    <span class="text-xs font-bold text-gray-700">Pengembangan Perangkat Lunak &
                                        Game</span>
                                </div>
                                <span class="text-[11px] font-bold text-gray-800">168 unit</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 flex mb-1.5 overflow-hidden">
                                <div class="bg-blue-500 h-1.5" style="width: 71%"></div>
                                <div class="bg-yellow-400 h-1.5" style="width: 29%"></div>
                            </div>
                            <div class="flex gap-3 text-[9px] text-gray-500 font-medium">
                                <span class="flex items-center gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> 120 Produk</span>
                                <span class="flex items-center gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> 48 Jasa</span>
                            </div>
                        </div>

                        <!-- DKV -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-[9px] font-bold bg-blue-500 text-white px-1.5 py-0.5 rounded">DKV</span>
                                    <span class="text-xs font-bold text-gray-700">Desain Komunikasi Visual</span>
                                </div>
                                <span class="text-[11px] font-bold text-gray-800">162 unit</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 flex mb-1.5 overflow-hidden">
                                <div class="bg-blue-500 h-1.5" style="width: 60%"></div>
                                <div class="bg-yellow-400 h-1.5" style="width: 40%"></div>
                            </div>
                            <div class="flex gap-3 text-[9px] text-gray-500 font-medium">
                                <span class="flex items-center gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> 98 Produk</span>
                                <span class="flex items-center gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> 64 Jasa</span>
                            </div>
                        </div>

                        <!-- Animasi -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-[9px] font-bold bg-blue-500 text-white px-1.5 py-0.5 rounded">Animasi</span>
                                    <span class="text-xs font-bold text-gray-700">Animasi 2D & 3D</span>
                                </div>
                                <span class="text-[11px] font-bold text-gray-800">80 unit</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 flex mb-1.5 overflow-hidden">
                                <div class="bg-blue-500 h-1.5" style="width: 52%"></div>
                                <div class="bg-yellow-400 h-1.5" style="width: 48%"></div>
                            </div>
                            <div class="flex gap-3 text-[9px] text-gray-500 font-medium">
                                <span class="flex items-center gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> 42 Produk</span>
                                <span class="flex items-center gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> 38 Jasa</span>
                            </div>
                        </div>

                        <!-- Pemasaran -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-[9px] font-bold bg-blue-500 text-white px-1.5 py-0.5 rounded">Pemasaran</span>
                                    <span class="text-xs font-bold text-gray-700">Pemasaran Digital</span>
                                </div>
                                <span class="text-[11px] font-bold text-gray-800">84 unit</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 flex mb-1.5 overflow-hidden">
                                <div class="bg-blue-500 h-1.5" style="width: 85%"></div>
                                <div class="bg-yellow-400 h-1.5" style="width: 15%"></div>
                            </div>
                            <div class="flex gap-3 text-[9px] text-gray-500 font-medium">
                                <span class="flex items-center gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> 72 Produk</span>
                                <span class="flex items-center gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> 12 Jasa</span>
                            </div>
                        </div>

                        <!-- Akuntansi -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-[9px] font-bold bg-blue-500 text-white px-1.5 py-0.5 rounded">Akuntansi</span>
                                    <span class="text-xs font-bold text-gray-700">Akuntansi & Keuangan Lembaga</span>
                                </div>
                                <span class="text-[11px] font-bold text-gray-800">51 unit</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 flex mb-1.5 overflow-hidden">
                                <div class="bg-blue-500 h-1.5" style="width: 47%"></div>
                                <div class="bg-yellow-400 h-1.5" style="width: 53%"></div>
                            </div>
                            <div class="flex gap-3 text-[9px] text-gray-500 font-medium">
                                <span class="flex items-center gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> 24 Produk</span>
                                <span class="flex items-center gap-1"><span
                                        class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> 27 Jasa</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="font-bold text-gray-800 text-base mb-1">Transaksi Terbaru</h2>
                        <p class="text-[11px] text-gray-500">5 aktivitas transaksi pasar siswa terakhir</p>
                    </div>
                    <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700">Lihat Semua Transaksi</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[13px] text-gray-600">
                        <thead class="bg-gray-100/70 text-[10px] font-bold text-gray-600 uppercase tracking-wider">
                            <tr>
                                <th class="px-5 py-3 rounded-l-lg">ID TRANS</th>
                                <th class="px-5 py-3">PEMBELI</th>
                                <th class="px-5 py-3">PENJUAL (SISWA)</th>
                                <th class="px-5 py-3">JURUSAN</th>
                                <th class="px-5 py-3">JENIS</th>
                                <th class="px-5 py-3">TOTAL</th>
                                <th class="px-5 py-3 rounded-r-lg">STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <!-- KODE UNIK -->
                                <td class="px-5 py-4 font-bold text-gray-800">TRX-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>

                                <!-- PENGGUNA -->
                                <td class="px-5 py-4">{{ $order->user->name ?? 'Pengguna Umum' }}</td>

                                <!-- PENJUAL -->
                                <td class="px-5 py-4 font-bold text-gray-700">{{ $order->seller->name ?? 'Sistem' }}</td>

                                <!-- JURUSAN -->
                                 <td class="px-5 py-4">
                                    <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-[10px] font-bold">
                                        {{ $order->seller->department->name ?? 'Umum' }}
                                    </span>
                                 </td>

                                <!-- JENIS -->
                                <td class="px-5 py-4 text-gray-500 capitalize">
                                    {{ $order->items->first()->product->type ?? 'Produk' }}
                                </td>

                                <!-- TOTAL -->
                                 <td class="px-5 py-4 font-bold text-gray-800">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                 </td>

                                 <!-- STATUS BADGE -->
                                 <td class="px-5 py-4">
                                 @php $statusClass = match($order->status) {
                                        \App\Models\Order::STATUS_SELESAI => 'bg-green-100 text-green-700',
                                        \App\Models\Order::STATUS_MENUNGGU_PENGEMBALIAN => 'bg-orange-100 text-orange-600',
                                        \App\Models\Order::STATUS_DIBATALKAN => 'bg-gray-100 text-gray-500 border border-gray-200',
                                        default => 'bg-blue-100 text-blue-700'
                                    };
                                @endphp
                                <span class="{{ $statusClass }} px-3 py-1 rounded-md text-[10px] font-bold">
                                    {{ ucfirst(str_replace('_', ' ', strtolower($order->status))) }}
                                </span>
                            </td>
                        </tr>

                        <!-- JIKA TIDAK ADA -->
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-gray-500 text-sm">
                                Belum ada transaksi yang tercatat.
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
