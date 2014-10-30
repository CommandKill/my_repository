<?php

class CarbaseYear extends \Eloquent {
	protected $fillable = [];
	protected $table = 'carbase_years';
	public $timestamps = false;
	
	protected $guarded = array('id');
}