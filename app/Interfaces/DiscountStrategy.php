<?php
namespace App\Interfaces;

interface DiscountStrategy
{
    public function calculateDiscount(float $amount): float;
}
