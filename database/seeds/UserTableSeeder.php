// app/database/seeds/UserTableSeeder.php

<?php

class UserTableSeeder extends Seeder
{

public function run()
{
    DB::table('users')->delete();
    User::create(array(
		'username' => 'zdiggins',
        'email'    => 'zdiggins@gmail.com',
        'first'    => 'Zachary',
        'last'     => 'Diggins',
        'password' => Hash::make('pass'),
		'level'	   => 'admin',
		'validated'=> 'true',
    ));
    User::create(array(
		'username' => 'scmcwilliams',
        'email'    => 'scott@cjtinc.org',
        'first'    => 'Scott',
        'last'     => 'McWilliams',
        'password' => Hash::make('XYAxekU6uk'),
		'level'	   => 'admin',
		'validated'=> 'true',
    ));
	/*User::create(array(
		'username' => 'staff1',
        'email'    => 'staff@test.com',
        'password' => Hash::make('pass'),
		'level'	   => 'staff',
    ));
	User::create(array(
		'username' => 'user1',
        'email'    => 'user@test.com',
        'password' => Hash::make('pass'),
		'level'	   => 'user',
		'first'    => 'Zachary',
		'last' 	   => 'Diggins',
		'address'  => '7439 Hwy 70 S Apt 289',
		'city'	   => 'Nashville',
		'zip'      => '37221',
		'state'    => 'TN',
		'phone'    => '205-913-3860', 
    ));
	
		User::create(array(
		'username' => 'jay',
        'email'    => 'jay@test.com',
        'password' => Hash::make('pass'),
		'level'	   => 'user',
		'first'    => 'Jay',
		'last' 	   => 'Pritchett',
		'address'  => '70 Some Street',
		'city'	   => 'Los Angeles',
		'zip'      => '99999',
		'state'    => 'CA',
		'phone'    => '123-456-7890', 
    ));
	
	DB::table('children')->delete();
	Child::create(array(
        'name'    => 'Johnny Boy',
		'userID'  => 3,
    ));
	Child::create(array(
        'name'    => 'Manny',
		'userID'  => 4,
    ));
	Child::create(array(
        'name'    => 'Joe',
		'userID'  => 4,
    ));
	
	DB::table('recordings')->delete();
	Recording::create(array(
        'childID'    => 1,
		'sessionID'    => 1,
		'bookName'   => 'Welcome to new york',
		'ISBN'       => '9780007324538',
    ));
	Recording::create(array(
		'childID'    => 2,
		'sessionID'  => 1,
		'bookName'   => 'Blank space',
		'ISBN'       => '9780007324538',
    ));
	Recording::create(array(
        'childID'    => 3,
		'sessionID'  => 1,
		'bookName'   => 'Style',
		'ISBN'       => '9780007324538',
    ));
	
	DB::table('visits')->delete();
	Visit::create(array(
		'coord'		 => 'Test Coordinator',
		'site'		 => 'Test Location',
		'date'		 => '1/1/1111',
		'mothers'	 => '10',
		'fathers'	 => '20',
		'packages'	 => '100',
		'volunteers' => '500',
		'hours'		 => '600',

    ));
    */
}

}
