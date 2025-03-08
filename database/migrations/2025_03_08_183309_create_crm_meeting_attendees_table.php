<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmMeetingAttendeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('crm_meeting_attendees', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('meeting_id')->nullable()->index('meeting_id');
			$table->integer('contact_id')->default(0)->index('contact_id');
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
		Schema::drop('crm_meeting_attendees');
	}

}
