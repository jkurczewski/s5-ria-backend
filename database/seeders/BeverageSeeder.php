<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Beverage;

class BeverageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url = 'http://localhost:8000/storage/images/beverages/';

        $beverages = [
            [
                'beverage_name' => "Sok z limonki",
                'beverage_flavour' => "",
                'beverage_image_url' => $url . "shutterstock-164198246_800x600.jpg"
            ],
            [
                'beverage_name' => "Sok z cytryny",
                'beverage_flavour' => "",
                'beverage_image_url' => $url . "shutterstock-211542739_800x600.jpg"
            ],
            [
                'beverage_name' => "Sok żurawinowy",
                'beverage_flavour' => "",
                'beverage_image_url' => $url . "sok-z-zurawiny-100.jpg"
            ],
            [
                'beverage_name' => "Sok pomarańczowy",
                'beverage_flavour' => "",
                'beverage_image_url' => $url . "pomarancza_big.jpg"
            ],
            [
                'beverage_name' => "SCHWEPPES GINGER BEER",
                'beverage_flavour' => "",
                'beverage_image_url' => $url . "schweppes-ginger-beer-einweg.jpg"
            ],
            [
                'beverage_name' => "Woda gazowana",
                'beverage_flavour' => "",
                'beverage_image_url' => $url . "shutterstock-111304484_800x600.jpg"
            ],
            [
                'beverage_name' => "Sok grejpfrutowy",
                'beverage_flavour' => "",
                'beverage_image_url' => $url . "140783_sok_grejpfrutowy_grejpfruty.jpg"
            ],
        ];

        foreach ($beverages as $beverage) {
            Beverage::create($beverage);
        }
    }
}
