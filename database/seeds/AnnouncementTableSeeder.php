<?php

use App\Announcement;
use App\Member;
use Illuminate\Database\Seeder;

class AnnouncementTableSeeder extends Seeder
{
    public function run()
    {
        Announcement::truncate();

        Member::get()->each(function (Member $md) {
            if (rand(0, 1) == 0) {
                return;
            }

            $md->announcements()->save(
                factory(Announcement::class)->make()
            );
        });
    }
}
