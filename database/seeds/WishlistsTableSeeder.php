<?php

use App\Customer;
use App\Wishlist;
use Illuminate\Database\Seeder;

class WishlistsTableSeeder extends Seeder
{
    public function run()
    {
        Wishlist::truncate();

        Customer::get()->each(function (Customer $customer) {
            $numberOfWishlists = rand(0, 3);

            if ($numberOfWishlists == 0) {
                return;
            }

            foreach (range($numberOfWishlists, 3) as $index) {
                $customer->wishlists()->save(
                    factory(Wishlist::class)->make()
                );
                usleep(1);
            }
        });
    }
}
