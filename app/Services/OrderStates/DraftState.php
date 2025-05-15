<?php
namespace App\Services\OrderStates;

use App\Models\Order;
use App\Interfaces\OrderState;
use App\Exceptions\InvalidTransitionException;

class DraftState implements OrderState
{
    public function approve(Order $order): void
    {
        $order->update(['status' => 'Approved']);
    }

    public function deliver(Order $order): void
    {
        throw new InvalidTransitionException('Cannot deliver from Draft state');
    }

    public function cancel(Order $order): void
    {
        $order->update(['status' => 'Cancelled']);
    }
}
