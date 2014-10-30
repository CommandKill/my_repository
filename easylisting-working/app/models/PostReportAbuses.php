<?php

class PostReportAbuses extends \Eloquent {
	protected $fillable = [];
	protected $table = 'posts_reports_abuses';
	
	protected $guarded = array('id');

    public function answer(){
        return $this->belongsTo('Answer');
    }
}