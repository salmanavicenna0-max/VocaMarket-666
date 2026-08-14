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
                    <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=007DCC&color=fff&size=128" alt="Profile" class="w-20 h-20 rounded-full border-4 border-white shadow-md object-cover">
                    <button class="absolute bottom-0 right-0 bg-primary text-white p-1.5 rounded-full shadow hover:bg-blue-700 transition">
                        <i class="ph-bold ph-pencil-simple text-xs"></i>
                    </button>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">Budi Santoso</h3>
                <p class="text-gray-500 text-sm">budi.santoso@email.com</p>
            </div>

            <!-- Menu Navigasi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <ul class="flex flex-col">
                    <li>
                        <a href="#" class="flex items-center gap-3 px-5 py-4 text-primary font-medium bg-blue-50 border-l-4 border-primary">
                            <i class="ph-fill ph-user text-xl"></i> Biodata Diri
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-receipt text-xl"></i> Daftar Transaksi
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-star text-xl"></i> Ulasan Saya
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-map-pin text-xl"></i> Buku Alamat
                        </a>
                    </li>
                    <li class="border-t border-gray-100">
                        <a href="#" class="flex items-center gap-3 px-5 py-4 text-gray-600 font-medium hover:bg-gray-50 hover:text-primary transition border-l-4 border-transparent">
                            <i class="ph-fill ph-gear text-xl"></i> Pengaturan
                        </a>
                    </li>
                    <li class="border-t border-gray-100">
                        <a href="#" class="flex items-center gap-3 px-5 py-4 text-red-500 font-medium hover:bg-red-50 transition border-l-4 border-transparent">
                            <i class="ph-bold ph-sign-out text-xl"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
            
        </div>

        <!-- Konten Kanan -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Biodata Diri</h2>
                    <p class="text-gray-500 text-sm mt-1">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <!-- Form Data Diri -->
                        <div class="flex flex-col gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Nama Lengkap</label>
                                <input type="text" value="Budi Santoso" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1.5">Tanggal Lahir</label>
                                <div class="flex gap-2">
                                    <select class="border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:border-primary flex-1">
                                        <option>15</option>
                                    </select>
                                    <select class="border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:border-primary flex-1">
                                        <option>Agustus</option>
                                    </select>
                                    <select class="border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:border-primary flex-1">
                                        <option>2005</option>
                                    </select>
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

                        <!-- Form Kontak -->
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
                        <button class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-8 rounded-lg shadow-sm transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
