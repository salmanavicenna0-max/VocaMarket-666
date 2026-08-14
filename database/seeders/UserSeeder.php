<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'useradmin@admin.com'],
            [
                'name' => 'Admin',
                'nis' => null,
                'password' => 'admin123',
                'role' => 'admin',
                'verification_seller' => 'no',
                'verification_seller_at' => null,
            ]
        );
    }
}
