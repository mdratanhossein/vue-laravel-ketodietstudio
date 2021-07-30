<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('level',['beginner','intermediate','advanced']);
            $table->integer('duration')->default(0);
            $table->boolean('is_home')->default(0);

            $table->string('icon_file_name')->nullable();
            $table->integer('icon_file_size')->nullable();
            $table->string('icon_content_type')->nullable();
            $table->timestamp('icon_updated_at')->nullable();

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
        Schema::dropIfExists('workouts');
    }
}
