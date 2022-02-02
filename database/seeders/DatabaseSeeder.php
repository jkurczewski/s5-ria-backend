<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Drink;
use App\Models\Beverage;
use App\Models\Alcohol;
use App\Models\Addition;
use App\Models\BeverageInDrink;
use App\Models\AlcoholInDrink;
use App\Models\AdditionInDrink;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdditionSeeder::class);
        $this->call(AlcoholSeeder::class);
        $this->call(BeverageSeeder::class);
    }
}
