 @extends('layouts.app')
@section('title', 'Profil Pengguna - VocaMarket')

@section('content')
<div class="container mx-auto px-4 py-8">
    
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-500 mb-6 max-w-6xl mx-auto" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ url('/') }}" class="hover:text-primary transition flex items-center gap-1">
                    <i class="ph-fill ph-house"></i> Beranda
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="ph-bold ph-caret-right text-gray-400 mx-1 text-xs"></i>
                    <span class="text-gray-900 font-medium">Profil Pengguna</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        <!-- Sidebar Kiri -->
        <div class="lg:col-span-1 flex flex-col gap-4">
            
            <!-- Profil Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex flex-col items-center text-center">
                <div class="relative mb-3">
                    <div class="w-20 h-20 rounded-full border-4 border-white shadow-md bg-blue-100 text-primary font-bold flex items-center justify-center text-3xl">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <button class="absolute bottom-0 right-0 bg-primary text-white p-1.5 rounded-full shadow hover:bg-blue-700 transition">
                        <i class="ph-bold ph-pencil-simple text-xs"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">{{ Auth::user()->name }}</h3>
                <p class="text-gray-500 text-sm">{{ Auth::user()->email ?? Auth::user()->nis }}</p>
            </div>

            <!-- Menu Navigasi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <ul class="flex flex-col" id="nav-tabs">
                    <li>
                        <button onclick="switchTab('biodata')" id="nav-biodata" class="w-full text-left flex items-center gap-3 px-5 py-4 text-primary font-medium bg-blue-50 border-l-4 border-primary transition">
                            <i class="ph-fill ph-user text-xl"></i> Biodata Diri
                        </button>
                    </li>
                    <li>
                        <button onclick="switchTab('transaksi')" id="nav-transaksi" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-receipt text-xl"></i> Daftar Transaksi
                        </button>
                    </li>
                    <li>
                        <button onclick="switchTab('ulasan')" id="nav-ulasan" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-star text-xl"></i> Ulasan Saya
                        </button>
                    </li>
                    <li>
                        <button onclick="switchTab('pengaturan')" id="nav-pengaturan" class="w-full text-left flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-gear text-xl"></i> Pengaturan
                        </button>
                    </li>
                    <li class="border-t border-gray-100">
                        <button onclick="switchTab('bukatoko')" id="nav-bukatoko" class="w-full text-left flex items-center gap-3 px-5 py-4 text-green-600 font-bold hover:bg-green-50 transition border-l-4 border-transparent">
                            <i class="ph-bold ph-storefront text-xl"></i> Buka Toko
                        </button>
                    </li>
                    <li class="border-t border-gray-100">
                        <a href="{{ url('/') }}" class="w-full text-left flex items-center gap-3 px-5 py-4 text-red-500 font-medium hover:bg-red-50 transition border-l-4 border-transparent">
                            <i class="ph-bold ph-sign-out text-xl"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
            
        </div>

        <!-- Konten Kanan -->
        <div class="lg:col-span-3">
            
            <!-- TAB: Biodata Diri -->
            <div id="tab-biodata" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content block">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Biodata Diri</h2>
                    <p class="text-gray-500 text-sm mt-1">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex flex-col gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Lengkap</label>
                                <input type="text" value="Budi Santoso" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Tanggal Lahir</label>
                                <div class="flex gap-2">
                                    <select class="border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:border-primary flex-1"><option>15</option></select>
                                    <select class="border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:border-primary flex-1"><option>Agustus</option></select>
                                    <select class="border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:border-primary flex-1"><option>2005</option></select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin</label>
                                <div class="flex items-center gap-6">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="gender" class="w-4 h-4 text-primary focus:ring-primary" checked>
                                        <span class="text-gray-700 text-sm">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="gender" class="w-4 h-4 text-primary focus:ring-primary">
                                        <span class="text-gray-700 text-sm">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5 flex justify-between items-center">
                                    Email
                                    <a href="#" class="text-primary text-xs hover:underline">Ubah</a>
                                </label>
                                <div class="flex items-center gap-3">
                                    <input type="email" value="budi.santoso@email.com" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 text-gray-500 cursor-not-allowed" disabled>
                                    <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded border border-green-200 shrink-0">Terverifikasi</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5 flex justify-between items-center">
                                    Nomor Telepon
                                    <a href="#" class="text-primary text-xs hover:underline">Ubah</a>
                                </label>
                                <div class="flex items-center gap-3">
                                    <div class="relative w-full">
                                        <span class="absolute left-4 top-2.5 text-gray-500 font-medium">+62</span>
                                        <input type="tel" value="81234567890" class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-2.5 bg-gray-50 text-gray-500 cursor-not-allowed" disabled>
                                    </div>
                                    <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded border border-green-200 shrink-0">Terverifikasi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <button class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-sm transition">Simpan Perubahan</button>
                    </div>
                </div>
            </div>

            <!-- TAB: Daftar Transaksi -->
            <div id="tab-transaksi" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Daftar Transaksi</h2>
                    <p class="text-gray-500 text-sm mt-1">Pantau status pesanan dan riwayat belanja Anda</p>
                </div>
                
                <!-- Horizontal Tabs for Status -->
                <div class="flex overflow-x-auto border-b border-gray-200 whitespace-nowrap">
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-primary text-primary font-bold text-sm">All</button>
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Belum Bayar</button>
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Dikemas</button>
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Dikirim</button>
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Selesai</button>
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Dibatalkan</button>
                    <button class="flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Pengembalian</button>
                </div>
                
                <div class="p-6 flex flex-col gap-4">
                    <!-- Transaksi 1 -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden hover:border-primary transition">
                        <div class="bg-gray-50 p-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-storefront text-gray-500 text-xl"></i>
                                <span class="font-bold text-gray-900">Toko Seragam Esemka</span>
                            </div>
                            <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded border border-yellow-200">Sedang Dikemas</span>
                        </div>
                        <div class="p-4 flex gap-4">
                            <img src="https://picsum.photos/seed/seragam/150/150" class="w-20 h-20 rounded-lg object-cover border border-gray-100">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">Seragam SD Merah Putih Lengan Pendek Berkualitas</h4>
                                <p class="text-xs text-gray-500 mt-1">1 barang x Rp55.000</p>
                            </div>
                            <div class="text-right flex flex-col justify-between">
                                <div>
                                    <p class="text-xs text-gray-500">Total Belanja</p>
                                    <p class="font-bold text-primary text-lg">Rp55.000</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border-t border-gray-100 flex justify-end gap-2">
                            <button class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition">Lacak Pesanan</button>
                            <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">Hubungi Penjual</button>
                        </div>
                    </div>

                    <!-- Transaksi 2 -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden hover:border-primary transition">
                        <div class="bg-gray-50 p-4 border-b border-gray-200 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-storefront text-gray-500 text-xl"></i>
                                <span class="font-bold text-gray-900">Studio Animasi 666</span>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded border border-green-200">Selesai</span>
                        </div>
                        <div class="p-4 flex gap-4">
                            <img src="https://picsum.photos/seed/desain/150/150" class="w-20 h-20 rounded-lg object-cover border border-gray-100">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900">Jasa Pembuatan Logo Bisnis & E-Sports Profesional</h4>
                                <p class="text-xs text-gray-500 mt-1">1 barang x Rp150.000</p>
                            </div>
                            <div class="text-right flex flex-col justify-between">
                                <div>
                                    <p class="text-xs text-gray-500">Total Belanja</p>
                                    <p class="font-bold text-primary text-lg">Rp150.000</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border-t border-gray-100 flex justify-end gap-2">
                            <button class="px-4 py-2 bg-white border border-primary text-primary rounded-lg text-sm font-bold hover:bg-blue-50 transition">Beli Lagi</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: Ulasan Saya -->
            <div id="tab-ulasan" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Ulasan Saya</h2>
                    <p class="text-gray-500 text-sm mt-1">Berikan ulasan untuk produk yang telah Anda beli</p>
                </div>
                
                <div class="p-6 flex flex-col gap-4">
                    <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl flex justify-between items-center">
                        <div class="flex gap-4">
                            <img src="https://picsum.photos/seed/desain/150/150" class="w-16 h-16 rounded-lg object-cover border border-gray-100">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Jasa Pembuatan Logo Bisnis & E-Sports Profesional</h4>
                                <p class="text-xs text-gray-500 mt-1">Studio Animasi 666</p>
                                <div class="flex text-yellow-400 mt-2 text-sm">
                                    <i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i>
                                </div>
                            </div>
                        </div>
                        <button class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">Tulis Ulasan</button>
                    </div>
                </div>
            </div>

            <!-- TAB: Pengaturan -->
            <div id="tab-pengaturan" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Pengaturan Akun</h2>
                    <p class="text-gray-500 text-sm mt-1">Atur preferensi notifikasi dan keamanan akun Anda</p>
                </div>
                
                <div class="p-6 flex flex-col gap-6">
                    <!-- Ubah Password -->
                    <div>
                        <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Ubah Kata Sandi</h3>
                        <div class="flex flex-col gap-4 max-w-md">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Kata Sandi Saat Ini</label>
                                <input type="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Kata Sandi Baru</label>
                                <input type="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                            </div>
                            <button class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg w-fit mt-2 transition">Perbarui Kata Sandi</button>
                        </div>
                    </div>
                    
                    <!-- Notifikasi -->
                    <div class="mt-4">
                        <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Notifikasi</h3>
                        <div class="flex flex-col gap-3">
                            <label class="flex items-center justify-between cursor-pointer">
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">Promo & Diskon</p>
                                    <p class="text-xs text-gray-500">Dapatkan info terbaru tentang diskon di VocaMarket</p>
                                </div>
                                <input type="checkbox" class="w-5 h-5 text-primary rounded focus:ring-primary" checked>
                            </label>
                            <label class="flex items-center justify-between cursor-pointer">
                                <div>
                                    <p class="font-bold text-gray-800 text-sm">Pembaruan Pesanan</p>
                                    <p class="text-xs text-gray-500">Pemberitahuan setiap kali status pesanan Anda berubah</p>
                                </div>
                                <input type="checkbox" class="w-5 h-5 text-primary rounded focus:ring-primary" checked>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB: Buka Toko -->
            <div id="tab-bukatoko" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200 bg-green-50 rounded-t-xl">
                    <h2 class="text-xl font-bold text-green-800 flex items-center gap-2">
                        <i class="ph-fill ph-storefront"></i> Formulir Buka Toko
                    </h2>
                    <p class="text-green-700 text-sm mt-1">Verifikasi identitas siswa Anda untuk mulai berjualan di VocaMarket</p>
                </div>
                
                <div class="p-6 flex flex-col gap-6">
                    @if(Auth::user()->seller_status === 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-lg text-center flex flex-col items-center justify-center">
                            <i class="ph-fill ph-clock text-4xl text-yellow-500 mb-3"></i>
                            <h3 class="font-bold text-yellow-800 text-lg">Permintaan Sedang Diproses</h3>
                            <p class="text-yellow-700 text-sm mt-2 max-w-md">Pengajuan buka toko Anda sedang diverifikasi oleh Administrator. Mohon tunggu 1x24 jam kerja. Kami akan memberi tahu Anda jika toko sudah disetujui.</p>
                        </div>
                    @elseif(Auth::user()->seller_status === 'approved')
                        <div class="bg-green-50 border border-green-200 p-6 rounded-lg text-center flex flex-col items-center justify-center">
                            <i class="ph-fill ph-check-circle text-4xl text-green-500 mb-3"></i>
                            <h3 class="font-bold text-green-800 text-lg">Toko Anda Sudah Aktif!</h3>
                            <p class="text-green-700 text-sm mt-2 mb-4">Selamat! Pengajuan toko Anda telah disetujui. Anda sekarang dapat mulai mengelola produk dan berjualan.</p>
                            <a href="{{ url('/seller/dashboard') }}" class="px-6 py-2 bg-green-600 text-white font-bold rounded-lg shadow-sm hover:bg-green-700 transition">Ke Dashboard Penjual</a>
                        </div>
                    @else
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg flex gap-3 text-sm text-blue-800">
                            <i class="ph-fill ph-info text-xl shrink-0"></i>
                            <p>Pastikan data Anda sesuai. Proses verifikasi biasanya memakan waktu 1x24 jam kerja setelah Anda menekan tombol ajukan.</p>
                        </div>

                        <form method="POST" action="{{ route('user.request_seller') }}" class="flex flex-col gap-4 max-w-lg">
                            @csrf
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Akun <span class="text-red-500">*</span></label>
                                <input type="text" value="{{ Auth::user()->name }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-gray-500 cursor-not-allowed" disabled>
                            </div>
                            
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg w-full mt-4 transition shadow-sm flex items-center justify-center gap-2">
                                <i class="ph-bold ph-paper-plane-tilt"></i> Ajukan Verifikasi Toko Sekarang
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(el => {
            el.classList.add('hidden');
            el.classList.remove('block');
        });
        
        // Remove active state from all nav buttons
        document.querySelectorAll('#nav-tabs button').forEach(el => {
            el.classList.remove('text-primary', 'bg-blue-50', 'border-primary');
            el.classList.add('text-gray-600', 'border-transparent');
        });
        
        // Show target tab content
        document.getElementById('tab-' + tabId).classList.remove('hidden');
        document.getElementById('tab-' + tabId).classList.add('block');
        
        // Set active state on clicked nav button
        const activeNav = document.getElementById('nav-' + tabId);
        activeNav.classList.remove('text-gray-600', 'border-transparent');
        activeNav.classList.add('text-primary', 'bg-blue-50', 'border-primary');
    }
</script>
@endsection
