<?php
namespace App\Interfaces;

use App\Models\Order;

interface OrderState
{
    public function approve(Order $order): void;
    public function deliver(Order $order): void;
    public function cancel(Order $order): void;
}
