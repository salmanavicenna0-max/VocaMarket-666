@extends('layouts.app')
@section('title', 'Daftar Pesanan Saya - VocaMarket')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="ph-bold ph-receipt text-primary"></i> Daftar Pesanan Saya
        </h1>
        <a href="{{ url('/') }}" class="text-sm text-primary hover:underline flex items-center gap-1">
            <i class="ph-bold ph-arrow-left"></i> Lanjut Belanja
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 flex overflow-x-auto border-b border-gray-200">
        <button onclick="switchOrderTab('produk')" id="tab-btn-produk" class="px-6 py-3 font-bold text-sm border-b-2 border-primary text-primary transition">Pesanan Produk</button>
        <button onclick="switchOrderTab('jasa')" id="tab-btn-jasa" class="px-6 py-3 font-medium text-sm border-b-2 border-transparent text-gray-500 hover:text-primary transition flex items-center">
            Pengajuan Jasa
            @if(isset($serviceRequests) && $serviceRequests->where('status', 'quoted')->count() > 0)
                <span class="bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full ml-2">{{ $serviceRequests->where('status', 'quoted')->count() }}</span>
            @endif
        </button>
    </div>

    <!-- Konten Pesanan Produk -->
    <div id="content-produk" class="block">
    @forelse($orders as $order)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden hover:shadow-md transition">
            <!-- Order Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex flex-wrap gap-4 items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Tanggal Pesanan</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">ID Pesanan</p>
                    <p class="text-sm font-semibold text-gray-800 uppercase">#{{ substr($order->id, 0, 8) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Status</p>
                    @if($order->status == 'menunggu_pembayaran')
                        <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded">Menunggu Pembayaran</span>
                    @elseif($order->status == 'diproses')
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded">Diproses</span>
                    @elseif($order->status == 'menunggu_verifikasi')
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded">Menunggu Konfirmasi Penjual</span>
                    @elseif($order->status == 'selesai')
                        <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded">Selesai</span>
                    @elseif($order->status == 'menunggu_pengembalian')
                        <span class="bg-orange-100 text-orange-700 text-xs font-bold px-2 py-1 rounded">Menunggu Pengembalian</span>
                    @elseif($order->status == 'pengembalian')
                        <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded">Dikembalikan</span>
                    @else
                        <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded">Dibatalkan</span>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 mb-1">Total Belanja</p>
                    <p class="text-lg font-bold text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="p-6">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 mb-4 pb-4 border-b border-gray-100 last:mb-0 last:pb-0 last:border-0">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center shrink-0">
                            @if($item->product->images && $item->product->images->count() > 0)
                                <img src="{{ asset('storage/' . $item->product->images->where('is_primary', true)->first()->path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <i class="ph-fill ph-package text-2xl text-gray-400"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-800 line-clamp-1">{{ $item->product->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price_snapshot, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Footer (Actions) -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex flex-wrap items-center justify-end gap-3">
                @if($order->status == 'menunggu_pembayaran')
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                        @csrf
                        <button type="submit" class="px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg text-sm font-semibold transition">Batalkan Pesanan</button>
                    </form>
                @endif
                <a href="{{ route('orders.show', $order->id) }}" class="px-4 py-2 bg-primary text-white hover:bg-blue-600 rounded-lg text-sm font-bold shadow-sm transition">Lihat Detail</a>
            </div>
        </div>
    @empty
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="ph-fill ph-receipt text-4xl text-gray-300"></i>
            </div>
            <h2 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Pesanan</h2>
            <p class="text-gray-500 mb-6">Anda belum pernah melakukan pemesanan apa pun.</p>
            <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-primary text-white font-bold rounded-lg hover:bg-blue-600 transition shadow-sm">Mulai Belanja</a>
        </div>
    @endforelse
    </div>

    <!-- Konten Pengajuan Jasa -->
    <div id="content-jasa" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-bold border-b border-gray-200">Tgl</th>
                        <th class="p-4 font-bold border-b border-gray-200">Jasa & Penjual</th>
                        <th class="p-4 font-bold border-b border-gray-200">Status</th>
                        <th class="p-4 font-bold border-b border-gray-200">Harga Penawaran</th>
                        <th class="p-4 font-bold border-b border-gray-200 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @if(isset($serviceRequests) && $serviceRequests->count() > 0)
                        @foreach($serviceRequests as $req)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 text-sm text-gray-600">{{ $req->created_at->format('d M Y') }}</td>
                            <td class="p-4">
                                <div class="font-bold text-gray-900 text-sm">{{ $req->product->name }}</div>
                                <div class="text-xs text-gray-500">{{ $req->product->seller->name ?? 'Toko' }}</div>
                            </td>
                            <td class="p-4">
                                @if($req->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded-full border border-yellow-200">Menunggu Penawaran</span>
                                @elseif($req->status === 'quoted')
                                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-full border border-blue-200">Penawaran Diberikan</span>
                                @elseif($req->status === 'accepted' || $req->status === 'completed')
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full border border-green-200">Disetujui</span>
                                @else
                                    <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full border border-red-200">Ditolak</span>
                                @endif
                            </td>
                            <td class="p-4 font-bold text-gray-900 text-sm">
                                {{ $req->quoted_price ? 'Rp' . number_format($req->quoted_price, 0, ',', '.') : '-' }}
                            </td>
                            <td class="p-4 text-center">
                                @if($req->status === 'quoted')
                                    <form action="{{ route('service.request.accept', $req->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-primary text-white font-bold text-xs rounded hover:bg-blue-700 transition shadow-sm">
                                            Setujui & Checkout
                                        </button>
                                    </form>
                                    <div class="mt-1 text-[10px] text-gray-500">
                                        @if($req->seller_notes)
                                            Catatan Penjual: "{{ $req->seller_notes }}"
                                        @endif
                                    </div>
                                @else
                                    <button onclick="openServiceDetailModal('{{ htmlspecialchars(addslashes($req->description)) }}', '{{ htmlspecialchars(addslashes($req->seller_notes ?? '')) }}')" class="px-3 py-1.5 bg-gray-100 text-gray-600 font-bold text-xs rounded hover:bg-gray-200 transition shadow-sm">
                                        Lihat Detail
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                <p class="font-bold text-gray-700 mb-1">Belum Ada Pengajuan Jasa</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Pengajuan Jasa -->
<div id="serviceDetailModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-lg text-gray-900 flex items-center gap-2"><i class="ph-bold ph-info text-primary"></i> Detail Pengajuan Jasa</h3>
            <button type="button" onclick="closeServiceDetailModal()" class="text-gray-400 hover:text-red-500 hover:bg-red-50 w-8 h-8 flex items-center justify-center rounded-lg transition-colors"><i class="ph-bold ph-x"></i></button>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Kebutuhan Anda</label>
                <div id="modal-service-description" class="p-4 bg-gray-50 rounded-xl text-gray-700 text-sm whitespace-pre-wrap border border-gray-200 shadow-inner"></div>
            </div>
            <div id="modal-service-notes-container" class="mb-4 hidden">
                <label class="block text-sm font-bold text-gray-700 mb-2">Catatan Penjual</label>
                <div id="modal-service-notes" class="p-4 bg-blue-50 text-blue-800 rounded-xl text-sm whitespace-pre-wrap border border-blue-100"></div>
            </div>
            <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeServiceDetailModal()" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold hover:bg-gray-200 rounded-xl transition shadow-sm">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openServiceDetailModal(description, notes) {
        document.getElementById('modal-service-description').textContent = description;
        if (notes && notes.trim() !== '') {
            document.getElementById('modal-service-notes').textContent = notes;
            document.getElementById('modal-service-notes-container').classList.remove('hidden');
        } else {
            document.getElementById('modal-service-notes-container').classList.add('hidden');
        }
        document.getElementById('serviceDetailModal').classList.remove('hidden');
    }
    
    function closeServiceDetailModal() {
        document.getElementById('serviceDetailModal').classList.add('hidden');
    }

    function switchOrderTab(tab) {
        document.getElementById('content-produk').classList.toggle('hidden', tab !== 'produk');
        document.getElementById('content-produk').classList.toggle('block', tab === 'produk');
        
        document.getElementById('content-jasa').classList.toggle('hidden', tab !== 'jasa');
        document.getElementById('content-jasa').classList.toggle('block', tab === 'jasa');
        
        if (tab === 'produk') {
            document.getElementById('tab-btn-produk').classList.add('border-primary', 'text-primary', 'font-bold');
            document.getElementById('tab-btn-produk').classList.remove('border-transparent', 'text-gray-500', 'font-medium');
            
            document.getElementById('tab-btn-jasa').classList.remove('border-primary', 'text-primary', 'font-bold');
            document.getElementById('tab-btn-jasa').classList.add('border-transparent', 'text-gray-500', 'font-medium');
        } else {
            document.getElementById('tab-btn-jasa').classList.add('border-primary', 'text-primary', 'font-bold');
            document.getElementById('tab-btn-jasa').classList.remove('border-transparent', 'text-gray-500', 'font-medium');
            
            document.getElementById('tab-btn-produk').classList.remove('border-primary', 'text-primary', 'font-bold');
            document.getElementById('tab-btn-produk').classList.add('border-transparent', 'text-gray-500', 'font-medium');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab') === 'jasa') {
            switchOrderTab('jasa');
        }
    });
</script>
@endsection
