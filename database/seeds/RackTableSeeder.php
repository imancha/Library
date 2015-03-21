<?php

use Illuminate\Database\Seeder;
use App\Model;

class RackTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('racks')->delete();

		Excel::load('database/seeds/xls/Books.xls', function($reader)
		{
			$results = $reader->get();

			foreach($results as $result)
			{
				if(!empty($result->rak))
				{
					Model\Rack::firstOrCreate([
						'nama'	=>	$result->rak,
					]);
				}
			}

		});
	}

}
