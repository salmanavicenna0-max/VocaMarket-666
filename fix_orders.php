<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = App\Models\Order::all();
foreach($orders as $order) {
    $firstItem = $order->items()->first();
    if($firstItem && $firstItem->product) {
        $order->update(['seller_id' => $firstItem->product->user_id]);
        echo "Updated order " . $order->id . " with seller " . $firstItem->product->user_id . "\n";
    }
}
echo "Done\n";
