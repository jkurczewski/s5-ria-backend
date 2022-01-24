<?php

namespace Database\Seeders;

use App\Models\Addition;
use Illuminate\Database\Seeder;


class AdditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Addition::factory()
        ->count(50)
        ->create();
    }
}
