<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();

		DB::table('users')->insert([
			[
				'name'			=>	'Mohammad Abdul Iman Syah',
				'email'			=>	'kabag@imail.com',
				'password'	=>	bcrypt('imancha'),
				'status'		=>	'kabag',
			],
			[
				'name'			=>	'Mohammad Abdul Iman Syah',
				'email'			=>	'staff@imail.com',
				'password'	=>	bcrypt('imancha'),
				'status'		=>	'staff',
			]
		]);
	}

}
