<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'addition_name' => $this->faker->name(),
            'addition_img_url' =>$this->faker->image('./resources/additions', '400', '400', 'cats', false),
        ];
    }
}
