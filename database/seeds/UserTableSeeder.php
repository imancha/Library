<?php

use App\User;

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

		User::create(
		[
			'name'			=>	'Mohammad Abdul Iman Syah',
			'email'			=>	'admin@email.com',
			'password'	=>	bcrypt('imancha'),
			'status'		=>	'kabag',
		],
		[
			'name'			=>	'Mohammad Abdul Iman Syah',
			'email'			=>	'administrator@email.com',
			'password'	=>	'imancha',
			'status'		=>	'staff',
		]);
	}

}
