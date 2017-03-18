<?php

use Illuminate\Database\Seeder;

class TestSeeders extends Seeder
{
    public function run()
    {
        $this->call(MembersTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(DeliveriesTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(WishlistsTableSeeder::class);
        $this->call(AnnouncementTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
    }
}
