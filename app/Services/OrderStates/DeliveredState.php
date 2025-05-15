<?php
namespace App\Services\OrderStates;

use App\Models\Order;
use App\Interfaces\OrderState;
use App\Exceptions\ImmutableOrderException;

class DeliveredState implements OrderState
{
    public function approve(Order $order): void
    {
        throw new ImmutableOrderException('Delivered orders cannot be modified');
    }

    public function deliver(Order $order): void
    {
        throw new ImmutableOrderException('Order already delivered');
    }

    public function cancel(Order $order): void
    {
        throw new ImmutableOrderException('Delivered orders cannot be cancelled');
    }
}
