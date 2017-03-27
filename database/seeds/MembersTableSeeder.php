<?php

use App\Member;
use App\Role;
use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    public function run()
    {
        Member::truncate();

        factory(Member::class)->create([
            'name' => 'Member',
            'email' => 'member@example.com',
            'role' => Role::BASE,
        ]);

        factory(Member::class, 5)->create();
    }
}
