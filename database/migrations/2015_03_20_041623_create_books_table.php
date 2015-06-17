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
			$table->char('id', 255);
			$table->string('judul');
			$table->char('tahun', 4);
			$table->enum('jenis', ['asli','pkl']);
			$table->timestamp('tanggal_masuk');
			$table->text('keterangan')->default('');
			$table->integer('publisher_id')->unsigned();
			$table->integer('subject_id')->unsigned();
			$table->integer('rack_id')->unsigned();
			$table->primary('id');
			$table->foreign('publisher_id')->references('id')->on('publishers')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('subject_id')->references('id')->on('subjects')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('rack_id')->references('id')->on('racks')->onUpdate('cascade')->onDelete('cascade');
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
