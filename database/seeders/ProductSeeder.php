<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan tabel products
        DB::table('products')->truncate();

        $products = [
            [
                'type' => 'produk',
                'category' => 'Aksesoris',
                'name' => 'Gantungan Kunci (Ganci) Custom Logo Sekolah / Jurusan',
                'description' => "Gantungan kunci akrilik custom dengan logo sekolah atau jurusan.\nCocok untuk souvenir atau dipakai sendiri.",
                'price' => 5000,
                'original_price' => 8000,
                'discount_percentage' => 37,
                'sales_count' => 1250,
                'rating' => 4.8,
                'reviews_count' => 310,
                'stock' => 150,
                'store_name' => 'Koperasi BN',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://placehold.co/300x300/0a84d4/ffffff?text=Ganci',
                'is_star' => true,
                'is_promo' => false,
            ],
            [
                'type' => 'produk',
                'category' => 'Merchandise',
                'name' => 'Kaos Khusus Sekolah Bakti Nusantara (Merchandise Resmi)',
                'description' => "Kaos merchandise resmi sekolah Bakti Nusantara.\nBahan katun combed 30s yang nyaman dan menyerap keringat.",
                'price' => 75000,
                'original_price' => 100000,
                'discount_percentage' => 25,
                'sales_count' => 540,
                'rating' => 4.9,
                'reviews_count' => 120,
                'stock' => 50,
                'store_name' => 'Koperasi BN',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://placehold.co/300x300/ffb900/ffffff?text=Kaos+Sekolah',
                'is_star' => true,
                'is_promo' => true,
            ],
            [
                'type' => 'produk',
                'category' => 'Hardware',
                'name' => 'Modul IoT Smart Home Basic (Hardware)',
                'description' => "Modul IoT untuk pembelajaran atau project smart home.\nSudah dirakit dan siap digunakan, karya siswa/i terbaik.",
                'price' => 250000,
                'original_price' => 300000,
                'discount_percentage' => 16,
                'sales_count' => 21,
                'rating' => 4.7,
                'reviews_count' => 5,
                'stock' => 12,
                'store_name' => 'Pepelege Lab',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://placehold.co/300x300/0a84d4/ffffff?text=IoT+Hardware',
                'is_star' => false,
                'is_promo' => false,
            ],
            [
                'type' => 'jasa',
                'category' => 'DKV & Animasi',
                'name' => 'Jasa Pembuatan Video Promosi & Animasi',
                'description' => "Jasa pembuatan video promosi dan animasi 2D/3D.\nDikerjakan secara profesional oleh siswa DKV.",
                'price' => 350000,
                'original_price' => null,
                'discount_percentage' => null,
                'sales_count' => 18,
                'rating' => 5.0,
                'reviews_count' => 14,
                'stock' => 999,
                'store_name' => 'Animasi Studio 1',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://placehold.co/300x300/ffb900/ffffff?text=Jasa+Animasi',
                'is_star' => true,
                'is_promo' => false,
            ],
            [
                'type' => 'jasa',
                'category' => 'PPLG',
                'name' => 'Jasa Pembuatan Website & Landing Page Company',
                'description' => "Pembuatan website company profile, landing page, atau toko online.\nResponsive dan modern.",
                'price' => 500000,
                'original_price' => 750000,
                'discount_percentage' => 33,
                'sales_count' => 35,
                'rating' => 4.9,
                'reviews_count' => 26,
                'stock' => 999,
                'store_name' => 'PPLG Code',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://placehold.co/300x300/0a84d4/ffffff?text=Web+Design',
                'is_star' => true,
                'is_promo' => true,
            ],
            [
                'type' => 'jasa',
                'category' => 'Akuntansi',
                'name' => 'Jasa Pembukuan dan Pembuatan Laporan Keuangan UMKM',
                'description' => "Membantu membuat laporan keuangan bulanan untuk UMKM atau kegiatan kepanitiaan.",
                'price' => 150000,
                'original_price' => null,
                'discount_percentage' => null,
                'sales_count' => 12,
                'rating' => 4.8,
                'reviews_count' => 8,
                'stock' => 999,
                'store_name' => 'Accounting Service',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://placehold.co/300x300/ffb900/ffffff?text=Pembukuan',
                'is_star' => false,
                'is_promo' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
