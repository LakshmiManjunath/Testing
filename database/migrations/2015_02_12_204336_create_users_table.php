<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->string('username', 320);
			$table->string('email', 320);
			$table->string('password', 64);
			$table->string('level', 5);
			$table->string('first', 64);
			$table->string('last', 64);
			$table->string('address', 500);
			$table->string('city', 500);
			$table->string('zip', 500);
			$table->string('state', 500);
			$table->string('phone', 500);
			$table->string('validated',10);
			$table->string('confirmationCode',50);
			$table->string('firstTimePass',20);
			$table->string('forcePassChange',10);
			$table->string('resetCode',50);
		
			$table->timestamps();
			$table->rememberToken();
		});
		
		Schema::create('children', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->string('name', 320);
			$table->string('parentName', 320);
			$table->integer('userID');
			$table->string('age',500);
			
			$table->timestamps();
			$table->rememberToken();
		});
		
		Schema::create('recordings', function(Blueprint $table)
		{
			$table->increments('id');
			
			$table->integer('childID');
			$table->integer('sessionID');
			$table->string('bookName', 500);
			$table->string('ISBN', 500);
			$table->string('filename', 100);
			$table->string('delivery',500);
			$table->string('postageStatus',500);
			$table->string('postageURL',500);
			$table->string('trackingNumber',500);
			
			$table->timestamps();
			$table->rememberToken();
		});
		
		Schema::create('visits', function(Blueprint $table)
		{

			
			$table->increments('id');
			
			
			$table->string('coord', 500);
			$table->string('site', 500);
			$table->string('date', 500);
			$table->string('mothers', 500);
			$table->string('fathers', 500);
			$table->string('packages', 500);
			$table->string('volunteers', 500);
			$table->string('hours', 500);
			$table->string('delivery',500);

			$table->string("mailLocationNum",500);
			$table->string('mailAddress',500);
			$table->string('mailCity',500);
			$table->string('mailState',500);
			$table->string('mailZip',500);
			
			$table->timestamps();
			$table->rememberToken();
		});
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
		Schema::drop('children');
		Schema::drop('recordings');
		Schema::drop('visits');
	}
}
