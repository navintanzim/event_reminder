<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name');
			$table->string('email');
			$table->string('phone')->nullable();
			$table->string('user_type', 25)->default('5x505');
			$table->date('user_DOB')->nullable();
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password')->nullable();
			$table->enum('user_status', array('active','inactive'))->default('active');
			$table->string('remember_token', 100)->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable()->default(0);
			$table->timestamps(10);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
