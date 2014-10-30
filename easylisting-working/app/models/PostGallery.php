<?php

class PostGallery extends \Eloquent {
	protected $fillable = [];
	protected $table = 'posts_galleries';
	
	protected $guarded = array('id');

    public function post(){
        return $this->belongsTo('Post');
    }
}