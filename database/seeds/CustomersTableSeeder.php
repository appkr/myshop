<?php

use App\Customer;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    public function run()
    {
        Customer::truncate();

        factory(Customer::class, 10)->create();
    }
}
