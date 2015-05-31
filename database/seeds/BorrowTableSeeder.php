<?php

use Illuminate\Database\Seeder;

class BorrowTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('borrows')->delete();

		for($i=1;$i<=1000;$i++){
			DB::table('borrows')->insert([
				'id' => $i.'P',
				'waktu_pinjam' => new DateTime,
				'member_id' => '10111143',
				'book_id' => '1',
			]);
		}
	}

}
