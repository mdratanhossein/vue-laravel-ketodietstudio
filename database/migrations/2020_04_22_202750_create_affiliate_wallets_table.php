<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_wallets', function (Blueprint $table) {
            $table->increments('id')->unsigned();

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('sales')->default(0);
            $table->decimal('money_withdrawn', '15', '2')->default('0.00');
            $table->decimal('money_earned', '15', '2')->default('0.00');
            $table->decimal('money_current', '15', '2')->default('0.00');

            $table->integer('payout_minimum')->unsigned()->default('60');

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
        Schema::dropIfExists('affiliate_wallets');
    }
}
