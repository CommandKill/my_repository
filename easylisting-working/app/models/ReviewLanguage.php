<?php

class ReviewLanguage extends \Eloquent
{
    protected $table = 'reviews_languages';
    protected $guarded = array('id');

    public function review(){
        return $this->belongsTo('Review');
    }

    public function language(){
        return $this->belongsTo('Language');
    }
}