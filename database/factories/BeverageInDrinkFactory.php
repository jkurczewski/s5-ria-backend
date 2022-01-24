<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BeverageInDrinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'drink_id' => rand(1, 50),
            'beverage_id' =>  rand(1, 50),
            'beverage_unit' => 'ml',
            'beverage_amount' => rand(50, 100),
        ];
    }
}

