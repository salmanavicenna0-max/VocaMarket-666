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
@endsection
