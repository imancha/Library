<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookRacksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('book_racks', function(Blueprint $table)
		{
			$table->char('book_id', 10);
			$table->integer('rack_id')->unsigned();
			$table->timestamps();
			$table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
			$table->foreign('rack_id')->references('id')->on('racks')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('book_racks');
	}

}
