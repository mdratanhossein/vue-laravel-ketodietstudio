<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')
            ->insert([
                ['name' => 'chicken', 'type' => 0],
                ['name' => 'pork', 'type' => 0],
                ['name' => 'beef', 'type' => 0],
                ['name' => 'fish', 'type' => 0],
                ['name' => 'lamb', 'type' => 0],
                ['name' => 'veal', 'type' => 0],
                ['name' => 'vegetarian', 'type' => 0],
                ['name' => 'onions', 'type' => 1],
                ['name' => 'mushrooms', 'type' => 1],
                ['name' => 'eggs', 'type' => 1],
                ['name' => 'nuts', 'type' => 1],
                ['name' => 'cheese', 'type' => 1],
                ['name' => 'butter', 'type' => 1],
                ['name' => 'milk', 'type' => 1],
                ['name' => 'avocado', 'type' => 1],
                ['name' => 'seafood', 'type' => 1],
                ['name' => 'olives', 'type' => 1],
                ['name' => 'capers', 'type' => 1],
                ['name' => 'coconut', 'type' => 1],
                ['name' => 'goat-cheese', 'type' => 1]
            ]);
    }
}
