<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title');              // title

            $table->string('image_file_name')->nullable();
            $table->integer('image_file_size')->nullable();
            $table->string('image_content_type')->nullable();
            $table->timestamp('image_updated_at')->nullable();

            $table->boolean('meal_type')->unsigned();       // type => meal, snack
            $table->integer('prep_time')->nullable();
            $table->integer('cook_time')->nullable();
            $table->integer('total_time')->nullable();
            $table->integer('servings')->nullable();
            $table->integer('energy')->nullable();          // kcal
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
