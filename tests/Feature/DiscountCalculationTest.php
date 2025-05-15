<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use App\Services\DiscountContext;

class DiscountCalculationTest extends TestCase
{
    public function test_regular_customer_discount()
    {
        $customer = Customer::factory()->create(['type' => 'Regular']);
        $discountContext = new DiscountContext($customer);

        $this->assertEquals(0, $discountContext->applyDiscount(999));
        $this->assertEquals(50, $discountContext->applyDiscount(1000));
    }

    public function test_wholesale_customer_discount()
    {
        $customer = Customer::factory()->create(['type' => 'Wholesale']);
        $discountContext = new DiscountContext($customer);

        $this->assertEquals(150, $discountContext->applyDiscount(1000));
    }

    public function test_vip_customer_discount()
    {
        $customer = Customer::factory()->create(['type' => 'VIP']);
        $discountContext = new DiscountContext($customer);

        $this->assertEquals(200, $discountContext->applyDiscount(1000));
    }
}
