<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Http\Requests\OrderRequest;
use App\Services\DiscountContext;
use Illuminate\Support\Facades\DB;
use App\Exceptions\InvalidTransitionException;
use App\Exceptions\ImmutableOrderException;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with(['customer', 'items.product'])->paginate(15);
    }

    public function store(OrderRequest $request)
    {
        $order = DB::transaction(function() use ($request) {
            $customer = Customer::findOrFail($request->customer_id);
            $discountContext = new DiscountContext($customer);

            $order = Order::create([
                'customer_id' => $customer->id,
                'status' => 'Draft',
                'total_amount' => 0,
                'discount_amount' => 0,
                'final_amount' => 0,
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $itemTotal = $product->base_price * $item['quantity'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->base_price,
                    'total_price' => $itemTotal,
                ]);

                $total += $itemTotal;
            }

            $discount = $discountContext->applyDiscount($total);

            $order->update([
                'total_amount' => $total,
                'discount_amount' => $discount,
                'final_amount' => $total - $discount,
            ]);

            return $order;
        });

        return response()->json([
            'message' => 'Order created successfully',
            'data' => $order->load(['customer', 'items.product'])
        ], 201);
    }

    public function show(Order $order)
    {
        return $order->load(['customer', 'items.product']);
    }

    public function update(OrderRequest $request, Order $order)
    {
        if ($order->isImmutable()) {
            throw new ImmutableOrderException();
        }

        $updatedOrder = DB::transaction(function() use ($request, $order) {
            $customer = Customer::findOrFail($request->customer_id);
            $discountContext = new DiscountContext($customer);

            // Delete existing items
            $order->items()->delete();

            $total = 0;

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $itemTotal = $product->base_price * $item['quantity'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->base_price,
                    'total_price' => $itemTotal,
                ]);

                $total += $itemTotal;
            }

            $discount = $discountContext->applyDiscount($total);

            $order->update([
                'customer_id' => $customer->id,
                'total_amount' => $total,
                'discount_amount' => $discount,
                'final_amount' => $total - $discount,
            ]);

            return $order;
        });

        return response()->json([
            'message' => 'Order updated successfully',
            'data' => $updatedOrder->load(['customer', 'items.product'])
        ]);
    }

    public function changeStatus(Order $order, Request $request)
    {
        $request->validate([
            'status' => 'required|in:approve,deliver,cancel'
        ]);

        try {
            switch ($request->status) {
                case 'approve':
                    $order->approve();
                    break;
                case 'deliver':
                    $order->deliver();
                    break;
                case 'cancel':
                    $order->cancel();
                    break;
            }

            return response()->json([
                'message' => 'Status updated successfully',
                'data' => $order->fresh()->load(['customer', 'items.product'])
            ]);
        } catch (InvalidTransitionException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (ImmutableOrderException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    public function destroy(Order $order)
    {
        if ($order->isImmutable()) {
            throw new ImmutableOrderException();
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
