@extends('layouts.app')
@section('title', 'Detail Transaksi - Admin VocaMarket')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <div class="flex items-center gap-3 mb-6">
        @php
            $prev = url()->previous();
            $back = ($prev && $prev !== url()->current() && $prev !== url('/')) ? $prev : route('seller.dashboard');
        @endphp
        <a href="{{ $back }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 hover:text-primary transition">
            <i class="ph-bold ph-arrow-left text-lg"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi</h1>
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

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white font-bold rounded-lg shadow-sm hover:bg-blue-600 transition">
            <i class="ph-bold ph-printer"></i> Cetak Invoice
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Invoice & Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">No. Invoice</p>
                        <h2 class="text-xl font-bold text-gray-800">{{ $order->code_order }}</h2>
                        <p class="text-xs text-gray-500 mt-1">ID Pesanan: #{{ substr($order->id, 0, 8) }}</p>
                        <p class="text-xs text-gray-500 mt-1">Tanggal Transaksi: {{ $order->created_at->format('d M Y, H:i') }}</p>
                        @if($order->status == \App\Models\Order::STATUS_DIPROSES)
                            <span class="inline-block mt-2 bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold px-2 py-1 rounded">Fase: Produksi</span>
                        @endif
                    </div>
                    <div>
                        @if($order->status == \App\Models\Order::STATUS_SELESAI && ($latestRefund = $order->refunds->first()) && $latestRefund->status === \App\Models\Refund::STATUS_REJECTED)
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                                <i class="ph-fill ph-x-circle text-xl"></i> Refund Dibatalkan — Pesanan Ditutup
                            </div>
                        @elseif($order->status == 'menunggu_pembayaran')
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                                <i class="ph-fill ph-clock text-xl"></i> Menunggu Pembayaran
                            </div>
                        @elseif($order->status == 'diproses')
                            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                                <i class="ph-fill ph-spinner-gap animate-spin text-xl"></i> Sedang Diproses (Produksi)
                            </div>
                        @elseif($order->status == 'menunggu_verifikasi')
                            <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                                <i class="ph-fill ph-clock text-xl"></i> Menunggu Konfirmasi Penjual
                            </div>
                        @elseif($order->status == 'selesai')
                            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                                <i class="ph-fill ph-check-circle text-xl"></i> Selesai
                            </div>
                        @elseif($order->status == 'menunggu_pengembalian')
                            @php $pendingRefund = $order->refunds->first(); @endphp
                            @if($pendingRefund && $pendingRefund->status === \App\Models\Refund::STATUS_DISPUTED)
                                <div class="bg-orange-50 border border-orange-200 text-orange-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                                    <i class="ph-fill ph-shield-warning text-xl"></i> Sengketa Bukti — Admin Memeriksa Ulang
                                </div>
                            @else
                                <div class="bg-orange-50 border border-orange-200 text-orange-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                                    <i class="ph-fill ph-warning-circle text-xl"></i> Komplain Sedang Ditinjau Admin
                                </div>
                            @endif
                        @elseif($order->status == 'menunggu_konfirmasi_pembeli')
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                                <i class="ph-fill ph-image text-xl"></i> Bukti Transfer Terkirim — Menunggu Konfirmasi Pembeli
                            </div>
                        @elseif($order->status == 'pengembalian')
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                                <i class="ph-fill ph-arrow-counter-clockwise text-xl"></i> Dana Dikembalikan
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2">
                                <i class="ph-fill ph-x-circle text-xl"></i> Dibatalkan
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info Pembeli & Penjual -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Pembeli (User)</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $order->user->name ?? '-' }}</p>
                        @if($order->user && $order->user->email)
                            <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Oleh / Penjual (Platform)</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $order->seller->name ?? 'VocaMarket' }}</p>
                    </div>
                    @if($order->note)
                        <div class="sm:col-span-2">
                            <p class="text-xs text-gray-500 mb-1">Catatan Pesanan</p>
                            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $order->note }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Daftar Produk -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-bold text-gray-800">Membeli Apa (Daftar Produk)</h3>
                </div>
                <div class="p-6">
                    @foreach($order->items as $item)
                        <div class="flex flex-col sm:flex-row gap-4 mb-6 pb-6 border-b border-gray-100 last:mb-0 last:pb-0 last:border-0">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center shrink-0">
                                @if($item->product && $item->product->images && $item->product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $item->product->images->where('is_primary', true)->first()->path) }}" alt="{{ $item->name_snapshot }}" class="w-full h-full object-cover">
                                @else
                                    <i class="ph-fill ph-package text-3xl text-gray-400"></i>
                                @endif
                            </div>
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg line-clamp-1">{{ $item->name_snapshot }}</h4>
                                    @if($item->product && $item->product->category)
                                        <p class="text-sm text-gray-500 mt-1">Kategori: {{ $item->product->category }}</p>
                                    @endif
                                </div>
                                <div class="flex justify-between items-end mt-4 sm:mt-0">
                                    <p class="text-sm font-medium text-gray-700">{{ $item->quantity }} x Rp {{ number_format($item->price_snapshot, 0, ',', '.') }}</p>
                                    <p class="font-bold text-gray-900">Rp {{ number_format($item->quantity * $item->price_snapshot, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Riwayat Pembayaran & Refund -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-bold text-gray-800">Riwayat Pembayaran & Pengembalian</h3>
                </div>
                <div class="p-6 space-y-4">
                    @if($order->payments && $order->payments->count() > 0)
                        @foreach($order->payments as $payment)
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-sm">
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-500">{{ $payment->created_at->format('d/m/Y H:i') }}</span>
                                    @if($payment->status == 'approved')
                                        <span class="text-green-600 font-bold">Diterima</span>
                                    @elseif($payment->status == 'rejected')
                                        <span class="text-red-600 font-bold">Ditolak</span>
                                    @else
                                        <span class="text-yellow-600 font-bold">Menunggu</span>
                                    @endif
                                </div>
                                @if($payment->payment_proof)
                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="text-primary hover:underline flex items-center gap-1">
                                        <i class="ph-bold ph-image"></i> Lihat Bukti Transfer
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500">Belum ada bukti pembayaran diunggah.</p>
                    @endif

                    @if($order->refunds && $order->refunds->count() > 0)
                        @foreach($order->refunds as $refund)
                            <div class="bg-orange-50 p-4 rounded-lg border border-orange-200 text-sm">
                                <p class="font-bold text-orange-800 mb-1">Pengajuan Refund ({{ ucfirst(str_replace('_', ' ', $refund->status)) }})</p>
                                @if($refund->reason)
                                    <p class="text-gray-700 mb-1"><span class="font-semibold">Alasan:</span> {{ $refund->reason }}</p>
                                @endif
                                @if($refund->dispute_reason)
                                    <p class="text-gray-700 mb-1"><span class="font-semibold">Sengketa:</span> {{ $refund->dispute_reason }}</p>
                                @endif
                                @if($refund->proof_path)
                                    <a href="{{ asset('storage/' . $refund->proof_path) }}" target="_blank" class="text-primary hover:underline flex items-center gap-1">
                                        <i class="ph-bold ph-image"></i> Lihat Bukti Transfer Refund
                                    </a>
                                @endif
                                @if($refund->transfer_reference)
                                    <p class="text-xs text-gray-500 mt-1">Referensi Transfer: {{ $refund->transfer_reference }}</p>
                                @endif
                                @if($refund->admin_note)
                                    <p class="text-xs text-gray-500 mt-1">Catatan Admin: {{ $refund->admin_note }}</p>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Rincian Pembayaran -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-bold text-gray-800">Rincian Pembayaran</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Diskon</span>
                        <span>Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
                        <span class="font-bold text-gray-800">Total Belanja</span>
                        <span class="text-xl font-bold text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-2 text-xs text-gray-500">
                        Total Barang: {{ $order->items->sum('quantity') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
