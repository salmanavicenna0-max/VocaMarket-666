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
                    <div class="w-20 h-20 rounded-full border-4 border-white shadow-md bg-blue-100 text-primary font-bold flex items-center justify-center text-3xl overflow-hidden">
                        @if($profile && ($profile->photo || $profile->foto))
                            <img src="{{ asset('storage/' . ($profile->photo ?? $profile->foto)) }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        @endif
                    </div>
                    <form id="avatar-form" action="{{ route('user.profile.photo') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="photo" id="avatar-input" class="hidden" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
                        <button type="button" onclick="document.getElementById('avatar-input').click()" class="absolute bottom-0 right-0 bg-primary text-white p-1.5 rounded-full shadow hover:bg-blue-700 transition" title="Ubah Foto Profil">
                            <i class="ph-bold ph-pencil-simple text-xs"></i>
                        </button>
                    </form>
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
                    @if(Auth::user()->isSiswa() || Auth::user()->isSeller() || Auth::user()->seller_status === 'approved' || Auth::user()->role === 'siswa' || Auth::user()->role === 'seller')
                    <li class="border-t border-gray-100">
                        <button onclick="switchTab('konfigurasitoko')" id="nav-konfigurasitoko" class="w-full text-left flex items-center gap-3 px-5 py-4 text-blue-600 font-bold hover:bg-blue-50 transition border-l-4 border-transparent">
                            <i class="ph-bold ph-sliders text-xl"></i> Konfigurasi Toko
                        </button>
                    </li>
                    <li class="border-t border-gray-100">
                        <button onclick="switchTab('bukatoko')" id="nav-bukatoko" class="w-full text-left flex items-center gap-3 px-5 py-4 text-green-600 font-bold hover:bg-green-50 transition border-l-4 border-transparent">
                            <i class="ph-bold ph-storefront text-xl"></i> Status Toko
                        </button>
                    </li>
                    @endif
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
            
                        @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- TAB: Biodata Diri -->
            <div id="tab-biodata" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content block">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Biodata Diri</h2>
                    <p class="text-gray-500 text-sm mt-1">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
                </div>
                <form action="{{ route('user.profile.update') }}" method="POST" class="p-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex flex-col gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Tanggal Lahir</label>
                                <div class="flex gap-2">
                                    @php
                                        $tgl = $bln = $thn = '';
                                        if ($profile && $profile->tanggal_lahir) {
                                            $parts = explode('-', $profile->tanggal_lahir); // YYYY-MM-DD
                                            if (count($parts) == 3) {
                                                $thn = $parts[0];
                                                $m = (int)$parts[1];
                                                $tgl = (int)$parts[2];
                                                $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                                                $bln = $months[$m] ?? '';
                                            }
                                        }
                                    @endphp
                                    <select name="tanggal_lahir_tgl" class="border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:border-primary flex-1">
                                        <option value="">Tgl</option>
                                        @for($i=1; $i<=31; $i++)
                                            <option value="{{ $i }}" {{ $tgl == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select name="tanggal_lahir_bln" class="border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:border-primary flex-1">
                                        <option value="">Bulan</option>
                                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m)
                                            <option value="{{ $m }}" {{ $bln == $m ? 'selected' : '' }}>{{ $m }}</option>
                                        @endforeach
                                    </select>
                                    <select name="tanggal_lahir_thn" class="border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:border-primary flex-1">
                                        <option value="">Tahun</option>
                                        @for($i=date('Y'); $i>=1970; $i--)
                                            <option value="{{ $i }}" {{ $thn == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin</label>
                                <div class="flex items-center gap-6">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="Laki-laki" class="w-4 h-4 text-primary focus:ring-primary" {{ ($profile && $profile->jenis_kelamin == 'Laki-laki') ? 'checked' : '' }}>
                                        <span class="text-gray-700 text-sm">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="jenis_kelamin" value="Perempuan" class="w-4 h-4 text-primary focus:ring-primary" {{ ($profile && $profile->jenis_kelamin == 'Perempuan') ? 'checked' : '' }}>
                                        <span class="text-gray-700 text-sm">Perempuan</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5 flex justify-between items-center">
                                    Email / NIS
                                </label>
                                <div class="flex items-center gap-3">
                                    <input type="text" value="{{ $user->email ?? $user->nis }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 bg-gray-50 text-gray-500 cursor-not-allowed" disabled>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5 flex justify-between items-center">
                                    Nomor Telepon
                                </label>
                                <div class="flex items-center gap-3">
                                    <div class="relative w-full">
                                        <input type="tel" name="no_telp" value="{{ old('no_telp', $profile->no_telp ?? '') }}" placeholder="Contoh: 08123456789" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary transition">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-sm transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- TAB: Daftar Transaksi -->
            <div id="tab-transaksi" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Daftar Transaksi</h2>
                    <p class="text-gray-500 text-sm mt-1">Pantau status pesanan dan riwayat belanja Anda</p>
                </div>
                
                <!-- Horizontal Tabs for Status -->
                <div class="flex overflow-x-auto border-b border-gray-200 whitespace-nowrap">
                    <button onclick="filterPesananUser('Semua', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-primary text-primary font-bold text-sm">Semua</button>
                    <button onclick="filterPesananUser('Menunggu Pembayaran', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Belum Bayar</button>
                    <button onclick="filterPesananUser('Menunggu Verifikasi', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Menunggu Penjual</button>
                    <button onclick="filterPesananUser('Diproses', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Diproses</button>
                    <button onclick="filterPesananUser('Selesai', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Selesai</button>
                    <button onclick="filterPesananUser('Dibatalkan', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Dibatalkan</button>
                    <button onclick="filterPesananUser('Pengembalian', this)" class="order-tab-btn flex-1 py-3 px-4 text-center border-b-2 border-transparent text-gray-600 hover:text-primary font-medium text-sm transition">Pengembalian</button>
                </div>
                
                <div class="p-6 flex flex-col gap-4">
                    @forelse($orders as $order)
                        <div class="pesanan-user-item bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition" data-status="{{ $order->status_label }}">
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
                                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded">{{ $order->status_label }}</span>
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

                            <!-- Action -->
                            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                                <a href="{{ route('orders.show', $order->id) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition">
                                    Lihat Detail Pesanan
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <i class="ph-fill ph-receipt text-6xl text-gray-300 mb-3"></i>
                            <h3 class="font-bold text-gray-700">Belum ada transaksi</h3>
                            <p class="text-sm text-gray-500 mt-1">Anda belum pernah melakukan transaksi apa pun.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- TAB: Ulasan Saya -->
            <div id="tab-ulasan" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Ulasan Saya</h2>
                    <p class="text-gray-500 text-sm mt-1">Daftar ulasan yang pernah Anda berikan</p>
                </div>
                
                <div class="p-6 flex flex-col gap-4">
                    @forelse($reviews as $review)
                        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-xl flex justify-between items-center">
                            <div class="flex gap-4">
                                <img src="{{ $review->product->thumbnail ? Storage::url($review->product->thumbnail) : 'https://picsum.photos/seed/'.$review->product->id.'/150/150' }}" class="w-16 h-16 rounded-lg object-cover border border-gray-100">
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm">{{ $review->product->title }}</h4>
                                    <div class="flex text-yellow-400 mt-2 text-sm">
                                        @for($i=1; $i<=5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="ph-fill ph-star"></i>
                                            @else
                                                <i class="ph ph-star text-gray-300"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-700 mt-1">{{ $review->comment }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <i class="ph-fill ph-star text-6xl text-gray-300 mb-3"></i>
                            <h3 class="font-bold text-gray-700">Belum ada ulasan</h3>
                            <p class="text-sm text-gray-500 mt-1">Anda belum pernah memberikan ulasan.</p>
                        </div>
                    @endforelse
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
                    <form action="{{ route('user.password.update') }}" method="POST">
                        @csrf
                        <h3 class="font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Ubah Kata Sandi</h3>
                        <div class="flex flex-col gap-4 max-w-md">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Kata Sandi Baru</label>
                                <input type="password" name="new_password" required minlength="6" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="new_password_confirmation" required minlength="6" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-primary">
                            </div>
                            <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg w-fit mt-2 transition">Perbarui Kata Sandi</button>
                        </div>
                    </form>
                </div>

            <!-- TAB: Konfigurasi Toko (Khusus Siswa/Penjual) -->
            @if(Auth::user()->isSiswa() || Auth::user()->isSeller() || Auth::user()->seller_status === 'approved' || Auth::user()->role === 'siswa' || Auth::user()->role === 'seller')
            <div id="tab-konfigurasitoko" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200 bg-blue-50/50 rounded-t-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <i class="ph-fill ph-sliders text-primary"></i> Konfigurasi Profil Toko
                        </h2>
                        <p class="text-gray-500 text-sm mt-1">Atur informasi toko Anda agar terlihat menarik bagi calon pembeli</p>
                    </div>
                    <a href="{{ route('seller.profile', Auth::user()->id) }}" target="_blank" class="px-4 py-2 bg-white text-primary font-bold border border-primary rounded-lg shadow-sm hover:bg-blue-50 transition text-sm flex items-center gap-1.5 shrink-0">
                        <i class="ph-bold ph-arrow-square-out"></i> Lihat Halaman Toko Saya
                    </a>
                </div>
                
                <form action="{{ route('user.store.update') }}" method="POST" class="p-6 flex flex-col gap-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Toko</label>
                        <input type="text" name="nama_toko" value="{{ old('nama_toko', $profile->nama_toko ?? ('Toko ' . $user->name)) }}" placeholder="Masukkan nama toko Anda..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition" required>
                        <p class="text-xs text-gray-500 mt-1">Nama ini akan menjadi judul utama di halaman profil toko Anda.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Tentang Penjual / Deskripsi Toko</label>
                        <textarea name="deskripsi_toko" rows="4" placeholder="Tuliskan deskripsi singkat mengenai produk, jasa, atau toko Anda..." class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">{{ old('deskripsi_toko', $profile->deskripsi_toko) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Deskripsi ini akan ditampilkan pada bagian "Tentang Penjual" di halaman profil toko.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Lokasi Toko / Alamat Sekolah</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $profile->alamat ?? 'SMK Bakti Nusantara 666') }}" placeholder="Contoh: SMK Bakti Nusantara 666" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1.5">Nomor HP / WhatsApp Toko</label>
                            <input type="text" name="no_telp" value="{{ old('no_telp', $profile->no_telp) }}" placeholder="Contoh: 085156699111" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-sm flex items-center gap-2">
                            <i class="ph-bold ph-floppy-disk"></i> Simpan Konfigurasi Toko
                        </button>
                    </div>
                </form>
            </div>
            @endif

            <!-- TAB: Buka Toko (Hanya Siswa) -->
            @if(Auth::user()->isSiswa() || Auth::user()->isSeller() || Auth::user()->seller_status === 'approved' || Auth::user()->role === 'siswa' || Auth::user()->role === 'seller')
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
            @endif
            
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
        if (activeNav) {
            activeNav.classList.remove('text-gray-600', 'border-transparent');
            activeNav.classList.add('text-primary', 'bg-blue-50', 'border-primary');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (window.location.hash) {
            const tabId = window.location.hash.substring(1);
            if (document.getElementById('tab-' + tabId)) {
                switchTab(tabId);
            }
        }
    });

    function filterPesananUser(status, btnElement) {
        // Update tab styling
        const tabs = document.querySelectorAll('.order-tab-btn');
        tabs.forEach(tab => {
            tab.classList.remove('border-primary', 'text-primary', 'border-b-2');
            tab.classList.add('border-transparent', 'text-gray-600');
        });
        btnElement.classList.remove('border-transparent', 'text-gray-600');
        btnElement.classList.add('border-primary', 'text-primary', 'border-b-2');

        // Filter elements
        const orders = document.querySelectorAll('.pesanan-user-item');
        orders.forEach(order => {
            if (status === 'Semua') {
                order.style.display = '';
            } else if (status === 'Pengembalian') {
                // If filtering by pengembalian, include both menunggu_pengembalian and pengembalian
                if (order.getAttribute('data-status') === 'Menunggu Pengembalian' || order.getAttribute('data-status') === 'Pengembalian') {
                    order.style.display = '';
                } else {
                    order.style.display = 'none';
                }
            } else if (order.getAttribute('data-status') === status) {
                order.style.display = '';
            } else {
                order.style.display = 'none';
            }
        });
    }
</script>
@endsection
