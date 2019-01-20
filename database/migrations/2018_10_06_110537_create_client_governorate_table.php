<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientGovernorateTable extends Migration {

	public function up()
	{
		Schema::create('client_governorate', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('governorate_id');
			$table->integer('client_id');
		});
	}

	public function down()
	{
		Schema::drop('client_governorate');
	}
}