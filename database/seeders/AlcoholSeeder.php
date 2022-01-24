<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alcohol;

class AlcoholSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Alcohol::factory()
        ->count(50)
        ->create();
    }
}
