<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id');
			$table->string('title');
			$table->text('content');
			$table->string('thumbnail')->nullable();
			$table->date('publish_date');
			$table->integer('category_id');
			//
            // git change
		});
	}

	public function down()
	{
		Schema::drop('posts');
	}
}