<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeIngredientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_ingredient', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->integer('recipe_id')->unsigned();
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');

            $table->integer('ingredient_id')->unsigned();
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');

            $table->double('count_metric')->unsigned();
            $table->double('count_imperial')->unsigned();
            $table->string('type_metric')->nullable();
            $table->string('type_imperial')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_ingredient');
    }
}
