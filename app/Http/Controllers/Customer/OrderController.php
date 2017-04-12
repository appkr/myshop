<?php

namespace App\Http\Controllers\Customer;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
    const DELIVERY_FEE_FLOOR = 30000;

    public function __construct()
    {
        $this->middleware('auth:customers');
    }

    public function store(StoreOrderRequest $request)
    {
        if ($request->isCartEmpty()) return $this->respondOk();

        $this->createOrder($request);

        return $this->respondOk();
    }

    private function respondOk()
    {
        response()->json(null, 204);
    }

    private function createOrder(StoreOrderRequest $request)
    {
        /** @var Customer $customer */
        $customer = $request->getCustomer();
        $billableAmount = $request->getBillableAmount();

        /** @var Order $order */
        $order = $customer->orders()->create([
            'billable_amount' => $billableAmount,
            'billable_delivery_fee' => $this->getDeliveryFee($billableAmount),
            'payment_method' => $request->input('payment_method'),
            'checkout_at' => Carbon::now(),
        ]);

        $order->products()->sync($request->getCartItemIds());

        $request->getCart()->reset();

        return;
    }

    private function getDeliveryFee(int $totalBillableAmount = 0)
    {
        return $totalBillableAmount > self::DELIVERY_FEE_FLOOR
            ? 0 : 3000;
    }
}
