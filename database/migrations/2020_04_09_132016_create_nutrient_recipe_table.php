<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNutrientRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_nutrient', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->integer('recipe_id')->unsigned();
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');            

            $table->integer('nutrient_id')->unsigned();
            $table->foreign('nutrient_id')->references('id')->on('nutrients')->onDelete('cascade');

            $table->double('weight')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_nutrient');
    }
}
