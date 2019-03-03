<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDonationRequestsTable extends Migration {

	public function up()
	{
		Schema::create('donation_requests', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id');
			$table->string('patient_name');
			$table->integer('patient_age');
            $table->integer('blood_type_id');
			$table->integer('bags_num');
			$table->string('hospital_name');
			$table->string('hospital_address');
			$table->integer('city_id');
			$table->string('phone');
			$table->text('notes')->nullable();
			$table->double('latitude', 10,10)->nullable();
			$table->double('longitude', 10,10)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('donation_requests');
	}
}