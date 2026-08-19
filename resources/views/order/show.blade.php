@extends('layouts.app')
@section('title', 'Detail Pesanan - VocaMarket')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('orders.index') }}" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-gray-200 hover:text-primary transition">
            <i class="ph-bold ph-arrow-left text-lg"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan</h1>
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
        <a href="{{ route('orders.invoice', $order->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white font-bold rounded-lg shadow-sm hover:bg-blue-600 transition">
            <i class="ph-bold ph-printer"></i> Cetak Invoice
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Kolom Kiri: Info Produk & Status -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">ID Pesanan</p>
                        <h2 class="text-xl font-bold text-gray-800 uppercase">#{{ substr($order->id, 0, 8) }}</h2>
                        <p class="text-xs text-gray-500 mt-1">Dipesan pada {{ $order->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-xs text-gray-500 mt-2">No. Invoice: <span class="font-semibold text-gray-800">{{ $order->code_order }}</span></p>
                        @if($order->status == \App\Models\Order::STATUS_DIPROSES)
                            <span class="inline-block mt-2 bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold px-2 py-1 rounded">Fase: Produksi</span>
                        @endif
                        <p class="text-xs text-gray-500 mt-2">Pembeli: <span class="font-semibold text-gray-800">{{ $order->user->name ?? '-' }}</span></p>
                        <p class="text-xs text-gray-500 mt-1">Oleh / Penjual: <span class="font-semibold text-gray-800">{{ $order->seller->name ?? 'VocaMarket' }}</span></p>
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
                                <i class="ph-fill ph-spinner-gap animate-spin text-xl"></i> Sedang Diproses
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
                                <i class="ph-fill ph-image text-xl"></i> Bukti Transfer Terkirim — Silakan Periksa &amp; Konfirmasi
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

                @if($order->status == 'menunggu_pembayaran')
                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-lg flex items-start gap-3">
                        <i class="ph-fill ph-info text-primary mt-0.5"></i>
                        <div>
                            <p class="text-sm text-blue-900 font-medium">Segera selesaikan pembayaran Anda!</p>
                            <p class="text-xs text-blue-700 mt-1">Pesanan akan otomatis dibatalkan jika melewati batas waktu pembayaran.</p>
                        </div>
                    </div>
                @elseif($order->status == \App\Models\Order::STATUS_SELESAI && ($rRejected = $order->refunds->first()) && $rRejected->status === \App\Models\Refund::STATUS_REJECTED)
                    <div class="p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                        <i class="ph-fill ph-x-circle text-red-600 mt-0.5"></i>
                        <div>
                            <p class="text-sm text-red-900 font-medium">Pengajuan refund Anda ditolak oleh Admin.</p>
                            <p class="text-xs text-red-700 mt-1">Alasan: {{ $rRejected->rejection_reason }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Daftar Produk -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-bold text-gray-800">Daftar Produk</h3>
                </div>
                <div class="p-6">
                    @foreach($order->items as $item)
                        <div class="flex flex-col sm:flex-row gap-4 mb-6 pb-6 border-b border-gray-100 last:mb-0 last:pb-0 last:border-0">
                            <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center shrink-0">
                                @if($item->product->images && $item->product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $item->product->images->where('is_primary', true)->first()->path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="ph-fill ph-package text-3xl text-gray-400"></i>
                                @endif
                            </div>
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-lg line-clamp-1">{{ $item->product->name }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">Kategori: {{ $item->product->category }}</p>
                                </div>
                                <div class="flex justify-between items-end mt-4 sm:mt-0">
                                    <p class="text-sm font-medium text-gray-700">{{ $item->quantity }} x Rp {{ number_format($item->price_snapshot, 0, ',', '.') }}</p>
                                    <p class="font-bold text-gray-900">Rp {{ number_format($item->quantity * $item->price_snapshot, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Review Button if Order is Selesai -->
                        @if($order->status == 'selesai')
                            <div class="mt-2 mb-6 last:mb-0 bg-gray-50 p-4 rounded-lg flex justify-between items-center">
                                <span class="text-sm text-gray-600 font-medium">Beri ulasan untuk produk ini</span>
                                <button onclick="document.getElementById('modal-review-{{ $item->product_id }}').classList.remove('hidden')" class="px-4 py-2 bg-accent text-white font-bold rounded-lg text-sm shadow-sm hover:bg-yellow-500 transition">Tulis Ulasan</button>
                            </div>

                            <!-- Modal Review -->
                            <div id="modal-review-{{ $item->product_id }}" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm overflow-y-auto">
                                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                                    <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full">
                                        <form action="{{ route('reviews.store', $item->product_id) }}" method="POST">
                                            @csrf
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Nilai Produk Ini</h3>
                                                        <div class="flex items-center gap-3 mb-4 bg-gray-50 p-3 rounded-lg">
                                                            <div class="w-12 h-12 rounded bg-gray-200 overflow-hidden shrink-0">
                                                                @if($item->product->images && $item->product->images->count() > 0)
                                                                    <img src="{{ asset('storage/' . $item->product->images->where('is_primary', true)->first()->path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                                @endif
                                                            </div>
                                                            <h4 class="font-bold text-gray-800 text-sm">{{ $item->product->name }}</h4>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                                            <select name="rating" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2 border" required>
                                                                <option value="5">5 Bintang (Sangat Bagus)</option>
                                                                <option value="4">4 Bintang (Bagus)</option>
                                                                <option value="3">3 Bintang (Cukup)</option>
                                                                <option value="2">2 Bintang (Kurang)</option>
                                                                <option value="1">1 Bintang (Sangat Kurang)</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Komentar (Opsional)</label>
                                                            <textarea name="comment" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-3 border" placeholder="Ceritakan pengalaman Anda..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-medium text-white hover:bg-blue-600 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">Kirim Ulasan</button>
                                                <button type="button" onclick="document.getElementById('modal-review-{{ $item->product_id }}').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Rincian Pembayaran & Aksi -->
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="font-bold text-gray-800">Rincian Pembayaran</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Total Harga ({{ $order->items->sum('quantity') }} Barang)</span>
                        <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <!-- Assuming no shipping fee for now based on previous implementations -->
                    <div class="border-t border-gray-200 pt-4 flex justify-between items-center">
                        <span class="font-bold text-gray-800">Total Belanja</span>
                        <span class="text-xl font-bold text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 space-y-3">
                    @if($order->status == 'menunggu_pembayaran')
                        <!-- Tombol Bayar / Upload Bukti -->
                        <button onclick="document.getElementById('modal-payment').classList.remove('hidden')" class="w-full py-3 bg-primary text-white font-bold rounded-lg shadow-sm hover:bg-blue-600 transition flex items-center justify-center gap-2">
                            <i class="ph-bold ph-upload-simple text-lg"></i> Upload Bukti Bayar
                        </button>
                        
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                            @csrf
                            <button type="submit" class="w-full py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition text-sm">
                                Batalkan Pesanan
                            </button>
                        </form>
                    @elseif($order->payments && $order->payments->count() > 0)
                        <!-- Riwayat Pembayaran -->
                        <h4 class="font-bold text-gray-800 text-sm mb-2">Riwayat Pembayaran</h4>
                        @foreach($order->payments as $payment)
                            <div class="bg-white p-3 rounded border border-gray-200 text-xs">
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
                    @endif

                    @if(in_array($order->status, ['diproses', 'selesai']))
                        <form action="{{ route('orders.refund', $order->id) }}" method="POST">
                            @csrf
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 mt-3">Catatan Pengajuan Refund <span class="text-red-500">*</span></label>
                            <textarea name="reason" rows="3" required minlength="10" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20" placeholder="Jelaskan alasan pengajuan komplain/pengembalian secara detail..."></textarea>
                            <button type="submit" class="w-full mt-3 py-3 bg-white border border-orange-300 text-orange-600 font-bold rounded-lg hover:bg-orange-50 transition text-sm flex items-center justify-center gap-2">
                                <i class="ph-bold ph-warning-circle text-lg"></i> Ajukan Komplain / Refund
                            </button>
                        </form>
                    @endif

                    @if($order->status == 'menunggu_konfirmasi_pembeli')
                        @php
                            $refund = $order->refunds()->where('status', \App\Models\Refund::STATUS_PROOF_SENT)->first();
                        @endphp
                        @if($refund && $refund->proof_path)
                            <div class="bg-white border border-gray-200 rounded-lg p-3">
                                <p class="font-bold text-gray-800 text-sm mb-2 flex items-center gap-1.5">
                                    <i class="ph-fill ph-seal-check text-green-600"></i> Bukti Transfer Refund dari Admin
                                </p>
                                <a href="{{ asset('storage/' . $refund->proof_path) }}" target="_blank" class="text-primary hover:underline flex items-center gap-1 text-xs mb-1">
                                    <i class="ph-bold ph-image"></i> Lihat Screenshot Bukti Transfer
                                </a>
                                @if($refund->transfer_reference)
                                    <p class="text-xs text-gray-500 mb-1">Referensi Transfer: {{ $refund->transfer_reference }}</p>
                                @endif
                                @if($refund->admin_note)
                                    <p class="text-xs text-gray-500 mb-2">Catatan Admin: {{ $refund->admin_note }}</p>
                                @endif

                                <form action="{{ route('refund.confirm', $order->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa dana refund sudah benar-benar Anda terima?');">
                                    @csrf
                                    <button type="submit" class="w-full mt-2 py-2.5 bg-green-600 text-white font-bold rounded-lg text-sm hover:bg-green-700 transition flex items-center justify-center gap-1.5">
                                        <i class="ph-bold ph-check"></i> Konfirmasi Dana Diterima
                                    </button>
                                </form>

                                <form action="{{ route('refund.dispute', $order->id) }}" method="POST" onsubmit="return confirm('Anda menolak bukti transfer ini? Refund akan dikembalikan ke Admin untuk ditinjau ulang dan belum ditandai selesai.');">
                                    @csrf
                                    <textarea name="reason" rows="2" required minlength="10" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm mt-3 mb-2 focus:outline-none focus:border-red-400" placeholder="Alasan menolak bukti (wajib). Contoh: bukti palsu, nominal tidak sesuai, atau rekening salah..."></textarea>
                                    <button type="submit" class="w-full py-2.5 border border-red-200 text-red-600 font-bold rounded-lg text-sm hover:bg-red-50 transition flex items-center justify-center gap-1.5">
                                        <i class="ph-bold ph-x"></i> Tolak Bukti (Sengketa)
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@if($order->status == 'menunggu_pembayaran')
<!-- Modal Upload Pembayaran -->
<div id="modal-payment" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-md w-full">
            <form action="{{ route('payments.store', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-xl leading-6 font-bold text-gray-900 mb-2">Upload Bukti Pembayaran</h3>
                    <p class="text-sm text-gray-500 mb-6">Silakan transfer sesuai dengan total tagihan dan upload buktinya di bawah ini.</p>
                    
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
                        <p class="text-xs text-blue-800 mb-1">Total Tagihan:</p>
                        <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Bank Tujuan</label>
                        <select name="method" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary p-2 border" required>
                            @foreach($paymentMethods as $pm)
                                <option value="{{ $pm->name }}">{{ $pm->name }} - {{ $pm->account_number }}@if($pm->account_name) (a.n {{ $pm->account_name }})@endif</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Bukti (JPG/PNG)</label>
                        <input type="hidden" name="amount" value="{{ $order->total }}">
                        <input type="file" name="payment_proof" accept="image/*" class="w-full border-gray-300 rounded-lg p-2 border text-sm" required>
                        <p class="text-xs text-gray-500 mt-1">Maksimal ukuran file: 2MB</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                    <button type="button" onclick="document.getElementById('modal-payment').classList.add('hidden')" class="w-full sm:w-auto px-4 py-2 bg-white border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition">Batal</button>
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-primary text-white font-bold rounded-lg hover:bg-blue-600 transition shadow-sm">Kirim Bukti Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
