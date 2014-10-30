<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('reviews', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();

            $table->tinyInteger('status');
            $table->tinyInteger('promoted');

            $table->string('slug', 100);
            $table->datetime('publish')->nullable();
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();

            $table->string('thumbnail', 64)->nullable();

            $table->integer('created_by');
            $table->integer('updated_by');
        });

		Schema::create('reviews_languages', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('review_id');
            $table->integer('language_id');
            $table->string('title');
			$table->string('short_desc')->nullable();
            $table->text('body')->nullable();
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
		Schema::drop('reviews');
		Schema::drop('reviews_languages');
	}
}
