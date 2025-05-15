<?php
namespace App\Services\DiscountStrategies;

use App\Interfaces\DiscountStrategy;

class VIPCustomerDiscount implements DiscountStrategy
{
    public function calculateDiscount(float $amount): float
    {
        return $amount * 0.20;
    }
}
