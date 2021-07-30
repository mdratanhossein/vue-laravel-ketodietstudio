<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_clicks', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('affiliate_link_id');
            $table->foreign('affiliate_link_id')->references('id')->on('affiliate_links')->onDelete('cascade');
            $table->string('referer')->nullable();
            $table->string('useragent')->nullable();
            $table->string('ip')->nullable();
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
        Schema::dropIfExists('affiliate_clicks');
    }
}
