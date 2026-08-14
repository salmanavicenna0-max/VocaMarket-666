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
                'name' => 'Tas Sekolah Anak Perempuan / Tas Ransel Sekolah SD SMP SMA',
                'description' => "Tas punggung sekolah yang sangat nyaman dengan bahan kanvas tebal.\nCocok untuk pelajar SD, SMP, maupun SMA.\nTersedia ruang penyimpanan laptop.",
                'price' => 45000,
                'original_price' => 75000,
                'discount_percentage' => 40,
                'sales_count' => 12500,
                'rating' => 4.8,
                'reviews_count' => 3100,
                'stock' => 150,
                'store_name' => 'Grosir Tas Esemka',
                'store_location' => 'KOTA BANDUNG',
                'image_path' => 'https://picsum.photos/seed/tasanak/300/300',
                'is_star' => true,
                'is_promo' => false,
            ],
            [
                'type' => 'produk',
                'category' => 'Alat Tulis',
                'name' => 'Buku Tulis Sinar Dunia / SIDU 38 Lembar (1 Pack / 10 Buku)',
                'description' => "Buku tulis SIDU 38 lembar.\nHarga di atas adalah harga 1 pack isi 10 buku.\nKualitas kertas terbaik dan tidak mudah robek.",
                'price' => 32000,
                'original_price' => 35000,
                'discount_percentage' => 8,
                'sales_count' => 54000,
                'rating' => 4.9,
                'reviews_count' => 12000,
                'stock' => 500,
                'store_name' => 'Toko Alat Tulis Kita',
                'store_location' => 'KOTA JAKARTA PUSAT',
                'image_path' => 'https://picsum.photos/seed/bukutulis/300/300',
                'is_star' => true,
                'is_promo' => false,
            ],
            [
                'type' => 'produk',
                'category' => 'Sepatu',
                'name' => 'Sepatu Sekolah Hitam Polos Tali Sneaker Original',
                'description' => "Sepatu kets hitam polos, standar sekolah.\nBahan kanvas awet, sol karet anti slip.\nUkuran tersedia: 36, 37, 38, 39, 40, 41, 42.",
                'price' => 85000,
                'original_price' => 150000,
                'discount_percentage' => 43,
                'sales_count' => 21000,
                'rating' => 4.7,
                'reviews_count' => 5000,
                'stock' => 120,
                'store_name' => 'Sepatu Pelajar ID',
                'store_location' => 'KOTA TANGERANG',
                'image_path' => 'https://picsum.photos/seed/sepatu/300/300',
                'is_star' => true,
                'is_promo' => true,
            ],
            [
                'type' => 'produk',
                'category' => 'Aksesoris',
                'name' => 'Kaos Kaki Sekolah Hitam Putih Pramuka SMP SMA',
                'description' => "Kaos kaki sekolah berbahan katun spandex yang menyerap keringat.\nHarga per pasang.",
                'price' => 7500,
                'original_price' => 15000,
                'discount_percentage' => 50,
                'sales_count' => 18000,
                'rating' => 4.8,
                'reviews_count' => 4500,
                'stock' => 300,
                'store_name' => 'KaosKakiMurah',
                'store_location' => 'KOTA SURABAYA',
                'image_path' => 'https://picsum.photos/seed/kaoskaki/300/300',
                'is_star' => false,
                'is_promo' => true,
            ],
            [
                'type' => 'produk',
                'category' => 'Aksesoris',
                'name' => 'Sticker 3D Animasi Karakter Manik Lucu Stiker Botol Tumblr',
                'description' => "Stiker 3D Karakter Lucu untuk menghias berbagai barang Anda!\nFitur Produk:\n- Terbuat dari bahan resin berkualitas\n- Tahan lama dan warna cerah\n- Sudah dilengkapi dengan lem perekat yang kuat",
                'price' => 3850,
                'original_price' => 10000,
                'discount_percentage' => 61,
                'sales_count' => 10500,
                'rating' => 4.9,
                'reviews_count' => 3600,
                'stock' => 1285,
                'store_name' => 'FXG Fashion Gallery',
                'store_location' => 'KOTA JAKARTA PUSAT',
                'image_path' => 'https://picsum.photos/seed/productx/300/300',
                'is_star' => true,
                'is_promo' => false,
            ],
            [
                'type' => 'jasa',
                'category' => 'Jasa DKV & Animasi',
                'name' => 'Jasa Desain Logo Karakter Maskot Esports Perusahaan',
                'description' => "Menyediakan jasa pembuatan maskot untuk keperluan sekolah, esports, atau usaha Anda.\nDikerjakan oleh siswa DKV berbakat.",
                'price' => 150000,
                'original_price' => null,
                'discount_percentage' => null,
                'sales_count' => 120,
                'rating' => 5.0,
                'reviews_count' => 85,
                'stock' => 999,
                'store_name' => 'Animasi Studio 1',
                'store_location' => 'KOTA MALANG',
                'image_path' => 'https://picsum.photos/seed/desainlogo/300/300',
                'is_star' => true,
                'is_promo' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

