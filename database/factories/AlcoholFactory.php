<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class AlcoholFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = ['whisky', 'rum', 'vodka', 'tequila', 'wine', 'gin'];
        $strengths = ['40%', '52%', '35%', '42%'];

        return [
            'alcohol_name' => $this->faker->name(),
            'alcohol_type' =>  Arr::random($types),
            'alcohol_strength' => Arr::random($strengths),
            'alcohol_profile_smell' => $this->faker->sentence(6, true) ,
            'alcohol_profile_taste' => $this->faker->sentence(6, true) ,
            'alcohol_profile_finish' => $this->faker->sentence(6,true) ,
            'alcohol_image_url' =>$this->faker->image('./resources/alcohols', '400', '400', 'cats', false),
        ];
    }
}

