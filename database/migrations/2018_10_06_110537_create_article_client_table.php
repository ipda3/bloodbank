<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleClientTable extends Migration {

	public function up()
	{
		Schema::create('article_client', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id');
			$table->integer('post_id');
		});
	}

	public function down()
	{
		Schema::drop('article_client');
	}
}