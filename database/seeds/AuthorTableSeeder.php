<?php

use Illuminate\Database\Seeder;
use App\Model;

class AuthorTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('authors')->delete();

		Excel::load('database/seeds/xls/Books.xls', function($reader)
		{
			$results = $reader->get();

			foreach($results as $result)
			{
				if(!empty($result->pengarang))
				{
					Model\Author::firstOrCreate([
						'nama'	=>	$result->pengarang,
					]);
				}
			}

		});
	}

}
