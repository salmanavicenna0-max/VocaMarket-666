@extends('layouts.app')
@section('title', 'Dashboard Siswa - Pengajuan Produk & Grafik Penjualan - VocaMarket')

@section('content')

<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 space-y-8">

        <!-- Section 1: Ringkasan Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Stat 1: Total Pendapatan -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Hasil Penjualan</p>
                    <h3 class="text-2xl font-black text-gray-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-green-600 font-semibold mt-1"><i class="ph-bold ph-check"></i> Dari transaksi selesai</p>
                </div>
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-2xl shrink-0">
                    <i class="ph-fill ph-wallet"></i>
                </div>
            </div>

            <!-- Stat 2: Total Pesanan Terjual -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Transaksi Terjual</p>
                    <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $completedOrdersCount }}</h3>
                    <p class="text-[11px] text-gray-400 mt-1">Item disetujui dibeli pembeli</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl shrink-0">
                    <i class="ph-fill ph-shopping-bag"></i>
                </div>
            </div>

            <!-- Stat 3: Menunggu Admin -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider">Menunggu Admin</p>
                    <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $pendingProductsCount }}</h3>
                    <p class="text-[11px] text-yellow-700 mt-1">Sedang ditinjau admin</p>
                </div>
                <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center text-2xl shrink-0">
                    <i class="ph-fill ph-clock"></i>
                </div>
            </div>

            <!-- Stat 4: Produk Aktif -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-purple-600 uppercase tracking-wider">Disetujui / Tayang</p>
                    <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $approvedProductsCount }}</h3>
                    <p class="text-[11px] text-purple-700 mt-1">Tampil di katalog toko</p>
                </div>
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-2xl shrink-0">
                    <i class="ph-fill ph-check-circle"></i>
                </div>
            </div>
        </div>

        <!-- Section 2: Grafik Penjualan (Read-Only) -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6 border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="ph-fill ph-chart-line-up text-primary"></i> Grafik Penjualan Produk Saya
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Statistik tren pendapatan hasil titip produk karya kamu dalam 6 bulan terakhir</p>
                </div>
                <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1.5 rounded-lg border border-gray-200 flex items-center gap-1.5">
                    <i class="ph-bold ph-eye"></i> Mode Hanya Baca (Read-Only)
                </span>
            </div>

            <div class="h-64 w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        @if(isset($refundRequests) && $refundRequests->isNotEmpty())
        <!-- Section: Pengajuan Refund Diteruskan Admin -->
        <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-2xl border border-orange-200 overflow-hidden shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-orange-200/60 pb-3">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="ph-fill ph-warning text-orange-600"></i> Pengajuan Refund Diteruskan Admin
                    </h2>
                    <p class="text-xs text-gray-600 mt-0.5">Admin telah menyetujui pengajuan pengembalian dari pembeli. Silakan beri persetujuan akhir.</p>
                </div>
                <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                    {{ $refundRequests->count() }} Perlu Konfirmasi
                </span>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl border border-orange-200">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-orange-100/50 text-gray-700 text-xs font-bold uppercase border-b border-orange-200">
                            <th class="p-4">Kode Transaksi</th>
                            <th class="p-4">Pembeli</th>
                            <th class="p-4 text-center">Total Refund</th>
                            <th class="p-4 text-center">Konfirmasi Penjual</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($refundRequests as $reqOrder)
                        <tr>
                            <td class="p-4 font-bold text-gray-900">{{ $reqOrder->code_order }}</td>
                            <td class="p-4 text-gray-700">{{ $reqOrder->user->name ?? 'Pembeli' }}</td>
                            <td class="p-4 text-center font-bold text-red-600">Rp {{ number_format($reqOrder->total, 0, ',', '.') }}</td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('seller.refund.approve', $reqOrder->id) }}" method="POST" onsubmit="return confirm('Apakah Anda setuju untuk menyetujui pengembalian dana ini?');">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-bold text-xs rounded-xl shadow transition">
                                            ✓ Setujui Refund
                                        </button>
                                    </form>
                                    <form action="{{ route('seller.refund.reject', $reqOrder->id) }}" method="POST" onsubmit="return confirm('Tolak refund? Pesanan akan ditandai Selesai.');">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-600 font-bold text-xs rounded-xl transition">
                                            ✕ Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Section 3: Daftar Pengajuan Produk Saya -->
        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-gray-200 flex flex-wrap justify-between items-center gap-4 bg-gray-50/50">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="ph-fill ph-package text-primary"></i> Daftar Pengajuan Produk & Jasa Saya
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Pantau status persetujuan dari Admin untuk setiap produk yang kamu ajukan</p>
                </div>
                <button onclick="openAddModal()" class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs shadow transition flex items-center gap-2">
                    <i class="ph-bold ph-plus"></i>Ajukan Baru
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100/70 text-gray-600 text-xs font-bold uppercase tracking-wider border-b border-gray-200">
                            <th class="p-4 w-[40%]">Info Produk / Jasa</th>
                            <th class="p-4">Kategori & Tipe</th>
                            <th class="p-4 text-center">Harga</th>
                            <th class="p-4 text-center">Stok</th>
                            <th class="p-4 text-center">Status Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50/60 transition">
                            <td class="p-4">
                                <div class="flex gap-4 items-center">
                                    <div class="w-14 h-14 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden shrink-0 relative">
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
                                <span class="bg-blue-50 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-md border border-blue-100 inline-block">
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
                                    {{ $product->isJasa() ? '-' : $product->stock }}
                                </span>
                            </td>
                            <td class="p-4 text-center">
                                @if($product->approval_status === 'pending' || (!$product->is_active && $product->approval_status !== 'rejected'))
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full border border-yellow-200 inline-flex items-center">
                                        <i class="ph-bold ph-clock mr-1.5"></i> Menunggu Persetujuan Admin
                                    </span>
                                @elseif($product->approval_status === 'approved' || $product->is_active)
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full border border-green-200 inline-flex items-center">
                                        <i class="ph-bold ph-check-circle mr-1.5"></i> Disetujui & Tayang di Toko
                                    </span>
                                @elseif($product->approval_status === 'rejected')
                                    <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full border border-red-200 inline-flex items-center">
                                        <i class="ph-bold ph-x-circle mr-1.5"></i> Ditolak Admin
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-gray-500">
                                <i class="ph-fill ph-package text-4xl text-gray-300 mb-2 block"></i>
                                <p class="font-bold text-gray-700">Belum Ada Pengajuan Produk / Jasa</p>
                                <p class="text-xs text-gray-400 mt-1 mb-4">Kamu belum pernah mengajukan produk atau jasa ke toko VocaMarket.</p>

                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Modal Ajukan Produk / Jasa Baru -->
<div id="addModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden items-start justify-center overflow-y-auto p-4 pt-10">
    <div class="bg-white rounded-2xl max-w-2xl w-full shadow-2xl overflow-hidden relative my-auto animate-fadeIn">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2">
                <i class="ph-fill ph-plus-circle text-primary"></i> Form Pengajuan Titip Produk / Jasa
            </h3>
            <button onclick="closeAddModal()" class="text-gray-400 hover:text-red-500 p-2 rounded-lg transition focus:outline-none">
                <i class="ph-bold ph-x text-lg"></i>
            </button>
        </div>

        <form action="{{ route('seller.product.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Produk / Jasa <span class="text-red-500">*</span></label>
                <input type="text" name="name" placeholder="Contoh: Jasa Desain Post Medsos / Kaos Merchandise DKV" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Kategori Utama <span class="text-red-500">*</span></label>
                    <select name="category" id="katUtama" onchange="updateSubKat()" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white transition" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <optgroup label="Produk Sekolah">
                            <option value="Aksesoris">Aksesoris</option>
                            <option value="Merchandise">Merchandise</option>
                            <option value="Hardware">Hardware</option>
                        </optgroup>
                        <optgroup label="Jasa Jurusan">
                            <option value="DKV & Animasi">DKV & Animasi</option>
                            <option value="Pemasaran">Pemasaran</option>
                            <option value="PPLG">PPLG</option>
                            <option value="Akuntansi">Akuntansi</option>
                        </optgroup>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tipe / Sub-Kategori</label>
                    <select name="sub_category" id="subKat" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white transition disabled:bg-gray-100 disabled:cursor-not-allowed" disabled>
                        <option value="" disabled selected>Pilih Kategori Utama Dulu</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label id="lblHargaSubmission" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-2.5 text-gray-500 text-sm font-bold">Rp</span>
                        <input type="text" name="price" oninput="formatRupiah(this)" placeholder="0" class="w-full border border-gray-300 rounded-xl pl-12 pr-4 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition" required>
                    </div>
                </div>
                <div id="containerStokSubmission">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Stok Unit <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="1" min="0" placeholder="Contoh: 10" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi Lengkap <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" placeholder="Tuliskan spesifikasi produk atau layanan jasa yang kamu ajukan secara detail..." class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition" required></textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Unggah Foto / Video Produk (Bisa Lebih Dari 1 File, Maks. 10)</label>
                <div onclick="document.getElementById('imgInp').click()" class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary hover:bg-blue-50/50 transition cursor-pointer bg-gray-50 group">
                    <i class="ph-bold ph-upload-simple text-3xl text-gray-400 group-hover:text-primary transition mb-1"></i>
                    <p class="text-xs font-bold text-gray-700">Klik untuk memilih foto / video (bisa pilih beberapa sekaligus)</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Format: JPG, PNG, WEBP, MP4 (Maks. 10 file, hingga 50MB per file)</p>
                    <input type="file" name="images[]" id="imgInp" onchange="previewMedia(event)" multiple accept="image/*,video/*" class="hidden">
                </div>
                <div id="mediaPreviews" class="flex gap-3 mt-3 overflow-x-auto pb-2 hidden"></div>
            </div>

            <div class="pt-4 border-t border-gray-200 flex items-center justify-end gap-3">
                <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-blue-700 text-white font-extrabold text-xs rounded-xl shadow transition flex items-center gap-2">
                    <i class="ph-bold ph-paper-plane-tilt text-sm"></i> Kirim Pengajuan ke Admin
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const salesData = @json($salesData);
        const labels = salesData.map(item => item.month);
        const totals = salesData.map(item => item.total);

        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: totals,
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3B82F6',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Pendapatan: Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                }
            }
        });
    });

    let selectedSubmissionMedia = [];

    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
        document.getElementById('addModal').classList.add('flex');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('addModal').classList.remove('flex');
        selectedSubmissionMedia = [];
        updateSubmissionMediaUI();
    }

    function formatRupiah(input) {
        let value = input.value.replace(/[^,\d]/g, '').toString();
        let split = value.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        input.value = rupiah;
    }

    const subCategories = {
        'Aksesoris': ['Ganci', 'Nametag', 'Pin', 'Kaos', 'Gelas Custom'],
        'Merchandise': ['Kaos Khusus Sekolah', 'Gelas BN', 'Pulpen BN'],
        'Hardware': ['IoT (Hardware)'],
        'DKV & Animasi': ['Animasi (Logo gerak, iklan, dll)', 'Motion Graphic', 'Video Promosi', 'Desain Grafis'],
        'Pemasaran': ['Digital Marketing', 'Admin Medsos'],
        'PPLG': ['Website', 'Mobile', 'Server Hosting', 'Cloud', 'Game DEV', 'Excel', 'IoT (Software)'],
        'Akuntansi': ['Pembukuan', 'Pembuatan Laporan', 'Konsul Pajak']
    };

    function updateSubKat() {
        const cat = document.getElementById('katUtama').value;
        const sub = document.getElementById('subKat');
        sub.innerHTML = '<option value="" disabled selected>Pilih Sub-Kategori</option>';

        // Logic Jasa
        const isJasa = ['DKV & Animasi', 'Pemasaran', 'PPLG', 'Akuntansi'].includes(cat);
        const lblHargaSubmission = document.getElementById('lblHargaSubmission');
        const containerStokSubmission = document.getElementById('containerStokSubmission');

        if (isJasa) {
            containerStokSubmission.classList.add('hidden');
            lblHargaSubmission.innerHTML = 'Harga Mulai Dari (Rp) <span class="text-red-500">*</span>';
        } else {
            containerStokSubmission.classList.remove('hidden');
            lblHargaSubmission.innerHTML = 'Harga (Rp) <span class="text-red-500">*</span>';
        }

        if (subCategories[cat]) {
            sub.disabled = false;
            subCategories[cat].forEach(item => {
                sub.innerHTML += `<option value="${item}">${item}</option>`;
            });
        } else {
            sub.disabled = true;
        }
    }

    function previewMedia(event) {
        const newFiles = Array.from(event.target.files);
        
        for (let file of newFiles) {
            if (selectedSubmissionMedia.length < 10) {
                // Avoid exact duplicate files
                const exists = selectedSubmissionMedia.some(f => f.name === file.name && f.size === file.size);
                if (!exists) {
                    selectedSubmissionMedia.push(file);
                }
            }
        }

        updateSubmissionMediaUI();
    }

    function removeSubmissionMedia(index) {
        selectedSubmissionMedia.splice(index, 1);
        updateSubmissionMediaUI();
    }

    function updateSubmissionMediaUI() {
        const input = document.getElementById('imgInp');
        const container = document.getElementById('mediaPreviews');
        if (!input || !container) return;

        // Sync files array to input via DataTransfer
        try {
            const dt = new DataTransfer();
            selectedSubmissionMedia.forEach(f => dt.items.add(f));
            input.files = dt.files;
        } catch(e) {
            console.error("DataTransfer error", e);
        }

        if (selectedSubmissionMedia.length > 0) {
            container.classList.remove('hidden');
            container.innerHTML = '';

            selectedSubmissionMedia.forEach((file, idx) => {
                const isVideo = file.type.startsWith('video/') || file.name.match(/\.(mp4|webm|mov|ogg|m4v)$/i);
                const div = document.createElement('div');
                div.className = 'w-24 h-24 rounded-xl border border-gray-200 overflow-hidden bg-gray-100 shrink-0 relative group shadow-sm';

                const url = URL.createObjectURL(file);
                if (isVideo) {
                    div.innerHTML = `
                        <video src="${url}" class="w-full h-full object-cover"></video>
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center pointer-events-none">
                            <i class="ph-fill ph-video-camera text-white text-xl"></i>
                        </div>
                    `;
                } else {
                    div.innerHTML = `<img src="${url}" class="w-full h-full object-cover">`;
                }

                div.innerHTML += `
                    <button type="button" onclick="removeSubmissionMedia(${idx})" class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md transition z-10" title="Hapus File Ini">
                        <i class="ph-bold ph-x text-[10px]"></i>
                    </button>
                    <span class="absolute bottom-1 left-1 bg-black/60 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">#${idx + 1}</span>
                `;

                container.appendChild(div);
            });
        } else {
            container.classList.add('hidden');
            container.innerHTML = '';
        }
    }
</script>
@endsection
