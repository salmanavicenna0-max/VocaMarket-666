@extends('layouts.app')
@section('title', 'Checkout - VocaMarket')
@section('content')

<div class="container mx-auto px-4 py-8">
    <form action="{{ route('checkout.store') }}" method="POST" class="flex flex-col gap-6 max-w-3xl mx-auto">
        @csrf
        <!-- Breadcrumb & Header -->
        <div>
            <!-- Breadcrumb -->
            <nav class="flex text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ url('/') }}" class="hover:text-primary transition flex items-center gap-1">
                            <i class="ph-fill ph-house"></i> Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="ph-bold ph-caret-right text-gray-400 mx-1 text-xs"></i>
                            <a href="{{ url('/cart') }}" class="hover:text-primary transition">Keranjang</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="ph-bold ph-caret-right text-gray-400 mx-1 text-xs"></i>
                            <span class="text-gray-900 font-medium">Checkout</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="flex items-center gap-3">
                <i class="ph-bold ph-receipt text-3xl text-primary"></i>
                <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
            </div>
        </div>

        <!-- 2. Pesanan Anda -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <h3 class="font-bold text-gray-900 flex items-center gap-2">
                    <i class="ph-fill ph-package text-primary text-xl"></i> Pesanan Anda
                </h3>
            </div>
            
            @foreach($groupedItems as $sellerId => $items)
                @php 
                    $seller = $items->first()->product->seller; 
                    $sellerName = ($seller && $seller->profile && $seller->profile->nama_toko) ? $seller->profile->nama_toko : ($seller ? ('Toko ' . $seller->name) : 'Toko VocaMarket');
                @endphp
                <!-- Toko -->
                <div class="p-5 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                    <div class="flex items-center gap-2 mb-4">
                        <i class="ph-fill ph-storefront text-gray-700"></i>
                        <span class="font-bold text-gray-900">{{ $sellerName }}</span>
                    </div>
                    
                    @foreach($items as $item)
                        <div class="flex gap-4 mb-4 last:mb-0">
                            <img src="{{ $item->product->thumbnail }}" alt="Produk" class="w-16 h-16 rounded-lg object-cover border border-gray-100 shrink-0">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-800">{{ $item->product->name }}</h4>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="font-bold text-primary">Rp{{ number_format($item->product->price, 0, ',', '.') }}</span>
                                    <span class="text-sm text-gray-600">x{{ $item->quantity }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="mt-4 pt-4 border-t border-dashed border-gray-200">
                        <div class="flex items-center justify-between gap-4">
                            <div class="w-full md:w-1/2">
                                <label class="text-xs font-bold text-gray-700 mb-1 block">Pesan untuk Penjual:</label>
                                <input type="text" name="note" placeholder="Silakan tinggalkan pesan..." class="w-full text-sm border border-gray-300 rounded-lg p-2 outline-none focus:border-primary">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- 3. Metode Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="font-bold text-gray-900 flex items-center gap-2 mb-4">
                <i class="ph-fill ph-credit-card text-primary text-xl"></i> Metode Pembayaran
            </h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                 <label class="payment-method-label border border-primary bg-blue-50 p-3 rounded-lg flex flex-col items-center justify-center gap-2 cursor-pointer transition relative" onclick="selectPayment(this)">
                    <input type="radio" name="payment" value="transfer" class="absolute top-2 right-2" checked>
                    <i class="payment-icon ph-fill ph-bank text-3xl text-primary"></i>
                    <span class="payment-text text-xs font-bold text-center text-primary">Transfer Bank/Qris</span>
                </label>
            </div>
        </div>

        <!-- 4. Ringkasan Belanja -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-8">
            <h3 class="font-bold text-gray-900 mb-4 pb-4 border-b border-gray-100">Ringkasan Belanja</h3>
            
            <div class="flex flex-col gap-3 text-sm text-gray-600 mb-4 pb-4 border-b border-gray-100">
                <div class="flex justify-between items-center">
                    <span>Total Harga ({{ $cartItems->count() }} barang)</span>
                    <span class="text-gray-900 font-medium">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <div class="flex flex-col gap-1 mb-6">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-gray-900 text-base">Total Tagihan</span>
                    <span class="font-bold text-primary text-xl">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <button type="submit" class="w-full py-4 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm transition text-lg">
                Buat Pesanan
            </button>
            <p class="text-xs text-gray-500 text-center mt-4">
                Dengan membuat pesanan, Anda menyetujui <a href="#" class="text-primary hover:underline">Syarat & Ketentuan VocaMarket</a>
            </p>
        </div>

    </form>
</div>

<script>
function selectPayment(selectedLabel) {
    // Reset all labels
    document.querySelectorAll('.payment-method-label').forEach(label => {
        label.classList.remove('border-primary', 'bg-blue-50');
        label.classList.add('border-gray-200');
        
        const icon = label.querySelector('.payment-icon');
        icon.classList.remove('text-primary');
        icon.classList.add('text-gray-500');
        
        const text = label.querySelector('.payment-text');
        text.classList.remove('text-primary');
        text.classList.add('text-gray-500');
    });

    // Set active styles to selected label
    selectedLabel.classList.add('border-primary', 'bg-blue-50');
    selectedLabel.classList.remove('border-gray-200');
    
    const selectedIcon = selectedLabel.querySelector('.payment-icon');
    selectedIcon.classList.add('text-primary');
    selectedIcon.classList.remove('text-gray-500');
    
    const selectedText = selectedLabel.querySelector('.payment-text');
    selectedText.classList.add('text-primary');
    selectedText.classList.remove('text-gray-500');
}
</script>
@endsection
