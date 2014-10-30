<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeoDatabase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('geography', function(Blueprint $table) {
			$table->increments('id');
            $table->string('name');
		});

		Schema::create('amphur', function(Blueprint $table) {
			$table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->integer('geography_id');
            $table->integer('province_id');
		});

		Schema::create('province', function(Blueprint $table) {
			$table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->integer('geography_id');
		});

		Schema::create('district', function(Blueprint $table) {
			$table->increments('id');
            $table->string('code');
            $table->string('name');

            $table->integer('amphur_id');
            $table->integer('province_id');
            $table->integer('geography_id');
		});

		Schema::create('zipcode', function(Blueprint $table) {
			$table->increments('id');
            $table->string('zipcode');
            $table->string('district_code');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('zipcode');
		Schema::drop('geography');
		Schema::drop('amphur');
		Schema::drop('province');
		Schema::drop('district');

	}

}
