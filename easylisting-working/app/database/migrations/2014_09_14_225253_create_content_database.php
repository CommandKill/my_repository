<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentDatabase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('slug', 100);
			$table->tinyInteger('status');
		});

		Schema::create('tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('text')->unique();
		});

		Schema::create('posts', function(Blueprint $table)
	    {
	        $table->increments('id');
            $table->timestamps();
			$table->integer('car_category_id');

			$table->tinyInteger('status');
			$table->tinyInteger('promoted');

			$table->datetime('publish');
			$table->date('available_from')->nullable();
			$table->date('available_to')->nullable();
			$table->string('thumbnail', 64)->nullable();

			$table->string('slug', 100);

			// $table->string('car_suggest')->nullable();
   //          $table->integer('car_id')->nullable();
   //          $table->integer('car_styleid')->nullable();
			// $table->integer('car_color')->nullable();
			// $table->string('car_parts')->nullable();
			// $table->string('car_favorite')->nullable();
			// $table->string('car_make')->nullable();
			// $table->string('car_model')->nullable();
			// $table->integer('car_year')->nullable();
			$table->string('ip')->nullable();

			$table->integer('year_id')->nullable();
			$table->integer('make_id')->nullable();
			$table->integer('model_id')->nullable();
			$table->integer('submodel_id')->nullable();
			$table->integer('color_id')->nullable();
			$table->string('parts_ids')->nullable();
			$table->integer('engine_id')->nullable();
			$table->integer('gear_id')->nullable();
			$table->integer('fuel_id')->nullable();

			$table->string('suggest')->nullable();

            $table->integer('price')->nullable();
            $table->integer('mileage')->nullable();
            $table->string('video')->nullable();

            $table->integer('owner_rating')->nullable();
            $table->integer('expert_rating')->nullable();
            $table->string('phone')->nullable();
            $table->string('line_id')->nullable();
            $table->integer('total_images')->nullable();
            $table->integer('total_videos')->nullable();
            $table->integer('total_views')->nullable();
			$table->integer('today_report')->nullable();

            $table->float('latitude',16,13);
            $table->float('longitude',16,13);
			$table->integer('user_info_addr')->nullable();
            $table->string('address')->nullable();

            $table->integer('province_id');
            $table->integer('amphur_id');
            $table->integer('district_id');
            $table->integer('zipcode_id');

            $table->tinyInteger('verified');

            
            $table->integer('delete_reason');

            $table->integer('created_by');
            $table->integer('updated_by');
            // $table->integer('created_by');
            // $table->foreign('created_by')->references('id')->on('users');
            // $table->integer('updated_by');
            // $table->foreign('updated_by')->references('id')->on('users');
	    });

		Schema::create('categories_languages', function(Blueprint $table)
	    {
	        $table->increments('id');
	        $table->integer('category_id');

	        $table->string('title', 255)->nullable();
			$table->text('description')->nullable();
			$table->text('detail')->nullable();
			$table->integer('language_id');
	    });

		Schema::create('posts_languages', function(Blueprint $table)
	    {
	        $table->increments('id');
	        $table->integer('post_id');

	        $table->string('title', 255)->nullable();
			$table->text('description')->nullable();
			$table->text('detail')->nullable();
			$table->integer('language_id');
	    });

	    Schema::create('posts_galleries', function(Blueprint $table)
	    {
	        $table->increments('id');
	        $table->integer('post_id');
	        $table->timestamps();

	        $table->string('name');
			$table->integer('size');
			$table->integer('order');
	    });

	   	Schema::create('posts_tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('post_id');
			$table->string('tag_text');
			// $table->integer('post_id')->unsigned();
			// $table->foreign('post_id')->references('id')->on('posts');
			// $table->integer('tag_id')->unsigned();
        	// $table->foreign('tag_id')->references('id')->on('tags');
		});

		Schema::create('blogs_tags', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('blog_id');
			$table->string('tag_text');
		});

		Schema::create('posts_messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('member_id');
			$table->string('subject', 100)->nullable();
			$table->text('message')->nullable();
			$table->string('phone', 10)->nullable();
			$table->string('email', 20)->nullable();
			$table->string('from', 20)->nullable();
			$table->tinyInteger('status');
		});

		Schema::create('posts_reports_abuses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('post_id');
			$table->integer('member_id')->nullable();
			$table->integer('answer_id');
			$table->string('email')->nullable();
		});

		Schema::create('carbase_submodel_answer', function(Blueprint $table)
		{
			$table->integer('answer_id');
			$table->integer('carbase_submodels_id');
			// $table->integer('sub_model')->unsigned();
			// $table->foreign('sub_model')->references('id')->on('carbase_submodels');
			// $table->integer('answer_id')->unsigned();
   //      	$table->foreign('answer_id')->references('id')->on('answers');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blogs_tags');
		//Schema::dropIfExists('users');
		Schema::drop('posts_reports_abuses');
		Schema::drop('posts_messages');
		Schema::drop('posts_tags');
		Schema::drop('posts_galleries');
		Schema::drop('posts_languages');
		Schema::drop('posts');
		Schema::drop('categories_languages');
		Schema::drop('categories');
		Schema::drop('tags');
	}

}
