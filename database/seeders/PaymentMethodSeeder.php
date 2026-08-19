<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            ['name' => 'BCA', 'account_number' => '123456789', 'account_name' => 'VocaMarket', 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Mandiri', 'account_number' => '987654321', 'account_name' => 'VocaMarket', 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Gopay', 'account_number' => '08123456789', 'account_name' => null, 'is_active' => true, 'sort_order' => 3],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['name' => $method['name']],
                $method
            );
        }
    }
}