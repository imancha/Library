<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookAuthorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_authors', function(Blueprint $table)
		{
			$table->char('book_id', 10);
			$table->integer('author_id')->unsigned();
			$table->foreign('book_id')->references('id')->on('books')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('author_id')->references('id')->on('authors')->onUpdate('cascade')->onDelete('cascade');
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('book_authors');
	}

}
