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
			$table->timestamp('waktu_pinjam');
			$table->timestamp('waktu_kembali')->nullable();
			$table->enum('status',['peminjaman/dipinjam','pengembalian/tersedia'])->default('peminjaman/dipinjam');
			$table->char('member_id',15);
			$table->char('book_id',10);
			$table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade')->onDelete('cascade');
			$table->foreign('book_id')->references('id')->on('books')->onUpdate('cascade')->onDelete('cascade');
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
