<?php

class PromoteLanguage extends \Eloquent
{
    protected $table = 'promotes_languages';
    protected $guarded = array('id');

    public function promote(){
        return $this->belongsTo('Promote');
    }

    public function language(){
        return $this->belongsTo('Language');
    }
}