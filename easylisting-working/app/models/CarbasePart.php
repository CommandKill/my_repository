<?php

class CarbasePart extends \Eloquent {
	protected $fillable = [];
	protected $table = 'carbase_parts';
	
	protected $guarded = array('id');
	public function lang(){
	    return $this->hasMany('CarbasePartLanguage', 'parts_id');
	}
}