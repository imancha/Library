<?php

use App\Model\Author;
use App\Model\Book;
use App\Model\BookAuthor;
use App\Model\Publisher;
use App\Model\Rack;
use App\Model\Subject;

use Illuminate\Database\Seeder;

class BookTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('books')->delete();

		Excel::load('database/Books.xls', function($reader)
		{
			$results = $reader->get();

			foreach($results as $result)
			{
				//	Seed publisher table
				$publisher = 	Publisher::firstOrCreate([
					'nama'	=>	(empty($result->penerbit) ? '-' : $result->penerbit)
				]);

				//	Seed subject table
				$subject = 	Subject::firstOrCreate([
					'nama'	=>	(empty($result->subyek) ? '-' : $result->subyek)
				]);

				//	Seed rack table
				$rack = Rack::firstOrCreate([
					'nama'	=>	(empty($result->rak) ? '-' : $result->rak)
				]);

				//	Seed author table
				$author = Author::firstOrCreate([
					'nama'	=>	(empty($result->pengarang) ? '-' : $result->pengarang)
				]);

				//	Seed book table
				$book = Book::create([
					'id'		=>	$result->kode_buku,
					'judul'	=>	$result->judul_buku,
					'tahun'	=>	$result->edisi,
					'jenis'	=>	strtolower($result->jenis),
					'tanggal_masuk'	=>	substr($result->tanggal_masuk,0,10).' '.date('H:i:s'),
					'keterangan'		=>	(empty($result->keterangan) ? '' : $result->keterangan),
					'publisher_id'	=>	$publisher->id,
					'subject_id'		=>	$subject->id,
					'rack_id'				=>	$rack->id,
				]);

				//	Seed book_authors table
				BookAuthor::create([
					'book_id'		=>	$result->kode_buku,
					'author_id'	=>	$author->id,
				]);
			}

		});
	}
}
