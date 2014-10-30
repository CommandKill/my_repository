<?php

class CarParts extends \Eloquent {
	protected $fillable = [];
	protected $table = 'cars_vehicles_partslists';

    protected $guarded = array('id');
}