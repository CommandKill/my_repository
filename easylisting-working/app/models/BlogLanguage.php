<?php

class BlogLanguage extends \Eloquent
{
    protected $table = 'blogs_languages';
    protected $guarded = array('id');

    public function blog(){
        return $this->belongsTo('Blog');
    }

    public function language(){
        return $this->belongsTo('Language');
    }
}