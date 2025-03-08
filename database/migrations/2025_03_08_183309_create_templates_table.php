<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('templates', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('caption', 765)->nullable();
			$table->string('email_subject', 765)->nullable();
			$table->text('email_content')->nullable();
			$table->boolean('email_active_status')->nullable();
			$table->string('email_cc', 765)->nullable();
			$table->string('sms_content', 765)->nullable();
			$table->boolean('sms_active_status')->nullable();
			$table->boolean('is_archive')->nullable();
			$table->timestamps(10);
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('templates');
	}

}
