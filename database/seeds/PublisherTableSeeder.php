<?php

use Illuminate\Database\Seeder;
use App\Model;

class PublisherTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('publishers')->delete();

		Excel::load('database/seeds/xls/Books.xls', function($reader)
		{
			$results = $reader->get();

			foreach($results as $result)
			{
				if(!empty($result->penerbit))
				{
					Model\Publisher::firstOrCreate([
						'nama'	=>	$result->penerbit,
					]);
				}
			}

		});
	}

}
