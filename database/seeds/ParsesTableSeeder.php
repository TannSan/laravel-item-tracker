<?php

use Illuminate\Database\Seeder;

class ParsesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Parse::class, 300)->create();
    }
}
