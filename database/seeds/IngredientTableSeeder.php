<?php

use Illuminate\Database\Seeder;

class IngredientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Ingredient::class, 32)->create()->each(function($u) {
            $u->save();
        });
    }
}
