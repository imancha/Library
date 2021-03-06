<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('guest_books', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nama',50);
			$table->string('email',50)->nullable();
			$table->text('komentar');
			$table->timestamp('waktu');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('guest_books');
	}

}
