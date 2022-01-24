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
        Drink::factory()
        ->count(50)
        ->create();

        Beverage::factory()
        ->count(50)
        ->create();

        Alcohol::factory()
        ->count(50)
        ->create();

        Addition::factory()
        ->count(50)
        ->create();

        BeverageInDrink::factory()
        ->count(100)
        ->create();

        AlcoholInDrink::factory()
        ->count(100)
        ->create();

        AdditionInDrink::factory()
        ->count(100)
        ->create();


    }
}
