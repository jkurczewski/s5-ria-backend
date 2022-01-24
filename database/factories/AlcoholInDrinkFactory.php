<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlcoholInDrinkFactory extends Factory
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
            'alcohol_id' =>  rand(1, 50),
            'alcohol_unit' => 'ml',
            'alcohol_amount' => rand(10, 50),
        ];
    }
}

