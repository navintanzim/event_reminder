<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmMeetingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('crm_meeting', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('tracking_no', 150)->nullable();
			$table->string('caption', 150)->nullable();
			$table->string('agenda')->nullable();
			$table->dateTime('start_dt')->nullable();
			$table->string('duration', 50)->nullable();
			$table->string('location')->nullable();
			$table->enum('status', array('Held','Planned','Posponded','Cancelled'))->nullable();
			$table->string('outcome', 100)->nullable();
			$table->string('description')->nullable();
			$table->integer('assigned_to')->nullable()->index('assign_to');
			$table->integer('reminder_time')->nullable();
			$table->boolean('is_reminder')->nullable()->default(0);
			$table->boolean('deleted')->nullable()->default(0)->index('deleted');
			$table->timestamps(10);
			$table->integer('created_by')->nullable()->index('created_by');
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
		Schema::drop('crm_meeting');
	}

}
