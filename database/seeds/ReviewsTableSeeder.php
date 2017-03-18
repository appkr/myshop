<?php

use App\Customer;
use App\Review;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        Review::truncate();

        Customer::get()->each(function (Customer $customer) {
            $customer->reviews()->save(
                factory(Review::class)->make()
            );
        });
    }
}
