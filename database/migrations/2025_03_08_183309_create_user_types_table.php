<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_types', function(Blueprint $table)
		{
			$table->string('id', 10)->primary();
			$table->string('type_name');
			$table->string('signup_type_id', 10)->default('0');
			$table->integer('is_registrable')->comment('1 = created by system admin, 2 = from signup, 3 = both');
			$table->string('access_code', 10);
			$table->text('permission_json')->nullable();
			$table->enum('status', array('active','inactive'))->default('inactive');
			$table->string('delegate_to_types', 40);
			$table->integer('security_profile_id')->default(1)->index('security_profile_id');
			$table->enum('auth_token_type', array('optional','mandatory'))->nullable()->default('optional');
			$table->string('user_manual_name')->nullable();
			$table->string('db_access_data')->nullable();
			$table->boolean('is_default')->nullable()->default(0);
			$table->timestamps(10);
			$table->integer('created_by');
			$table->integer('updated_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_types');
	}

}
