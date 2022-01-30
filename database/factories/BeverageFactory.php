<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BeverageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'beverage_name' => $this->faker->name(),
            'beverage_flavour' => $this->faker->sentence(6, true),
            'beverage_image_url' => '',
        ];
    }
}
