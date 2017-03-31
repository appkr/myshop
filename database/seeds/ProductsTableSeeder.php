<?php

use App\Member;
use App\Product;
use Faker\Generator;
use Illuminate\Database\Seeder;

/**
 * @property Generator faker
 */
class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::truncate();

        Member::get()->each(function (Member $md) {
            $md->products()->save(
                factory(Product::class)->make()
            );
            $md->products()->save(
                factory(Product::class)->make()
            );
            $md->products()->save(
                factory(Product::class)->make()
            );
        });
    }
}
