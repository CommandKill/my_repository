<?php

class TextLanguage extends \Eloquent {
	protected $fillable = [];
	protected $table = 'texts_languages';
	public $timestamps = false;

	protected $guarded = array('id');

    public function language(){
        return $this->belongsTo('Language');
    }
}