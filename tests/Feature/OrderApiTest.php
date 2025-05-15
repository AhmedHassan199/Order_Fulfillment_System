<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order()
    {
        $customer = Customer::factory()->create();
        $products = Product::factory()->count(2)->create();

        $response = $this->postJson('/api/orders', [
            'customer_id' => $customer->id,
            'items' => [
                ['product_id' => $products[0]->id, 'quantity' => 2],
                ['product_id' => $products[1]->id, 'quantity' => 3],
            ]
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'customer',
                    'items' => [
                        '*' => ['id', 'product_id', 'quantity']
                    ]
                ]
            ]);
    }

    public function test_change_order_status()
    {
        $order = Order::factory()->create(['status' => 'Draft']);

        $response = $this->postJson("/api/orders/{$order->id}/status", [
            'status' => 'approve'
        ]);

        $response->assertStatus(200)
            ->assertJson(['data' => ['status' => 'Approved']]);
    }
}
