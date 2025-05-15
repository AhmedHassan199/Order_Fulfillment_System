<?php
namespace App\Services;

use App\Interfaces\DiscountStrategy;
use App\Models\Customer;
use App\Services\DiscountStrategies\RegularCustomerDiscount;
use App\Services\DiscountStrategies\WholesaleCustomerDiscount;
use App\Services\DiscountStrategies\VIPCustomerDiscount;

class DiscountContext
{
    private DiscountStrategy $strategy;

    public function __construct(Customer $customer)
    {
        $this->setStrategy($customer);
    }

    private function setStrategy(Customer $customer): void
    {
        switch ($customer->type) {
            case 'Wholesale':
                $this->strategy = new WholesaleCustomerDiscount();
                break;
            case 'VIP':
                $this->strategy = new VIPCustomerDiscount();
                break;
            default:
                $this->strategy = new RegularCustomerDiscount();
        }
    }

    public function applyDiscount(float $amount): float
    {
        return $this->strategy->calculateDiscount($amount);
    }
}
