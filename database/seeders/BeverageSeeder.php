<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Beverage;

class BeverageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Beverage::factory()
        ->count(50)
        ->create();
    }
}
