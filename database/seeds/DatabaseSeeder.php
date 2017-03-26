<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $isSqlite;

    public function __construct()
    {
        $this->isSqlite = in_array(
            DB::getDriverName(),
            ['sqlite', 'testing'],
            true
        );
    }

    public function run()
    {

        $this->disableForeignKeyChecks();

        $this->call(CategoriesTableSeeder::class);

        if (app()->environment() !== 'production') {
            $this->call(TestSeeders::class);
        }

        $this->restoreForeignKeyChecks();
    }

    protected function disableForeignKeyChecks()
    {
        if (! $this->isSqlite) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }
    }

    protected function restoreForeignKeyChecks()
    {
        if (! $this->isSqlite) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
