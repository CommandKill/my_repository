<?php

class CarVehicle extends \Eloquent {
	protected $fillable = [];
	protected $table = 'cars_vehicles';

    protected $guarded = array('id', 'styleId');

    public function colors()
    {
	    return $this->hasMany('CarColors', 'styleId', 'styleId');
	}
}