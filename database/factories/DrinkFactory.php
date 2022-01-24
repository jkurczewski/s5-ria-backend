<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DrinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' =>  $this->faker->text(300),
            'recipe' => $this->faker->text(300),
            'image_url' =>$this->faker->image('./resources/drinks', '400', '400', 'cats', false),
        ];
    }
}

