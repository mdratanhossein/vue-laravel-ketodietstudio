<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->string('video');
            $table->string('image_male_file_name')->nullable();
            $table->integer('image_male_file_size')->nullable();
            $table->string('image_male_content_type')->nullable();
            $table->timestamp('image_male_updated_at')->nullable();

            $table->string('image_female_file_name')->nullable();
            $table->integer('image_female_file_size')->nullable();
            $table->string('image_female_content_type')->nullable();
            $table->timestamp('image_female_updated_at')->nullable();
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
        Schema::dropIfExists('exercises');
    }
}
