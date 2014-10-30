<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannerDatabase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banners', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('page_id');
            $table->integer('position_id');
            $table->integer('file_id');
			$table->date('available_from')->nullable();
			$table->date('available_to')->nullable();
			$table->tinyInteger('status');
			$table->integer('view')->nullable();
			$table->integer('click')->nullable();
			$table->text('link');
            $table->integer('created_by');
			$table->integer('updated_by');
			$table->timestamps();
		});

		Schema::create('banners_pages', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('name');
            $table->integer('created_by');
			$table->integer('updated_by');
			$table->timestamps();
		});

		Schema::create('banners_positions', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('name');
			$table->string('banner_size');
            $table->integer('created_by');
			$table->integer('updated_by');
			$table->timestamps();
		});

		Schema::create('banners_files', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('name');
			$table->string('size');
			$table->enum('content_type', array('image', 'flash'));
            $table->integer('created_by');
			$table->integer('updated_by');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('banners');
		Schema::drop('banners_files');
		Schema::drop('banners_positions');
		Schema::drop('banners_pages');
	}

}
