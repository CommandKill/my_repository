<?php

class CarbaseModel extends \Eloquent {
	protected $fillable = [];
	protected $table = 'carbase_models';
	public $timestamps = false;
	protected $guarded = array('id');

	public function model(){
	    return $this->hasMany('CarbaseSubModel');
	}

	public function make()
    {
        return $this->belongsTo('CarbaseMake', 'make_id');
    }
}