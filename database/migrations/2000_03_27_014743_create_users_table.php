<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->boolean('role')->default(0); // 1: admin, 0: normal user

            $table->string('name', 50)->nullable();
            $table->string('password')->nullable();

            $table->string('key', 32)->index()->nullable();
            $table->string('email')->nullable();

            $table->datetime('started_at')->nullable();
            $table->boolean('gender')->default(1); // Gender => 0: female, 1: male
            $table->smallInteger('familiar')->default(0); // Familiar Level => 0: beginner, 1: mediate, 2: expert
            $table->smallInteger('preparation')->default(0); // Meal Preparation Level => 0, 1, 2: more than 1 hour

            $table->smallInteger('physical_active')->default(0); // Physical Active Level => 0, 1, 2
            $table->smallInteger('willing_option')->default(0); // Willing Diet Option => 0, 1, 2
            $table->smallInteger('age')->default(0); // Age
            $table->boolean('unit')->default(0); // Unit => 0: imperial, 1: metric
            $table->smallInteger('height_cm')->nullable(); // Height(cm)
            $table->smallInteger('height_ft')->nullable(); // Height(ft)
            $table->smallInteger('height_in')->nullable(); // Height(in)
            $table->smallInteger('weight_kg')->nullable(); // Wegiht(kg)
            $table->smallInteger('weight_lb')->nullable(); // Wegiht(lb)
            $table->smallInteger('target_kg')->nullable(); // Target Weight(kg)
            $table->smallInteger('target_lb')->nullable(); // Target Weight(lb)
            $table->float('bmi', 10, 2)->nullable(); // BMI value
            $table->mediumInteger('calorie')->nullable(); // Calorie
            $table->integer('training_days')->default(3);
            $table->integer('first_day')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
