<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->unsignedInteger('payment_id')->nullable();
			$table->foreign('payment_id','fk_user_payment')->references('id')->on('payments');

            $table->unsignedInteger('membership_id')->nullable();            
            $table->foreign('membership_id','fk_user_membership')->references('id')->on('memberships');
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropForeign('fk_user_payment');
			$table->dropForeign('fk_user_membership');
		});
	}

}
