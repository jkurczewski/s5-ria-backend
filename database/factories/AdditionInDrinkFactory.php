<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdditionInDrinkFactory extends Factory
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
            'addition_id' =>  rand(1, 50),
            'addition_unit' => 'piece',
            'addition_amount' => rand(1, 10),
        ];
    }
}

