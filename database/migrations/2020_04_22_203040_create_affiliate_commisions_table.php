<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateCommisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_commisions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('user_buyer_id');
            $table->foreign('user_buyer_id')->references('id')->on('users')->onDelete('RESTRICT');

            $table->unsignedInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');

            $table->decimal('price', '15', '2')->default('0.00');
            $table->unsignedInteger('percentage')->default(0);
            $table->decimal('commision', '15', '2')->default('0.00');

            $table->enum('status',['pending','cancelled','reversed','accepted','paid','unknown'])->default('pending')->index();

            $table->string('event')->nullable()->index();
            $table->string('message')->nullable();

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
        Schema::dropIfExists('affiliate_commisions');
    }
}
