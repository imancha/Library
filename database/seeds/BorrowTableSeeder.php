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
		DB::table('members')->delete();
		DB::table('borrows')->delete();

		for($i=1;$i<=100;$i++){
			$id = rand(1111111111,9999999999);
			$name = str_shuffle('mohammad abdul iman syah');
			DB::table('members')->insert([
				'id' => $id,
				'nama' => $name,
				'waktu' => date('Y-m-d H:i:s', strtotime("-".(rand(1,$i+10))." days")),
			]);
			$date = date('Y-m-d H:i:s', strtotime("-".(rand(1,$i+5))." days"));
			for($j=1;$j<=rand(1,9);$j++){
				$book = DB::table('books')->orderBy(DB::raw('RAND()'))->take(1)->get(['books.id']);
				DB::table('borrows')->insert([
					'id' => 'P'.$i,
					'waktu_pinjam' => $date,
					'member_id' => $id,
					'book_id' => $book[0]->id,
				]);
			}
		}
	}

}
