<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailQueueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_queue', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('app_id')->default(0)->index('app_id');
			$table->string('caption');
			$table->text('email_content');
			$table->text('email_to');
			$table->text('sms_content');
			$table->text('sms_to');
			$table->text('email_cc');
			$table->text('email_subject');
			$table->string('attachment', 200);
			$table->string('attachment_certificate_name', 200);
			$table->string('secret_key', 200);
			$table->string('pdf_type', 10);
			$table->boolean('email_status')->default(0)->index('email_status');
			$table->string('response', 250)->nullable();
			$table->boolean('sms_status')->default(0)->index('sms_status');
			$table->dateTime('sent_on')->nullable();
			$table->integer('cron_id')->nullable();
			$table->integer('no_of_try')->default(0)->index('no_of_try');
			$table->boolean('web_notification')->default(0)->comment('0=unread , 1= read');
			$table->string('others_info', 100)->nullable();
			$table->timestamps(10);
			$table->integer('created_by');
			$table->integer('updated_by');
			$table->integer('template_id')->default(0);
			$table->integer('config_id')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('email_queue');
	}

}
