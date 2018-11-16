<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i = 1;$i <= 3; $i++){
			\App\User::create([ 
				'first_name' => 'User'.$i,
				'last_name' => 'User'.$i,
				'name' => 'User'.$i,
				'email' => 'user'.$i.'@gmail.com',
				'password' => bcrypt('123456')]);
		}
    }
}
