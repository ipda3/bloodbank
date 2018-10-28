<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->date('birth_date');
			$table->integer('city_id');
			$table->string('phone');
			$table->date('donation_last_date');
			$table->string('password');
			$table->enum('blood_type', array('O-', 'O+', 'B-', 'B+', 'A+', 'A-', 'AB-', 'AB+'));
			$table->boolean('is_active')->default(1);
			$table->string('api_token',60)->unique()->nullable();
            $table->string('pin_code')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}