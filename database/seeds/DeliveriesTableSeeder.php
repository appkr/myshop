<?php

use App\Address;
use App\Delivery;
use App\Order;
use Illuminate\Database\Seeder;

class DeliveriesTableSeeder extends Seeder
{
    public function run()
    {
        Order::get()->each(function (Order $order) {
            $delivery = factory(Delivery::class)->make();
            $address = $order->customer->addresses->shuffle()->first();
            $delivery->address_id = $address->id;

            $order->delivery()->save($delivery);
        });
    }
}
