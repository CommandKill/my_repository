<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDatabaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('texts_languages', function(Blueprint $table)
		{
			$table->increments('id');
			//$table->timestamps();
			$table->integer('language_id');
			$table->string('key', 50);
            $table->text('value')->nullable();
            // $table->string('input_type', 20)->nullable();
            $table->enum('input_type', array('text', 'textarea', 'editor'))->default('text');
            $table->string('module', 20)->nullable();
            $table->string('input_option', 255)->nullable();
            $table->integer('autoload');
		});

		Schema::create('languages', function($table)
	    {
	        $table->increments('id');
	        $table->string('code', 10)->unique();
	        $table->tinyInteger('status');
	        $table->timestamps();
	        
			$table->string('short_code', 10)->nullable();
	        $table->string('title', 10)->nullable();
	    });

		Schema::create('settings', function(Blueprint $table) 
		{
            $table->string('key', 50)->unique();
            $table->text('value')->nullable();
            $table->tinyInteger('autoload');
            $table->string('module', 20)->nullable();
            $table->string('alias', 50)->nullable();
            $table->string('short_desc', 100)->nullable();
            // $table->string('input_type', 20)->nullable();
            $table->enum('input_type', array('text','textarea','editor','option'))->default('text');
            $table->string('input_option', 255)->nullable(); // use '|' for sepperate each option  -> 'option1 | option 2 | option 3'
            $table->string('input_custom', 20)->nullable(); 
            // enter input_custom field == 'customDropdown'
            // and define function in setting controller like this
            // function customDropdown(){
            //	return '<option>-select-</option><option>1</option><option>2</option>'
        	// }
		});

		Schema::create('emails_templates', function($table) {
	        $table->increments('id');
            $table->timestamps();
			$table->tinyInteger('status');
			$table->string('key', 50);

            $table->integer('created_by');// user id
            $table->integer('updated_by');
		});

		Schema::create('emails_templates_languages', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('email_template_id');
            $table->integer('language_id');
            $table->string('subject', 100);
            $table->text('template')->nullable();
		});

		Schema::create('packages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();

			$table->integer('created_by');
			$table->integer('updated_by');

			$table->datetime('available_from');
			$table->datetime('available_to');

			$table->string('name', 100);
			$table->integer('price');

			$table->tinyInteger('status');
		});

		Schema::create('packages_languages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('package_id');
			$table->timestamps();

			$table->string('name');
			$table->integer('language_id');
		});

		Schema::create('packages_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('package_id');
			$table->timestamps();

			$table->string('name');
			$table->string('value');

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
		Schema::drop('texts_languages');
		Schema::drop('packages_details');
		Schema::drop('packages_languages');
		Schema::drop('packages');
		Schema::drop('emails_templates_languages');
		Schema::drop('emails_templates');
		Schema::drop('settings');
		Schema::drop('languages');	
	}

}
