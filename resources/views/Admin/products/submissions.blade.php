<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Produk & Jasa Siswa - Admin VocaMarket</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0a84d4',
                        accent: '#ffb900',
                        body: '#f4f6f9'
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
                <a href="{{ route('seller.dashboard') }}" class="flex items-center justify-center bg-white rounded-lg p-2 shadow-sm">
                    <img src="{{ asset('images/Logo_VocaMarket.png') }}" alt="VocaMarket Logo" class="h-10 md:h-12 w-auto object-contain">
                </a>
            </div>

            <!-- Navigation -->
            <nav class="mt-4 flex flex-col px-4 gap-1">
                <a href="{{ route('seller.dashboard') }}" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-squares-four text-xl"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
                <a href="{{ route('admin.products.submissions') }}" class="block px-4 py-3 bg-black/10 rounded-lg text-accent font-medium border border-white/5 relative">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-accent rounded-r-md"></div>
                    <div class="flex items-center gap-3">
                        <i class="ph-fill ph-package text-xl text-accent"></i>
                        <span>Pengajuan Produk</span>
                        @if($pendingProducts->count() > 0)
                            <span class="ml-auto bg-accent text-gray-900 text-xs font-extrabold px-2 py-0.5 rounded-full">{{ $pendingProducts->count() }}</span>
                        @endif
                    </div>
                </a>
                <a href="{{ route('users.index') }}" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-users text-xl"></i>
                        <span>Pengguna</span>
                    </div>
                </a>
                <a href="{{ route('admin.transactions') }}" class="block px-4 py-3 text-white/80 hover:text-white hover:bg-black/5 rounded-lg transition font-medium">
                    <div class="flex items-center gap-3">
                        <i class="ph-bold ph-receipt text-xl"></i>
                        <span>Transaksi</span>
                    </div>
                </a>
            </nav>
        </div>

        <div class="p-6 text-xs text-white/70">
            <p class="font-bold">SMK BAKTI NUSANTARA 666</p>
            <p class="mt-1">VocaMarket Admin Panel</p>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Topbar Header -->
        <header class="h-20 bg-white border-b border-gray-200 px-8 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="ph-fill ph-package text-primary text-2xl"></i> Pengajuan Produk & Jasa Siswa
                </h1>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" target="_blank" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-lg transition flex items-center gap-2">
                    <i class="ph-bold ph-storefront text-base"></i> Lihat Toko Publik
                </a>
                <div class="flex items-center gap-3 border-l pl-4 border-gray-200">
                    <div class="text-right">
                        <p class="font-bold text-sm text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Body Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-8 space-y-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <i class="ph-fill ph-check-circle text-2xl"></i>
                        <span class="font-medium text-sm">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 font-bold">✕</button>
                </div>
            @endif

            <!-- Banner & Ringkasan Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border border-yellow-200 rounded-2xl p-5 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-xs font-bold text-yellow-700 uppercase tracking-wider">Menunggu Persetujuan</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $pendingProducts->count() }}</h3>
                        <p class="text-xs text-yellow-800 mt-1">Produk/Jasa perlu ditinjau admin</p>
                    </div>
                    <div class="w-14 h-14 bg-yellow-400/20 text-yellow-700 rounded-2xl flex items-center justify-center text-3xl">
                        <i class="ph-fill ph-clock"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-5 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-xs font-bold text-green-700 uppercase tracking-wider">Telah Disetujui</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $historyProducts->where('approval_status', 'approved')->count() }}</h3>
                        <p class="text-xs text-green-800 mt-1">Aktif & dijual di katalog</p>
                    </div>
                    <div class="w-14 h-14 bg-green-400/20 text-green-700 rounded-2xl flex items-center justify-center text-3xl">
                        <i class="ph-fill ph-check-circle"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-pink-50 border border-red-200 rounded-2xl p-5 flex items-center justify-between shadow-sm">
                    <div>
                        <p class="text-xs font-bold text-red-700 uppercase tracking-wider">Pengajuan Ditolak</p>
                        <h3 class="text-3xl font-extrabold text-gray-900 mt-1">{{ $historyProducts->where('approval_status', 'rejected')->count() }}</h3>
                        <p class="text-xs text-red-800 mt-1">Pengajuan tidak memenuhi syarat</p>
                    </div>
                    <div class="w-14 h-14 bg-red-400/20 text-red-700 rounded-2xl flex items-center justify-center text-3xl">
                        <i class="ph-fill ph-x-circle"></i>
                    </div>
                </div>
            </div>

            <!-- Table 1: Pengajuan Menunggu Konfirmasi -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between bg-gray-50/50">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="ph-fill ph-hourglass text-yellow-500"></i> Pengajuan Baru Menunggu Persetujuan
                        </h2>
                        <p class="text-xs text-gray-500 mt-0.5">Tinjau informasi produk/jasa sebelum diterbitkan ke toko publik</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full border border-yellow-200">
                        {{ $pendingProducts->count() }} Pengajuan Pending
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100/70 text-gray-600 text-xs font-bold uppercase tracking-wider border-b border-gray-200">
                                <th class="p-4 w-[35%]">Produk / Jasa</th>
                                <th class="p-4">Siswa / Penjual</th>
                                <th class="p-4">Kategori & Tipe</th>
                                <th class="p-4 text-center">Harga</th>
                                <th class="p-4 text-center">Stok</th>
                                <th class="p-4 text-center">Aksi Konfirmasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pendingProducts as $product)
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="p-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden shrink-0 relative group">
                                            @if($product->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="w-full h-full object-cover">
                                                @if($product->images->count() > 1)
                                                    <span class="absolute bottom-1 right-1 bg-black/70 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">
                                                        +{{ $product->images->count() - 1 }}
                                                    </span>
                                                @endif
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <i class="ph-fill ph-image text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm line-clamp-1">{{ $product->name }}</h4>
                                            <p class="text-xs text-gray-500 mt-0.5 line-clamp-1">{{ $product->description }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($product->seller->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $product->seller->name ?? 'Siswa' }}</p>
                                            <p class="text-[11px] text-gray-500">{{ $product->seller->email ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="inline-block bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-md border border-blue-100">
                                        {{ $product->category }}
                                    </span>
                                    @if($product->type)
                                        <p class="text-xs text-gray-500 mt-1 font-medium">{{ $product->type }}</p>
                                    @endif
                                </td>
                                <td class="p-4 text-center font-bold text-primary text-sm">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center">
                                    <span class="bg-gray-100 text-gray-700 text-xs font-bold px-2 py-1 rounded">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Detail Button -->
                                        <button onclick="openDetailModal({{ json_encode($product) }}, {{ json_encode($product->images) }}, {{ json_encode($product->seller) }})" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition flex items-center gap-1">
                                            <i class="ph-bold ph-eye text-sm"></i> Detail
                                        </button>

                                        <!-- Approve Form -->
                                        <form action="{{ route('admin.products.approve', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui dan menerbitkan produk ini ke toko?');">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition shadow-sm flex items-center gap-1">
                                                <i class="ph-bold ph-check text-sm"></i> Setujui
                                            </button>
                                        </form>

                                        <!-- Reject Form -->
                                        <form action="{{ route('admin.products.reject', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak pengajuan produk ini?');">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-600 text-xs font-bold rounded-lg transition flex items-center gap-1">
                                                <i class="ph-bold ph-x text-sm"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-gray-500">
                                    <i class="ph-fill ph-check-circle text-4xl text-green-500 mb-2 block"></i>
                                    <p class="font-bold text-gray-700">Tidak Ada Pengajuan Pending</p>
                                    <p class="text-xs text-gray-400 mt-1">Semua pengajuan produk/jasa dari siswa telah selesai ditinjau.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table 2: Riwayat Pengajuan Terakhir -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50">
                    <h2 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="ph-fill ph-clock-counter-clockwise text-gray-500"></i> Riwayat Persetujuan Pengajuan Terbaru
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider border-b border-gray-200">
                                <th class="p-4">Produk</th>
                                <th class="p-4">Penjual</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4 text-center">Harga</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($historyProducts as $product)
                            <tr class="hover:bg-gray-50/50">
                                <td class="p-4 font-bold text-gray-900">{{ $product->name }}</td>
                                <td class="p-4 text-gray-600">{{ $product->seller->name ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $product->category }}</td>
                                <td class="p-4 text-center font-bold text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="p-4 text-center">
                                    @if($product->approval_status === 'approved' || $product->is_active)
                                        <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full inline-flex items-center">
                                            <i class="ph-bold ph-check mr-1"></i> Disetujui
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full inline-flex items-center">
                                            <i class="ph-bold ph-x mr-1"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-center text-xs text-gray-500">{{ $product->updated_at->format('d M Y, H:i') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="p-6 text-center text-gray-400 text-xs">Belum ada riwayat persetujuan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Detail Pengajuan Produk -->
    <div id="detailModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl p-6 relative animate-fadeIn">
            <button onclick="closeDetailModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 p-2 rounded-lg text-xl">
                <i class="ph-bold ph-x"></i>
            </button>

            <h3 class="text-xl font-bold text-gray-900 border-b pb-3 mb-4 flex items-center gap-2">
                <i class="ph-fill ph-package text-primary"></i> Detail Pengajuan Produk / Jasa
            </h3>

            <!-- Grid Foto / Media -->
            <div id="modalMediaContainer" class="grid grid-cols-3 gap-3 mb-6"></div>

            <div class="space-y-4 text-sm">
                <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div>
                        <p class="text-xs text-gray-500">Nama Produk / Jasa</p>
                        <p id="modalProductName" class="font-bold text-gray-900 text-base mt-0.5">-</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Harga</p>
                        <p id="modalProductPrice" class="font-extrabold text-primary text-base mt-0.5">-</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Kategori & Tipe</p>
                        <p id="modalProductCategory" class="font-semibold text-gray-800 mt-0.5">-</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Stok</p>
                        <p id="modalProductStock" class="font-semibold text-gray-800 mt-0.5">-</p>
                    </div>
                </div>

                <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                    <p class="text-xs text-gray-500 font-bold mb-1">Informasi Siswa / Penjual</p>
                    <p id="modalSellerName" class="font-bold text-gray-900">-</p>
                    <p id="modalSellerEmail" class="text-xs text-gray-600 mt-0.5">-</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 font-bold mb-1">Deskripsi Produk / Layanan</p>
                    <div id="modalProductDescription" class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-gray-700 leading-relaxed whitespace-pre-line"></div>
                </div>
            </div>

            <!-- Footer Action inside Modal -->
            <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end gap-3" id="modalActionContainer"></div>
        </div>
    </div>

    <script>
        function openDetailModal(product, images, seller) {
            document.getElementById('modalProductName').innerText = product.name;
            document.getElementById('modalProductPrice').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(product.price);
            document.getElementById('modalProductCategory').innerText = product.category + (product.type ? ' (' + product.type + ')' : '');
            document.getElementById('modalProductStock').innerText = product.stock + ' unit';
            document.getElementById('modalSellerName').innerText = seller ? seller.name : 'Siswa';
            document.getElementById('modalSellerEmail').innerText = seller ? seller.email : '-';
            document.getElementById('modalProductDescription').innerText = product.description;

            // Render Media
            const mediaContainer = document.getElementById('modalMediaContainer');
            mediaContainer.innerHTML = '';

            if (images && images.length > 0) {
                images.forEach(img => {
                    const isVideo = img.path.match(/\.(mp4|webm|mov|ogg|m4v)$/i);
                    const div = document.createElement('div');
                    div.className = 'h-32 rounded-xl border border-gray-200 overflow-hidden bg-gray-100 relative';
                    
                    if (isVideo) {
                        div.innerHTML = `<video src="/storage/${img.path}" controls class="w-full h-full object-cover"></video>`;
                    } else {
                        div.innerHTML = `<a href="/storage/${img.path}" target="_blank"><img src="/storage/${img.path}" class="w-full h-full object-cover hover:scale-105 transition duration-300"></a>`;
                    }
                    mediaContainer.appendChild(div);
                });
            } else {
                mediaContainer.innerHTML = '<div class="col-span-3 p-4 bg-gray-50 text-center text-gray-400 rounded-xl">Tidak ada foto/video terlampir.</div>';
            }

            // Action Buttons
            const actionContainer = document.getElementById('modalActionContainer');
            actionContainer.innerHTML = `
                <button onclick="closeDetailModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg text-sm transition">Tutup</button>
                <form action="/admin/products/${product.id}/reject" method="POST" onsubmit="return confirm('Yakin tolak pengajuan ini?');">
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'}">
                    <button type="submit" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-600 font-bold rounded-lg text-sm transition">Tolak</button>
                </form>
                <form action="/admin/products/${product.id}/approve" method="POST" onsubmit="return confirm('Setujui dan publikasikan produk ini?');">
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'}">
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg text-sm shadow transition">Setujui & Publikasikan</button>
                </form>
            `;

            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.getElementById('detailModal').classList.remove('flex');
        }
    </script>
</body>

</html>
