<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAffiliateFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('affiliate_by_user')->nullable();
            $table->foreign('affiliate_by_user')->references('id')->on('users')->onDelete('SET NULL');

            $table->unsignedInteger('affiliate_link_id')->nullable();
            $table->foreign('affiliate_link_id')->references('id')->on('affiliate_links')->onDelete('SET NULL');

            $table->unsignedInteger('affiliate_invite_id')->nullable();
            $table->foreign('affiliate_invite_id')->references('id')->on('affiliate_invites')->onDelete('SET NULL');

            $table->datetime('affiliate_joined_at')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->dropForeign('users_affiliate_by_user_foreign');
           $table->dropForeign('users_affiliate_link_id_foreign');
           $table->dropForeign('users_affiliate_invite_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['affiliate_by_user', 'affiliate_link_id', 'affiliate_invite_id', 'affiliate_joined_at']);
        });
    }
}
