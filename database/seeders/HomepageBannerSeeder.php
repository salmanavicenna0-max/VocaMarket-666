<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HomepageBanner;
use App\Models\User;

class HomepageBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Temukan Admin User (biasanya id = 1 atau yang role-nya admin)
        $admin = User::where('role', 'admin')->first() ?? User::find(1);
        $adminId = $admin ? $admin->id : 1;

        $banners = [
            [
                'user_id' => $adminId,
                'image_path' => 'images/banner_seragam_1786530000359.png',
                'badge_text' => 'Produk Esemka',
                'title' => 'Koleksi Produk Sekolah',
                'subtitle' => 'Temukan Aksesoris, Merchandise, dan perlengkapan lainnya karya siswa Esemka.',
                'button_text' => 'Lihat Katalog',
                'button_link' => url('/'), // ganti sesuai kebutuhan
                'is_active' => true,
            ],
            [
                'user_id' => $adminId,
                'image_path' => 'images/banner_buku_1786530030265.png',
                'badge_text' => 'Jasa Profesional',
                'title' => 'Layanan DKV & Animasi',
                'subtitle' => 'Butuh Desain Grafis, Video Promosi, atau Motion Graphic? Serahkan pada ahlinya.',
                'button_text' => 'Pesan Jasa',
                'button_link' => url('/'),
                'is_active' => true,
            ],
            [
                'user_id' => $adminId,
                'image_path' => 'images/banner_pramuka_1786530042974.png',
                'badge_text' => 'Solusi IT',
                'title' => 'Layanan Jasa PPLG',
                'subtitle' => 'Pembuatan Website, Aplikasi Mobile, Hosting, hingga Game Development.',
                'button_text' => 'Konsultasi Sekarang',
                'button_link' => url('/'),
                'is_active' => true,
            ],
            [
                'user_id' => $adminId,
                'image_path' => 'images/banner_tas_1786530062086.png',
                'badge_text' => 'Bisnis & Finansial',
                'title' => 'Pemasaran & Akuntansi',
                'subtitle' => 'Solusi Digital Marketing, Pembukuan, hingga Konsultasi Pajak untuk bisnis Anda.',
                'button_text' => 'Pelajari Lebih Lanjut',
                'button_link' => url('/'),
                'is_active' => true,
            ],
            [
                'user_id' => $adminId,
                'image_path' => 'images/banner_flashsale_1786530082778.png',
                'badge_text' => 'Waktu Terbatas',
                'title' => 'Flash Sale Up to 50%',
                'subtitle' => 'Jangan lewatkan diskon besar-besaran untuk kebutuhan sekolah hari ini!',
                'button_text' => 'Belanja Sekarang',
                'button_link' => url('/'),
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            HomepageBanner::create($banner);
        }
    }
}
