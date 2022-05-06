<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Seed the categories table
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['Wheat' => 'Wheat beer is a top-fermented beer which is brewed with a large proportion of wheat relative to the amount of malted barley. The two main varieties are German Weißbier and Belgian Witbier; other types include Lambic (made with wild yeast), Berliner Weisse (a cloudy, sour beer), and Gose (a sour, salty beer)'],
            ['Ale' => 'Ale is a type of beer brewed using a warm fermentation method, resulting in a sweet, full-bodied and fruity taste. Historically, the term referred to a drink brewed without hops'],
            ['Pilsner' => 'Pilsner (also pilsener or simply pils) is a type of pale lager. It takes its name from the Bohemian city of Pilsen, where it was first produced in 1842 by Bavarian brewer Josef Groll. The world\'s first pale lager, the original Pilsner Urquell, is still produced there today'],
            ['Lager' => 'Lager is a type of beer conditioned at low temperature. Lagers can be pale, amber, or dark. Pale lager is the most widely consumed and commercially available style of beer'],
        ];
        foreach($categories as $category) {
            foreach ($category as $name => $description) {
                Category::create([
                    'name' => $name,
                    'description' => $description,
                ]);
            }
        }
    }
}
