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
			$table->string('nama');
			$table->date('tanggal_lahir');
			$table->enum('jenis_kelamin', ['Laki-Laki','Perempuan']);
			$table->enum('jenis_anggota', ['Karyawan','Non-Karyawan']);
			$table->char('phone',12)->default('');
			$table->text('alamat')->default('');
			$table->text('keterangan')->default('');
			$table->primary('id');
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
		Schema::drop('members');
	}

}
