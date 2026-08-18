<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'type' => 'produk',
                'category' => 'Aksesoris',
                'name' => 'Ganci Akrilik Custom Logo Sekolah / Nametag',
                'description' => "Gantungan kunci akrilik tebal berkualitas, bisa custom logo atau nametag.\nCocok untuk aksesoris tas atau kenang-kenangan.",
                'price' => 15000,
                'original_price' => 20000,
                'discount_percentage' => 25,
                'sales_count' => 1250,
                'rating' => 4.8,
                'reviews_count' => 310,
                'stock' => 150,
                'store_name' => 'BN Aksesoris',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://picsum.photos/seed/ganci/300/300',
                'is_star' => true,
                'is_promo' => true,
            ],
            [
                'type' => 'produk',
                'category' => 'Merchandise',
                'name' => 'Kaos Khusus Bakti Nusantara / Merchandise',
                'description' => "Kaos katun premium khusus edisi Bakti Nusantara.\nNyaman dipakai sehari-hari, sablon awet dan tidak mudah pudar.",
                'price' => 85000,
                'original_price' => 100000,
                'discount_percentage' => 15,
                'sales_count' => 540,
                'rating' => 4.9,
                'reviews_count' => 120,
                'stock' => 50,
                'store_name' => 'Merch BN Store',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://picsum.photos/seed/kaosbn/300/300',
                'is_star' => true,
                'is_promo' => false,
            ],
            [
                'type' => 'produk',
                'category' => 'Hardware',
                'name' => 'Modul Smart Home IoT Berbasis Mikrokontroler',
                'description' => "Modul IoT siap pakai untuk simulasi smart home (lampu otomatis, sensor suhu).\nKarya asli siswa Hardware / PPLG.",
                'price' => 150000,
                'original_price' => 175000,
                'discount_percentage' => 14,
                'sales_count' => 21,
                'rating' => 4.7,
                'reviews_count' => 5,
                'stock' => 12,
                'store_name' => 'Pepelege Hardware',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://picsum.photos/seed/iot/300/300',
                'is_star' => true,
                'is_promo' => true,
            ],
            [
                'type' => 'jasa',
                'category' => 'PPLG',
                'name' => 'Jasa Pembuatan Website Company Profile / E-Commerce',
                'description' => "Melayani pembuatan website profesional mulai dari company profile, e-commerce, hingga web custom.\nDikerjakan oleh tim ahli PPLG.",
                'price' => 500000,
                'original_price' => 750000,
                'discount_percentage' => 33,
                'sales_count' => 18,
                'rating' => 4.8,
                'reviews_count' => 14,
                'stock' => 999,
                'store_name' => 'PPLG Software House',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://picsum.photos/seed/website/300/300',
                'is_star' => true,
                'is_promo' => true,
            ],
            [
                'type' => 'jasa',
                'category' => 'Pemasaran',
                'name' => 'Jasa Admin Sosial Media & Digital Marketing',
                'description' => "Jasa kelola akun sosial media bisnis Anda (Instagram, TikTok). Termasuk perencanaan konten, copywriting, dan optimasi digital marketing.",
                'price' => 300000,
                'original_price' => 450000,
                'discount_percentage' => 33,
                'sales_count' => 10,
                'rating' => 4.9,
                'reviews_count' => 6,
                'stock' => 999,
                'store_name' => 'Marketing BN Agency',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://picsum.photos/seed/sosmed/300/300',
                'is_star' => true,
                'is_promo' => false,
            ],
            [
                'type' => 'jasa',
                'category' => 'DKV & Animasi',
                'name' => 'Jasa Video Promosi / Animasi Motion Graphic',
                'description' => "Buat video promosi atau animasi 2D yang menarik untuk produk Anda.\nDikerjakan oleh siswa DKV & Animasi berpengalaman.",
                'price' => 150000,
                'original_price' => 200000,
                'discount_percentage' => 25,
                'sales_count' => 32,
                'rating' => 5.0,
                'reviews_count' => 15,
                'stock' => 999,
                'store_name' => 'Animasi Studio 1',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://picsum.photos/seed/video/300/300',
                'is_star' => true,
                'is_promo' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

