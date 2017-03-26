<?php

use App\Member;
use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    public function run()
    {
        Member::truncate();

        factory(Member::class, 5)->create();
    }
}
