<?php

class CarbaseMake extends \Eloquent {
	protected $fillable = [];
	protected $table = 'carbase_makes';
	public $timestamps = false;
	
	protected $guarded = array('id');

	public function model(){
	    return $this->hasMany('CarbaseModel');
	}
}