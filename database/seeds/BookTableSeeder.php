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
				//	Seed publisher table
				$publisher = 	Model\Publisher::firstOrCreate([
					'nama'	=>	(empty($result->penerbit) ? '-' : $result->penerbit)
				]);

				//	Seed subject table
				$subject = 	Model\Subject::firstOrCreate([
					'nama'	=>	(empty($result->subyek) ? '-' : $result->subyek)
				]);

				//	Seed rack table
				$rack = Model\Rack::firstOrCreate([
					'nama'	=>	(empty($result->rak) ? '-' : $result->rak)
				]);

				//	Seed author table
				$author = Model\Author::firstOrCreate([
					'nama'	=>	(empty($result->pengarang) ? '-' : $result->pengarang)
				]);

				//	Seed book table
				$book = Model\Book::create([
					'id'		=>	$result->kode_buku,
					'judul'	=>	$result->judul_buku,
					'edisi'	=>	$result->edisi,
					'jenis'	=>	$result->jenis,
					'tanggal_masuk'	=>	$result->tanggal_masuk,
					'keterangan'		=>	(empty($result->keterangan) ? '' : $result->keterangan),
					'publisher_id'	=>	$publisher->id,
					'subject_id'		=>	$subject->id,
					'rack_id'				=>	$rack->id,
				]);

				//	Seed book_authors table
				Model\BookAuthor::create([
					'book_id'		=>	$result->kode_buku,
					'author_id'	=>	$author->id,
				]);

				sleep(1);
			}

		});
	}
}
