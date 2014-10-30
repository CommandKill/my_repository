<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageDatabaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('pages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();

            $table->tinyInteger('status');

            $table->string('slug', 100);
            $table->datetime('publish')->nullable();
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();

            $table->integer('created_by');
            $table->integer('updated_by');
        });

		Schema::create('pages_languages', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('page_id');
            $table->integer('language_id');
            $table->string('title');
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
		Schema::drop('pages');
		Schema::drop('pages_languages');
	}

}
