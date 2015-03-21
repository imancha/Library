<?php

use Illuminate\Database\Seeder;
use App\Model;

class SubjectTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('subjects')->delete();

		Excel::load('database/seeds/xls/Books.xls', function($reader)
		{
			$results = $reader->get();

			foreach($results as $result)
			{
				if(!empty($result->subyek))
				{
					Model\Subject::firstOrCreate([
						'nama'	=>	$result->subyek,
					]);
				}
			}

		});
	}

}
