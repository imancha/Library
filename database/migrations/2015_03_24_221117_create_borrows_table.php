<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('borrows', function(Blueprint $table)
		{
			$table->char('id',10);
			$table->date('tanggal_pinjam');
			$table->date('tanggal_kembali')->nullable();
			$table->enum('status',['Dipinjam','Dikembalikan'])->default('Dipinjam');
			$table->char('member_id',15);
			$table->char('book_id',10);
			$table->primary('id');
			$table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
			$table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
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
		Schema::drop('borrows');
	}

}
