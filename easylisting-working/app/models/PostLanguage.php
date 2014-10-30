<?php

class PostLanguage extends \Eloquent {
	protected $fillable = [];
	protected $table = 'posts_languages';
	 public $timestamps = false;
	protected $guarded = array('id');

	public function post(){
        return $this->belongsTo('Post');
    }

    public function language(){
        return $this->belongsTo('Language');
    }
}