<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_transactions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('direction', ['plus', 'minus']);
            $table->decimal('amount', '15', '2')->default('0.00');
            $table->decimal('amount_before', '15', '2')->default('0.00');
            $table->decimal('amount_after', '15', '2')->default('0.00');
            $table->unsignedInteger('affiliate_commision_id')->nullable();
            $table->foreign('affiliate_commision_id')->references('id')->on('affiliate_commisions')->onDelete('cascade');

            $table->unsignedInteger('affiliate_payout_id')->nullable();
            $table->foreign('affiliate_payout_id')->references('id')->on('affiliate_payouts')->onDelete('SET NULL');
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
        Schema::dropIfExists('affiliate_transactions');
    }
}
