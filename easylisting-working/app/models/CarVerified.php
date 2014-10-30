<?php

class CarVerified extends \Eloquent {

	protected $fillable = [];
	protected $table = 'car_owner_verified';
    protected $guarded = array('id');
    // public $timestamps = false;

    public function post(){
        return $this->hasOne('Post');
    }

}