<?php

use App\Customer;
use App\Member;
use App\Question;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    public function run()
    {
        Question::truncate();

        Customer::get()->each(function (Customer $customer) {
            if (rand(0, 2) == 0) {
                return;
            }

            $customer->questions()->save(
                factory(Question::class)->make()
            );
        });

        Question::get()->each(function (Question $question) {
            if (rand(0, 1) == 0) {
                return;
            }

            $tempModel = factory(Question::class)->make();
            $tempModel->questionable_type = 'App\\Member';
            $tempModel->questionable_id = Member::get()->shuffle()->first()->id;
            $tempModel->parent_id = $question->id;

            $question->children()->save($tempModel);
        });
    }
}
