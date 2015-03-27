<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function(Blueprint $table)
		{
			$table->char('id', 10);
			$table->string('judul');
			$table->char('edisi', 4);
			$table->enum('jenis', ['ASLI','PKL']);
			$table->date('tanggal_masuk');
			$table->string('keterangan')->default('');
			$table->boolean('file')->default(0);
			$table->integer('publisher_id')->unsigned();
			$table->integer('subject_id')->unsigned();
			$table->integer('rack_id')->unsigned();
			$table->primary('id');
			$table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('cascade');
			$table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
			$table->foreign('rack_id')->references('id')->on('racks')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('books');
	}

}
