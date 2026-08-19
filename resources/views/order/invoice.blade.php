<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->code_order }} - VocaMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        accent: '#ffb900',
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #ffffff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .invoice-paper { box-shadow: none !important; border: none !important; max-width: 100% !important; margin: 0 !important; border-radius: 0 !important; }
            @page { margin: 16mm; }
        }
    </style>
</head>
<body class="bg-gray-100 py-8 antialiased">

    <!-- Tombol cetak (hanya di layar, disembunyikan saat print) -->
    <div class="no-print max-w-3xl mx-auto mb-4 flex justify-end">
        <button onclick="window.print()" class="px-5 py-2.5 bg-primary text-white font-bold rounded-lg shadow hover:bg-blue-600 transition flex items-center gap-2">
            <i class="ph-bold ph-printer"></i> Cetak / Unduh PDF
        </button>
    </div>

    <div class="invoice-paper bg-white max-w-3xl mx-auto rounded-xl shadow-sm border border-gray-200 px-10 py-8">

        <!-- Header -->
        <div class="flex justify-between items-start border-b border-gray-200 pb-6 mb-6">
            <div>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo_VocaMarket.png') }}" alt="VocaMarket" class="h-20 w-auto object-contain">
                </div>
                <p class="text-xs text-gray-500 mt-2">Platform E-Commerce Sekolah</p>
                <p class="text-xs text-gray-500 mt-3">JL. PERCOBAAN KM. 17 NO. 65 CILEUNYI, Kec. Cileunyi, Kab. Bandung, Prov. Jawa Barat</p>
                <p class="text-xs text-gray-500">admin@vocamarket.id</p>
            </div>
            <div class="text-right">
                <h2 class="text-3xl font-extrabold text-primary tracking-wide">INVOICE</h2>
                <p class="text-sm font-semibold text-gray-800 mt-2">{{ $order->code_order }}</p>
                <p class="text-xs text-gray-500">Tanggal Transaksi: {{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <!-- Pembeli & Penjual -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Pembeli (Bill To)</p>
                <p class="text-sm font-bold text-gray-900">{{ $order->user->name ?? '-' }}</p>
                @if($order->user && $order->user->email)
                    <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                @endif
            </div>
            <div class="sm:text-right">
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Oleh / Penjual (Platform)</p>
                <p class="text-sm font-bold text-gray-900">{{ $order->seller->name ?? 'VocaMarket' }}</p>
                <p class="text-xs text-gray-500">Status: {{ $order->status_label }}</p>
            </div>
        </div>

        <!-- Daftar Produk -->
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <th class="px-3 py-2 border-b border-gray-200">Produk</th>
                    <th class="px-3 py-2 border-b border-gray-200 text-center">Qty</th>
                    <th class="px-3 py-2 border-b border-gray-200 text-right">Harga Satuan</th>
                    <th class="px-3 py-2 border-b border-gray-200 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                <tr>
                    <td class="px-3 py-3 text-sm font-medium text-gray-800">{{ $item->name_snapshot }}</td>
                    <td class="px-3 py-3 text-sm text-center text-gray-600">{{ $item->quantity }}</td>
                    <td class="px-3 py-3 text-sm text-right text-gray-600">Rp {{ number_format($item->price_snapshot, 0, ',', '.') }}</td>
                    <td class="px-3 py-3 text-sm text-right font-semibold text-gray-800">Rp {{ number_format($item->quantity * $item->price_snapshot, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Rincian Total -->
        <div class="flex justify-end mt-6">
            <div class="w-72 space-y-2">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600">
                    <span>Diskon</span>
                    <span>Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between border-t border-gray-200 pt-2 text-base font-bold text-gray-900">
                    <span>Total Pembayaran</span>
                    <span class="text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        @if($order->note)
        <div class="mt-8 border-t border-gray-200 pt-4">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Catatan Pesanan</p>
            <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $order->note }}</p>
        </div>
        @endif

        @if($order->payments && $order->payments->count() > 0)
        <div class="mt-4 border-t border-gray-200 pt-4">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Riwayat Pembayaran</p>
            @foreach($order->payments as $payment)
            <p class="text-sm text-gray-600">
                {{ $payment->created_at->format('d/m/Y H:i') }} —
                @if($payment->status == 'approved') Diterima
                @elseif($payment->status == 'rejected') Ditolak
                @else Menunggu Verifikasi
                @endif
                @if($payment->payment_proof)
                    · <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="text-primary hover:underline">Lihat Bukti Transfer</a>
                @endif
            </p>
            @endforeach
        </div>
        @endif

        @if($order->refunds && $order->refunds->count() > 0)
        <div class="mt-4 border-t border-gray-200 pt-4">
            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Informasi Pengembalian (Refund)</p>
            @foreach($order->refunds as $refund)
            <p class="text-sm text-gray-600">
                Status: {{ ucfirst(str_replace('_', ' ', $refund->status)) }}
                @if($refund->reason) — {{ $refund->reason }} @endif
            </p>
            @endforeach
        </div>
        @endif

    </div>
</body>
</html>
