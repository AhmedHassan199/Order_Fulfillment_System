<?php
namespace App\Services\OrderStates;

use App\Models\Order;
use App\Interfaces\OrderState;
use App\Exceptions\InvalidTransitionException;

class ApprovedState implements OrderState
{
    public function approve(Order $order): void
    {
        throw new InvalidTransitionException('Order already approved');
    }

    public function deliver(Order $order): void
    {
        $order->update(['status' => 'Delivered']);
    }

    public function cancel(Order $order): void
    {
        $order->update(['status' => 'Cancelled']);
    }
}
