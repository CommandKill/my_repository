<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionaireDatabase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questionaires', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->integer('created_by');
			$table->integer('updated_by');

			$table->string('name');

			$table->datetime('available_from');
			$table->datetime('available_to');

			$table->tinyInteger('status');
		});

		Schema::create('questionaires_languages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('questionaire_id');
			$table->timestamps();

			$table->string('name');
			$table->integer('language_id');
		});

		Schema::create('questions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('questionaire_id');
			$table->timestamps();

			$table->integer('weigth');

			//$table->string('illustration')->nullable();

			$table->tinyInteger('status');
		});

		Schema::create('answers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('question_id');
			$table->timestamps();

			$table->integer('weigth');
			$table->string('illustration')->nullable();
			$table->enum('answer_type', Config::get('site.answer_type'));

			$table->tinyInteger('status');
		});

		// Schema::create('car_answer', function(Blueprint $table)
		// {
		// 	$table->integer('car_id')->unsigned();
		// 	$table->foreign('car_id')->references('id')->on('cars');
		// 	$table->integer('answer_id')->unsigned();
  //       	$table->foreign('answer_id')->references('id')->on('answers');
		// });


		Schema::create('questions_languages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('question_id');
			$table->timestamps();

			$table->string('title');
			$table->integer('language_id');
		});

		Schema::create('answers_languages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('answer_id');
			$table->timestamps();

			$table->string('title');
			$table->integer('language_id');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		// Schema::drop('car_answer');
		Schema::drop('answers_languages');
		Schema::drop('questions_languages');
		Schema::drop('answers');
		Schema::drop('questions');
		Schema::drop('questionaires_languages');
		Schema::drop('questionaires');
	}

}
