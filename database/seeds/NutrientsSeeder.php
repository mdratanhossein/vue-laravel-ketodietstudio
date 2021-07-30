<?php

use Illuminate\Database\Seeder;

class NutrientsSeeder extends Seeder
{
    const NUTRIENTS = [
        'Proteins',
        'Carbohydrates',
        'Fats',
        'Sugar',
        'Fiber',
        'Fructose',
        'Lactose',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::NUTRIENTS as $NUTRIENT) {
            \App\Nutrient::create([
                'name' => $NUTRIENT
            ]);
        }
    }
}
