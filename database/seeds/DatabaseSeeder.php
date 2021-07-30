<?php

use Illuminate\Database\Seeder;
use App\Step;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $this->call([
            MembershipTableSeeder::class,
            ProductTableSeeder::class,
            IngredientTableSeeder::class,
            RecipeTableSeeder::class,
            NutrientsSeeder::class,
            UsersTableSeeder::class,
            HelpArticleSeeder::class,
        ]);

        // Get all the products attaching up to 2 random products to each recipe
        $products = App\Product::all();

        // Populate the pivot table
        App\Recipe::all()->each(function ($recipe) use ($products) {
            $recipe->products()->attach(
                $products->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        // Get all the ingredients attaching from 2 up to 5 random ingredients to each recipe
        $ingredients = App\Ingredient::all();

        $ingredient_types = ['', 'tablespoon', 'teaspoon', 'gram'];

        // Populate the pivot table
        App\Recipe::all()->each(function ($recipe) use ($ingredients, $ingredient_types) {
            $recipe_ingredients = $ingredients->random(rand(2, 5))->pluck('id');

            $recipe_ingredients->each(function ($recipe_ingredient) use ($recipe, $ingredient_types) {
                $recipe->ingredients()->attach(
                    $recipe_ingredient, [
                        'count_imperial' => rand(1, 100),
                        'count_metric'   => rand(1, 100),
                        'type_imperial'  => $ingredient_types[rand(0, count($ingredient_types) - 1)],
                        'type_metric'    => $ingredient_types[rand(0, count($ingredient_types) - 1)],
                    ]
                );
            });
        });

        // Get all the ingredients attaching from 2 up to 5 random ingredients to each recipe
        $nutrients = App\Nutrient::all();

        // Populate the pivot table
        App\Recipe::all()->each(function ($recipe) use ($nutrients) {
            $recipe_nutrients = $nutrients->random(rand(2, 4))->pluck('id');

            $recipe_nutrients->each(function ($recipe_nutrient) use ($recipe) {
                $recipe->nutrients()->attach(
                    $recipe_nutrient, [
                        'weight' => rand(1, 50)
                    ]
                );
            });
        });

        $faker = \Faker\Factory::create();

        // Populate the step table data
        App\Recipe::all()->each(function ($recipe) use($faker) {
            $step_number = random_int(2, 5);
            for ($i=0; $i < $step_number; $i++) { 
                $step = new Step();
                $step->recipe()->associate($recipe);
                $step->content = $faker->paragraph(15);
                $step->save();
            }
        });
    }
}
