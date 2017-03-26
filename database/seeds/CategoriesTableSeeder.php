<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        Category::truncate();

        collect([
            Category::COMPUTER,
            Category::MOBILE,
        ])->each(function ($category) {
            (new Category)->forceFill([
                'name' => $category,
            ])->save();
        });
    }
}
