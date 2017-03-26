<?php

use App\Address;
use App\Customer;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{
    public function run()
    {
        Address::truncate();

        Customer::get()->each(function (Customer $customer) {
            foreach(range(1,3) as $index) {
                $customer->addresses()->save(
                    factory(Address::class)->make()
                );
            }
        });
    }
}
