<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alcohol;

class AlcoholSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url = 'http://localhost:8000/storage/images/alcohols/';

        $alcohols = [
            [
                'alcohol_name' => "Bulleit Bourbon 10yo",
                'alcohol_type' => 'Whisky',
                'alcohol_strength' => '45,6',
                'alcohol_profile_smell' => 'Bulleit Bourbon 10 yo posiada zapach charakteryzujący się kremową wanilią, karmelem i miodem, jak również nutą dębową.',
                'alcohol_profile_taste' => 'W smaku wyczuć można natomiast suszone owoce na czele z morelą, na tle waniliowym, z delikatnym akcentem pikanterii oraz przyjemnego karmelu',
                'alcohol_profile_finish' => 'Długi finisz oferuje dymność ze słodyczą oraz cały czas obecną pikanterią. ',
                'alcohol_image_url' => $url . "bulleit-10-yo.jpg",
            ],
            [
                'alcohol_name' => "Espolon Tequila Reposado",
                'alcohol_type' => 'Tequila',
                'alcohol_strength' => '40',
                'alcohol_profile_smell' => 'Zapach Espolon Tequila Reposado odznacza się przyprawami korzennymi, prażoną agawą, a także odrobiną karmelu.',
                'alcohol_profile_taste' => 'W smaku wyczuć można z kolei brązowy cukier, więcej prażonej agawy, jak również wanilię i przyjemne owoce.',
                'alcohol_profile_finish' => 'Długi i satysfakcjonujący finisz niesie ze sobą odrobinę pikanterii. ',
                'alcohol_image_url' => $url . "ESPOLON-TEQUILA-REPOSADO-0,7L--40.jpg",
            ],
            [
                'alcohol_name' => "Angostura Bitter",
                'alcohol_type' => 'Bitter',
                'alcohol_strength' => '44,7',
                'alcohol_profile_smell' => 'W smaku i aromacie wyczuć można nuty drzewa chinowego, kłącza galangi, skórki pomarańczy i przypraw korzennych, wśród których dominuje imbir.',
                'alcohol_profile_taste' => 'Bardzo intensywny, gorzki smak sprawia, że angostura doskonale sprawdza się jako baza do różnych drinków.',
                'alcohol_profile_finish' => '',
                'alcohol_image_url' => $url . "007549600040.jpg",
            ],
            [
                'alcohol_name' => "Cointreau",
                'alcohol_type' => 'Liquier',
                'alcohol_strength' => '40',
                'alcohol_profile_smell' => 'To wyjątkowy likier pochodzący prosto z Francji. Zapach wita nas intensywnym aromatem pomarańczy. W pełnym, słodkim smaku również wyczuć można wyraźny pomarańczowy akcent',
                'alcohol_profile_taste' => 'Alkohol świetnie współgra ze słodyczą, idealnie balansując całość. Wyczuć można także przyprawy, w tym łagodne nuty gałki muszkatołowej oraz cynamonu.',
                'alcohol_profile_finish' => '',
                'alcohol_image_url' => $url . "Cointreau.jpg",
            ],
            [
                'alcohol_name' => "Smirnoff Black",
                'alcohol_type' => 'Vodka',
                'alcohol_strength' => '40',
                'alcohol_profile_smell' => '',
                'alcohol_profile_taste' => ' Bardzo gładka i przyjemna w smaku. Oferuje wyrazisty, pełny smak i aromat.',
                'alcohol_profile_finish' => '',
                'alcohol_image_url' => $url . "smirnoff-black-1000ml.jpg",
            ],
            [
                'alcohol_name' => "The Botanist",
                'alcohol_type' => 'Gin',
                'alcohol_strength' => '46',
                'alcohol_profile_smell' => '',
                'alcohol_profile_taste' => 'Smak, którym charakteryzuje się Dry Gin The Botanist jest bardzo złożony. Znajdziemy w nim idealną harmonię ziół, kwiatów, cytrusów i pikantnych przypraw.',
                'alcohol_profile_finish' => '',
                'alcohol_image_url' => $url . "GIN-THE-BOTANIST-ISLAY-DRY-0,7L-46.jpg",
            ],
            [
                'alcohol_name' => "Campari Bitter",
                'alcohol_type' => 'Bitter',
                'alcohol_strength' => '25',
                'alcohol_profile_smell' => '',
                'alcohol_profile_taste' => 'Wyróżnia się smakiem słodko-gorzkich pomarańczy. W złożonym smaku wyczuć można również nuty wiśni, goździków, a także cynamonu. Jest to jeden z najbardziej gorzkich alkoholi z jakimi możemy mieć do czynienia.',
                'alcohol_profile_finish' => '',
                'alcohol_image_url' => $url . "70214-campari-bitter-liqueur-25-prozent-vol.jpg",
            ],
            [
                'alcohol_name' => "Martini Rosso",
                'alcohol_type' => 'Wermut',
                'alcohol_strength' => '15',
                'alcohol_profile_smell' => 'Oferuje przyjemny, owocowy aromat z akcentami guawy, przypraw, oraz odrobiny pistacji.',
                'alcohol_profile_taste' => 'W smaku da się wyczuć z kolei sherry, winogrona i przyprawy, a także nutę dębu.',
                'alcohol_profile_finish' => 'Wszystko to wygasa do delikatnie pieprznego, satysfakcjonującego finiszu.',
                'alcohol_image_url' => $url . "martini-rosso.jpg",
            ],
            [
                'alcohol_name' => "MARTINI BIANCO",
                'alcohol_type' => 'Wermut',
                'alcohol_strength' => '15',
                'alcohol_profile_smell' => 'Owoce cytrusowe, brzoskwinie, liść laurowy, wanilia;',
                'alcohol_profile_taste' => 'Dość słodki, szarlotka pieczona z cynamonem i imbirem, nieco miodu, odrobina ziołowej goryczki ze skórką cytrynową',
                'alcohol_profile_finish' => 'Słodki, jabłka, cynamon, wanilia',
                'alcohol_image_url' => $url . "Martini-Bianco-1l.jpg",
            ],
            [
                'alcohol_name' => "Bacardi Reserva 8 anos",
                'alcohol_type' => 'Rum',
                'alcohol_strength' => '40',
                'alcohol_profile_smell' => 'Aromat Bacardi Reserva 8 anos przedstawia akcenty skórek owocowych, dębu i syropu, a także kopru włoskiego.',
                'alcohol_profile_taste' => 'Smak jest natomiast bogaty i słodki. Można w nim wyczuć nuty owoców tropikalnych i skórek owocowych, jak również przypraw korzennych.',
                'alcohol_profile_finish' => 'Wszystko to wygasa do słodkiego, delikatnego finiszu.',
                'alcohol_image_url' => $url . "bacardi-rum-8-years.jpg",
            ],
            [
                'alcohol_name' => "Moët et Chandon Brut Imperial",
                'alcohol_type' => 'Szampan',
                'alcohol_strength' => '12',
                'alcohol_profile_smell' => '',
                'alcohol_profile_taste' => 'Moët et Chandon Brut Imperial to połączenie ponad 100 różnych win po to, by uzyskać wielopoziomowy, złożony smak. Pijącego raczy świeżą owocowością, równocześnie będąc elegancko dojrzałym alkoholem.',
                'alcohol_profile_finish' => '',
                'alcohol_image_url' => $url . "moet-et-chandon-brut-imperial.jpg",
            ],
            [
                'alcohol_name' => "Aperol",
                'alcohol_type' => 'Bitter',
                'alcohol_strength' => '11',
                'alcohol_profile_smell' => 'Aperol przedstawia aromaty pomarańczy, ziół, a także balansującej całość wanilii.',
                'alcohol_profile_taste' => 'W smaku wyczuć można bogatą nutę pomarańczy, ziół i drewna, jak również gorzkość i słodycz w idealnych proporcjach. ',
                'alcohol_profile_finish' => 'Wszystko to zakończone jest przyjemnym, słodko-ziołowym finiszem, pozostającym przez długi czas na języku. ',
                'alcohol_image_url' => $url . "aperol-aperitivo-700-ml.jpg",
            ]

        ];

        foreach ($alcohols as $alcohol) {
            Alcohol::create($alcohol);
        }
    }
}
