<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table)
		{
			$table->char('id',15);
			$table->string('nama',50);
			$table->string('tanggal_lahir',50)->default('');
			$table->enum('jenis_kelamin', ['laki-laki','perempuan'])->default('laki-laki');
			$table->enum('jenis_anggota', ['karyawan','non-karyawan'])->default('non-karyawan');
			$table->char('phone',12)->default('');
			$table->text('alamat')->default('');
			$table->text('keterangan')->default('');
			$table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('members');
	}

}
