<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('products')) {
            $this->call([
                ProductSeeder::class,
            ]);
        }
    }
}
