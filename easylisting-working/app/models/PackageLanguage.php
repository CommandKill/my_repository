<?php

class PackageLanguage extends \Eloquent 
{	
	protected $table = 'packages_languages';

    protected $guarded = array('id');

    public function package(){
        return $this->belongsTo('Package');
    }

    public function language(){
        return $this->belongsTo('Language');
    }
}