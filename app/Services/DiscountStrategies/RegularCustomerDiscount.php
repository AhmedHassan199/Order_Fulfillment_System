<?php
namespace App\Services\DiscountStrategies;

use App\Interfaces\DiscountStrategy;

class RegularCustomerDiscount implements DiscountStrategy
{
    public function calculateDiscount(float $amount): float
    {
        return $amount >= 1000 ? $amount * 0.05 : 0;
    }
}
