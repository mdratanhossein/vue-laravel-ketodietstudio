<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_workouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('challenge_id');
            $table->foreign('challenge_id')->references('id')->on('challenges')->onDelete('cascade');
            $table->unsignedBigInteger('workout_id');
            $table->foreign('workout_id')->references('id')->on('workouts')->onDelete('cascade');
            $table->integer('week')->default(0);
            $table->integer('day')->default(0);
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
        Schema::dropIfExists('challenge_workouts');
    }
}
