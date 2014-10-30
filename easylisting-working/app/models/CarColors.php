<?php

class CarColors extends \Eloquent {
	protected $fillable = [];
	protected $table = 'cars_colors';

    protected $guarded = array('id');

    public function car(){
        return $this->belongsTo('CarVehicle');
    }
}