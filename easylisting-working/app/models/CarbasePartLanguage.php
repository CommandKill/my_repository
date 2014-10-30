<?php

class CarbasePartLanguage extends \Eloquent {
	protected $fillable = [];
	public $timestamps = false;
	protected $table = 'carbase_parts_languages';
	
	protected $guarded = array('id');

	public function parts(){
        return $this->belongsTo('CarbasePart');
    }

    public function language(){
        return $this->belongsTo('Language');
    }
}