<?php

use App\Customer;
use App\Order;
use App\Product;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        Order::truncate();

        Customer::get()->each(function (Customer $customer) {
            foreach(range(1,3) as $index) {
                $tempOrder = factory(Order::class)->make();
                $product = $this->getProduct();

                // 팩토리에서 만든 값을 덮어 씁니다.
                $tempOrder->billable_amount = $product->price * rand(1, 3);
                $tempOrder->billable_delivery_fee = $tempOrder->billable_amount + 3000;
                $order = $customer->orders()->save($tempOrder);

                // TODO: attach가 필요한 지 확인할 것
                $order->products()->attach($product);
            }
        });
    }

    private function getProduct()
    {
        $lastProductId = Product::count();

        return Product::find(rand(1, $lastProductId));
    }
}
