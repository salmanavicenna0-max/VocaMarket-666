@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-100 font-sans">
    
    <!-- Sidebar / Or just a back button for simplicity since this is an admin page -->
    <div class="flex-1 overflow-auto p-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kelola Transaksi</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar pesanan dan moderasi pengembalian dana</p>
            </div>
            <a href="{{ url('/admin/dashboard') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="ph-fill ph-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="ph-fill ph-warning-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-500 font-medium border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4">ID Pesanan</th>
                            <th class="px-6 py-4">Pembeli</th>
                            <th class="px-6 py-4">Penjual</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-mono text-xs uppercase text-gray-900 font-bold">#{{ substr($order->code_order, 0, 12) }}</td>
                            <td class="px-6 py-4">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="px-6 py-4">{{ $order->seller->name ?? '-' }}</td>
                            <td class="px-6 py-4 font-bold text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($order->status == 'menunggu_pembayaran')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold border border-yellow-200">Menunggu Pembayaran</span>
                                @elseif($order->status == 'menunggu_verifikasi')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold border border-blue-200">Menunggu Penjual</span>
                                @elseif($order->status == 'diproses')
                                    <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-bold border border-blue-200">Diproses</span>
                                @elseif($order->status == 'selesai')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold border border-green-200">Selesai</span>
                                @elseif($order->status == 'menunggu_pengembalian')
                                    <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-bold border border-orange-200">Refund (Menunggu Admin)</span>
                                @elseif($order->status == 'menunggu_pengembalian_penjual')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold border border-yellow-200">Disetujui Admin (Menunggu Penjual)</span>
                                @elseif($order->status == 'pengembalian')
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold border border-red-200">Dana Dikembalikan</span>
                                @else
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-bold border border-gray-200">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($order->status == 'menunggu_pengembalian')
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.refund.approve', $order->id) }}" method="POST" onsubmit="return confirm('Setujui refund ini dan teruskan ke penjual untuk konfirmasi?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-green-50 border border-green-200 text-green-700 text-xs font-bold rounded hover:bg-green-100 transition">
                                            Setujui & Teruskan ke Penjual
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.refund.reject', $order->id) }}" method="POST" onsubmit="return confirm('Tolak komplain ini? Pesanan akan dikembalikan ke status Selesai.');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-gray-50 border border-gray-300 text-gray-700 text-xs font-bold rounded hover:bg-gray-100 transition">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Tidak ada data transaksi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
