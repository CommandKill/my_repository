<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePeopleDatabase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscribers', function($table) {
	        $table->increments('id');
	        $table->string('name');
			$table->string('email');
			
			$table->tinyInteger('status');

	        $table->timestamps();
		});

		// alter more fields to users table
		Schema::table('users', function(Blueprint $table)
        {
            $table->string('avatar')->after('password');
        });

		Schema::create('members', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('facebook_id')->nullable();
			$table->string('username', 20);
			$table->string('email', 100);
			$table->string('email_secondary', 100);//use for recovery password when forgot email address
			$table->string('password', 80);
			// $table->string('name')->nullable();
			$table->string('first_name', 50)->nullable();
			$table->string('last_name', 50)->nullable();
			$table->string('gender', 10)->nullable();
			$table->string('facebook_link', 100)->nullable();
			$table->string('line_id', 20)->nullable();
			$table->string('locale', 10)->nullable();
			$table->string('timezone', 20)->nullable();
			$table->tinyInteger('receive_newsletter');
			$table->string('avatar', 50)->nullable();

			$table->enum('type', array('dealer', 'individual'))->default('individual');

			$table->tinyInteger('status');
			$table->tinyInteger('public_email'); //if this == false then will not show to public

			$table->integer('req_resetpwd');
			$table->string('req_resetpwd_code');
			$table->datetime('req_resetpwd_expire');

			$table->integer('verified');
			$table->string('verified_code');
			$table->datetime('verified_expire');

			$table->string('address')->nullable();
			$table->string('phone')->nullable();

			$table->float('latitude',16,13);
			$table->float('longitude',16,13);

			$table->integer('view');

			$table->string('about_me')->nullable();
			$table->string('facebook_account')->nullable();
			$table->string('twitter_account')->nullable();

			$table->integer('province_id');
			$table->integer('amphur_id');
			$table->integer('district_id');
			$table->integer('zipcode_id');

			$table->tinyInteger('use_current_location');

			
		});

		Schema::create('members_saves_search', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('member_id')->nullable();
			$table->string('query')->nullable();
			$table->string('verified')->nullable();
			$table->string('car_type')->nullable();
			$table->string('car_transmission')->nullable();
			$table->string('car_fuel')->nullable();
			$table->string('car_door')->nullable();
			$table->string('car_engine')->nullable();
			$table->string('mileage')->nullable();
			$table->string('car_colors')->nullable();
			$table->string('distance')->nullable();
			$table->string('max_price')->nullable();
			$table->string('min_price')->nullable();
			$table->string('car_model')->nullable();
			$table->string('car_year')->nullable();
			$table->integer('province')->nullable();
			$table->integer('amphur')->nullable();
			$table->integer('district')->nullable();
			$table->tinyInteger('report_to_email');

			$table->string('car_make')->nullable();

			$table->integer('result_count')->nullable();
			$table->string('result_ids')->nullable();
		});

		Schema::create('members_bookmarks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('member_id');
			$table->integer('post_id');
		});

		Schema::create('security_history', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->string('action');
			$table->string('description');
			$table->string('ip');
			$table->string('agent');
		});

		Schema::create('session', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->string('ip');
			$table->string('agent');
			$table->string('signed_at');
			$table->string('location');
			$table->string('member_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('members_bookmarks');
		Schema::drop('members_saves_search');
		Schema::drop('security_history');
		Schema::drop('session');
		Schema::drop('subscribers');
		Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('avatar');
        });
		Schema::drop('members');
	}

}
