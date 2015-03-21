<?php

use Illuminate\Database\Seeder;
use App\Model;

class BookTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('books')->delete();

		Excel::load('database/seeds/xls/Books.xls', function($reader)
		{
			$results = $reader->get();

			foreach($results as $result)
			{
				Model\Book::create([
					'id'		=>	$result->kode_buku,
					'judul'	=>	$result->judul_buku,
					'edisi'	=>	$result->edisi,
					'jenis'	=>	$result->jenis,
					'tanggal_masuk'	=>	$result->tanggal_masuk,
					'keterangan'		=>	$result->keterangan,
				]);
			}

		});
	}
}
