<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookPublishersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_publishers', function(Blueprint $table)
		{
			$table->char('book_id', 10);
			$table->integer('publisher_id')->unsigned();
			$table->timestamps();
			$table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
			$table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('book_publishers');
	}

}
