<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Exceptions\InvalidTransitionException;
use App\Exceptions\ImmutableOrderException;

class OrderStateTransitionTest extends TestCase
{
    public function test_draft_to_approved_transition()
    {
        $order = Order::factory()->create(['status' => 'Draft']);

        $order->approve();

        $this->assertEquals('Approved', $order->fresh()->status);
    }

    public function test_approved_to_delivered_transition()
    {
        $order = Order::factory()->create(['status' => 'Approved']);

        $order->deliver();

        $this->assertEquals('Delivered', $order->fresh()->status);
    }

    public function test_cannot_deliver_from_draft()
    {
        $order = Order::factory()->create(['status' => 'Draft']);

        $this->expectException(InvalidTransitionException::class);

        $order->deliver();
    }

    public function test_cannot_modify_delivered_order()
    {
        $order = Order::factory()->create(['status' => 'Delivered']);

        $this->expectException(ImmutableOrderException::class);

        $order->approve();
    }
}
