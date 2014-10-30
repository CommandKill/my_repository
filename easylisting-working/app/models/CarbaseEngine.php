<?php

class CarbaseEngine extends \Eloquent {
	protected $fillable = [];
	protected $table = 'carbase_engines';
	
	protected $guarded = array('id');

	public function carbase(){
        return $this->belongsTo('Carbase');
    }
}