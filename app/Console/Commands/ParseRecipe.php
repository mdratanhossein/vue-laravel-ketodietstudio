<?php

namespace App\Console\Commands;

use App\Ingredient;
use App\Nutrient;
use App\Product;
use App\Recipe;
use Illuminate\Console\Command;
use PhpUnitConversion\Unit\Mass\Gram;
use PhpUnitConversion\Unit\Mass\Ounce;
use PhpUnitConversion\Unit\Volume\Gallon;
use PhpUnitConversion\Unit\Volume\Liter;
use PhpUnitConversion\Unit\Volume\MilliLiter;
use PhpUnitConversion\Unit\Volume\Tablespoon;
use PhpUnitConversion\Unit\Volume\Teaspoon;
use PhpUnitConversion\Unit\Volume\USCup;
use PhpUnitConversion\UnitGallon;
use Symfony\Component\DomCrawler\Crawler;

class ParseRecipe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fitnesi:recipe {url*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse recipes from url array';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $imperial = [
            'cup',
            'cups',
            'tablespoons',
            'tablespoon',
            'teaspoon',
            'teaspoons',
            'ounces',
            'ounce',
            'gallon',
            'gallons',
        ];

        $urls = $this->argument('url');
        $session = new \Requests_Session('https:www.allrecipes.com');
        $session->headers['User-Agent'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)';

        foreach ($urls as $url) {
            $url = str_replace('https:www.allrecipes.com', '', $url);
            $request = $session->get($url);

            $crawler = new Crawler($request->body);
            $titleNode = $crawler->filter('.recipe-summary__h1')->first();
            if ($titleNode->count() == 0) {
                $titleNode = $crawler->filter('div.intro.article-info > div > h1')->first();
            }

            $title = $titleNode->count() > 0 ? $titleNode->text() : null;

            $checkRecipe = Recipe::where('title', $title)->first();
            if ($checkRecipe) {
                continue;
            }
            $prepNode = $crawler->filter('.prepTime__item--time')->count() > 0 ? $crawler->filter('.prepTime__item--time') :
                $crawler->filter('.recipe-meta-item-body');
            $prep_time = 0;
            $cook_time = 0;
            $total_time = 0;
            $content = '';
            $servingsNode = $crawler->filter('#metaRecipeServings')->first();
            $servings = $servingsNode->count() > 0 ? $servingsNode->attr('content') : 0;
            $caloriesNode = $crawler->filter('.calorie-count')->first()->count() > 0 ? $crawler->filter('.calorie-count')->first()->children()->first() :
                $crawler->filter('div.dialog-wrap > div > section > div > div.nutrition-top.light-underline')->first();
            $calories = $crawler->filter('.calorie-count')->first()->count() > 0 ?
                $caloriesNode->text()
                : explode('Calories:', $caloriesNode->text())[1];

            foreach ($prepNode as $key => $item) {
                if (count($prepNode) == 3) {
                    if ($key == 0) {
                        $prep_time = $item->textContent;
                    }
                    if ($key == 1) {
                        $cook_time = $item->textContent;
                    }
                    if ($key == 2) {
                        $total_time = $item->textContent;
                    }
                }
                if (count($prepNode) == 6) {
                    $text = trim($item->textContent);
                    if ($key == 0) {
                        $prep_time = explode(' ', $text)[0];
                    }
                    if ($key == 1) {
                        $cook_time = explode(' ', $text)[0];
                    }
                    if ($key == 2) {
                        $total_time = explode(' ', $text)[0];
                    }
                    if ($key == 4) {
                        $servings = $text;
                    }
                }
            }

            $recipe = Recipe::create([
                'title'      => $title,
                'meal_type'  => 1,
                'prep_time'  => $prep_time,
                'cook_time'  => $cook_time,
                'total_time' => $total_time,
                'servings'   => $servings,
                'energy'     => $calories,
                'content'    => $content,
            ]);

            $steps = $crawler->filter('.recipe-directions__list--item')->count() > 0 ? $crawler->filter('.recipe-directions__list--item')
                : $crawler->filter('section.recipe-instructions.recipe-instructions-new.component.container > fieldset > ul > li > div.section-body > p');

            foreach ($steps as $step) {
                if (!empty($step->textContent)) {
                    foreach (Product::all() as $product) {
                        if (strpos($product->name, strtolower($step->textContent)) !== false) {
                            $this->info('TAGS');
                            $recipe->products()->attach([
                                $product->id
                            ]);
                        }
                    }
                    $recipe->steps()->create([
                        'content' => $step->textContent
                    ]);
                }
            }

            $ingredients = $crawler->filter('.recipe-ingred_txt')->count() > 0 ? $crawler->filter('.recipe-ingred_txt') :
                $crawler->filter('.ingredients-item-name');

            foreach ($ingredients as $ingredient) {
                $ingText = trim($ingredient->textContent);
                if (!empty($ingText) && $ingText != 'Add all ingredients to list') {
                    $splitted = explode(' ', $ingText);

                    $count_imperial = 0;
                    $count_metric = 0;
                    $type_imperial = null;
                    $type_metric = 'grams';

                    if (is_numeric($splitted[0]) || strpos($ingText, '/') !== false || strpos($ingText, '½') !== false
                        || strpos($ingText, '¼') !== false || strpos($ingText, '¾') !== false) {
                        $count_imperial = $splitted[0];
                    }

                    foreach ($imperial as $item) {
                        if (strpos($splitted[1], $item) !== false) {
                            $type_imperial = $splitted[1];
                        }
                    }

                    $name = str_replace($count_imperial . ' ' . $type_imperial, '', $ingText);

                    $checkIngredient = Ingredient::where('name', $name)->first();

                    if (!$checkIngredient) {
                        $checkIngredient = Ingredient::create([
                            'name' => $name
                        ]);
                    }

                    if (strpos($count_imperial, '/') !== false) {
                        $splitted = explode('/', $count_imperial);
                        $count_imperial = $splitted[0] / $splitted[1];
                    }

                    if(strpos($count_imperial, '½') !== false){
                        $count_imperial = 0.5;
                    }

                    if( strpos($count_imperial, '¼') !== false){
                        $count_imperial = 0.25;
                    }

                    if(strpos($count_imperial, '¾') !== false){
                        $count_imperial = 0.75;
                    }

                    if ($type_imperial == 'tablespoon' || $type_imperial == 'tablespoon') {
                        $type_imperial = $type_imperial == 'tablespoon' ? 'tablespoons' : $type_imperial;
                        $volumeUnit = new Tablespoon($count_imperial);
                        $count_metric = MilliLiter::from($volumeUnit)->getValue();
                        $type_metric = 'ml';
                    } else if ($type_imperial == 'teaspoon' || $type_imperial == 'teaspoons') {
                        $type_imperial = $type_imperial == 'teaspoon' ? 'teaspoons' : $type_imperial;
                        $volumeUnit = new Teaspoon($count_imperial);
                        $count_metric = MilliLiter::from($volumeUnit)->getValue();
                        $type_metric = 'ml';
                    } else if ($type_imperial == 'cups' || $type_imperial == 'cup') {
                        $type_imperial = $type_imperial == 'cup' ? 'cups' : $type_imperial;
                        $volumeUnit = new USCup($count_imperial);
                        $count_metric = MilliLiter::from($volumeUnit)->getValue();
                        $type_metric = 'ml';
                    } else if ($type_imperial == 'ounce' || $type_imperial == 'ounces') {
                        $type_imperial = $type_imperial == 'ounce' ? 'ounces' : $type_imperial;
                        $massUnit = new Ounce($count_imperial);
                        $count_metric = Gram::from($massUnit)->getValue();
                        $type_metric = 'grams';
                    } else if ($type_imperial == 'gallon' || $type_imperial == 'gallons') {
                        $type_imperial = $type_imperial == 'gallon' ? 'gallons' : $type_imperial;
                        $volumeUnit = new Gallon($count_imperial);
                        $count_metric = Liter::from($volumeUnit)->getValue();
                        $type_metric = 'liter';
                    }

                    foreach (Product::all() as $product) {
                        if (strpos($product->name, strtolower($checkIngredient->name)) !== false) {
                            $this->info('TAGS');
                            $recipe->products()->attach([
                                $product->id
                            ]);
                        }
                    }

                    $recipe->ingredients()->attach([
                        $checkIngredient->id => [
                            'count_metric'   => $count_metric,
                            'count_imperial' => $count_imperial,
                            'type_metric'    => $type_metric,
                            'type_imperial'  => $type_imperial
                        ]
                    ]);

                    $this->info($count_imperial . ' - ' . $type_imperial . ' - ' . $name);
                }
            }

            if ($crawler->filter('.nutrient-name')->count() == 0) {
                $requestNutritional = $session->get($url . '/fullrecipenutrition/');
                $crawlerNutrition = new Crawler($requestNutritional->body);
            }


            $nutritions = $crawler->filter('.nutrient-name')->count() == 0 ? $crawlerNutrition->filter('.nutrient-name') : $crawler->filter('.nutrient-name');

            foreach ($nutritions as $nutrition) {
                $parts = explode(':', $nutrition->textContent);
                $nutr = trim($parts[0]);
                if ($nutr == 'Total Fat') {
                    $nutr = 'Fats';
                }
                $nutr = substr($nutr, 0, -1);
                $nutritionCheck = Nutrient::where('name', 'like', '%' . $nutr . '%')->first();

                if ($nutritionCheck) {
                    $weight = substr(trim($parts[1]), 0, -1);
                    $this->info('Nutr: ' . $nutritionCheck->name);

                    $recipe->nutrients()->attach([
                        $nutritionCheck->id => ['weight' => $weight],
                    ]);
                }
            }

        }
    }
}
