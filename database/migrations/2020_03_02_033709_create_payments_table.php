<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->string('payment_id')->index();

            $table->boolean('method'); // Payment method => 0:paypal, 1:stripe
            $table->string('email'); // Payment linked email
            
            $table->double('amount'); // Payment amount
            $table->string('currency'); // Payment currency

            $table->text('detail'); // Payment detail content

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
        Schema::dropIfExists('payments');
    }
}
