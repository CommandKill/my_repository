<?php

class PageLanguage extends \Eloquent
{
    protected $table = 'pages_languages';
    protected $guarded = array('id');

    public function page(){
        return $this->belongsTo('Page');
    }

    public function language(){
        return $this->belongsTo('Language');
    }
}