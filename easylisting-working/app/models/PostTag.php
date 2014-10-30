<?php

class PostTag extends \Eloquent {
	protected $fillable = [];
	protected $table = 'posts_tags';
    public $timestamps = false;
    protected $guarded = array('id');
	
	// protected $guarded = array('text');
    // protected $guarded = array('post_id', 'tag_text');


    // public function post(){
    //     return $this->belongsTo('Post', 'post_id');
    // }

    // public function tag(){
    //     return $this->belongsTo('Tag');
    // }
}