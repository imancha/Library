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

		App\User::create([
			'name'			=>	'Mohammad Abdul Iman Syah',
			'email'			=>	'imancha_266@ymail.com',
			'password'	=>	bcrypt('imancha'),
		]);
	}

}
