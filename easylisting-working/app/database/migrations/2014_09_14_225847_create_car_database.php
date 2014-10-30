<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCarDatabase extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('carbase_makes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('make');
			$table->integer('car_avaliable');
		});

		Schema::create('carbase_models', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('model');
			$table->integer('make_id');
			$table->string('make');
			$table->integer('car_avaliable');
		});

		Schema::create('carbase_submodels', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sub_model');
			$table->integer('model_id');
			$table->integer('car_avaliable');
		});

		Schema::create('carbase_years', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('year');
			$table->integer('car_avaliable');
		});

		Schema::create('carbase_parts', function(Blueprint $table)
		{
			$table->increments('id');
		});

		Schema::create('carbase_parts_languages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('parts_id');
            $table->integer('language_id');
            $table->string('title');
		});

		Schema::create('carbase_engines', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('size');
		});

		Schema::create('carbase_gears', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('gear');
		});

		Schema::create('carbase_bodies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('body');
		});

		Schema::create('carbase_fuels', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type');
		});

		Schema::create('carbase_colors', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('color');
		});

		Schema::create('cars_vehicles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('styleId');
			$table->string('year');
			$table->string('make');
			$table->string('model');
			$table->string('trim');
			$table->string('trimShort');
			$table->string('trimLong');
			$table->string('vehicle');
			$table->string('condition');
			$table->string('vehicleType');
			$table->string('vehicleSize');
			$table->string('vehicleStyle');
			$table->string('vehicleCategory');
			$table->string('market');
			$table->string('performance');
			$table->string('luxury');
			$table->string('engineCylinder');
			$table->string('engineSize');
			$table->string('engineForcedInduction');
			$table->string('engineFuelType');
			$table->string('drivenWheels');
			$table->string('transmissionType');
			$table->string('transmissionGears');
			$table->string('whereBuilt');
			$table->string('manufactureCode');
			$table->string('acceleration_0to60');
			$table->string('curbWeight');
			$table->string('grossWeight');
			$table->string('numberOfDoors');
			$table->string('fuelCapacity');
			$table->string('mpgCity');
			$table->string('mpgHighway');
			$table->string('mpgCombined');
			$table->string('price_baseMSRP');
			$table->string('price_baseInvoice');
			$table->string('price_usedRetail');
			$table->string('price_usedPrivateParty');
			$table->string('price_deliveryCharges');
		});

		Schema::create('cars_colors', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('styleId');
            $table->string('colorType');
            $table->string('colorName');
            $table->string('colorR');
            $table->string('colorG');
            $table->string('colorB');
            $table->string('colorRGB');
            $table->string('colorHEX');
            $table->string('optionCode');
		});

		Schema::create('cars_engines', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('styleId');
            $table->string('compressionRatio');
            $table->string('compressionType');
            $table->string('horsepower');
            $table->string('name');
            $table->string('code');
            $table->string('totalValves');
            $table->string('fuelType');
            $table->string('torque');
            $table->string('cylinder');
            $table->string('size');
            $table->string('displacement');
            $table->string('configuration');
            $table->string('type');
		});

		Schema::create('cars_options', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('styleId');
            $table->string('manufactureOptionName');
            $table->string('price');
            $table->string('equipmentType');
            $table->string('availability');
            $table->string('name');
            $table->string('category');
            $table->string('manufactureOptionCode');
            $table->string('description');
		});

		Schema::create('cars_vehicles_partslists', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('part');
		});

		Schema::create('cars_vins', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('styleId');
            $table->string('vin');
		});

		Schema::create('cars_equipments', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('styleId');
            $table->string('optionType');
            $table->string('optionGroup');
            $table->string('optionName');
            $table->string('optionValue');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('carbase_parts');
		Schema::drop('carbase_parts_languages');
		Schema::drop('carbase_bodies');
		Schema::drop('cars_equipments');
		Schema::drop('cars_vins');
		Schema::drop('cars_vehicles_partslists');
		Schema::drop('cars_options');
		Schema::drop('cars_engines');
		Schema::drop('cars_vehicles');
		Schema::drop('cars_colors');
		Schema::drop('carbase_makes');
		Schema::drop('carbase_models');
		Schema::drop('carbase_submodels');
		Schema::drop('carbase_years');
		Schema::drop('carbase_engines');
		Schema::drop('carbase_gears');
		Schema::drop('carbase_fuels');
		Schema::drop('carbase_colors');
		Schema::drop('carbase_submodel_answer');
	}

}
