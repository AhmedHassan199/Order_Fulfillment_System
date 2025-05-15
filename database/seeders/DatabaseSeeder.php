<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Customer::factory(10)->create();
        \App\Models\Product::factory(20)->create();
        \App\Models\Order::factory(5)->create()->each(function ($order) {
            \App\Models\OrderItem::factory(rand(1, 5))->create([
                'order_id' => $order->id
            ]);
        });
    }
}
