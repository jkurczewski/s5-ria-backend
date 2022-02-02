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
        $url = 'http://localhost:8000/storage/images/additions/';

        $additions = [
            ['addition_name' => "Limonka", 'addition_image_url' => $url . "limonka.jpg"],
            ['addition_name' => "Cytryna", 'addition_image_url' => $url . "o-cytryna.jpg"],
            ['addition_name' => "Lód", 'addition_image_url' => $url . "lod-w-kostkach-10-kg.jpg"],
            ['addition_name' => "Mięta", 'addition_image_url' => $url . "500_500_productGfx_44eae4c61da53ae28c70c43791ce107e.jpg"],
            ['addition_name' => "Sól", 'addition_image_url' => $url . "ce124930c14b6abd1eb87c8f39f42b14.jpg"],
            ['addition_name' => "Cukier", 'addition_image_url' => $url . "wapteka-cukier-dieta-1024x610.jpg"],
            ['addition_name' => "Oliwki", 'addition_image_url' => $url . "pol_pl_Oliwki-zielone-w-solance-Nocellara-500g-wloskie-78_1_1.jpg"],
            ['addition_name' => "Białko jaja", 'addition_image_url' => $url . "jajka.jpg"],
            ['addition_name' => "Maliny", 'addition_image_url' => $url . "maliny-1_9807.jpg"],
            ['addition_name' => "Truskawki", 'addition_image_url' => $url . "truskawki.jpg"],
            ['addition_name' => "Ogórek", 'addition_image_url' => $url . "gf-FQyj-vC9e-HFwF_ogorek-wlasciwosci-odzywcze-jakie-witaminy-ma-ogorek-1920x1080-nocrop.jpg"],
            ['addition_name' => "Wiśnie", 'addition_image_url' => $url . "wisnie-1.jpg"]
        ];

        foreach ($additions as $addition) {
            Addition::create($addition);
        }
    }
}
