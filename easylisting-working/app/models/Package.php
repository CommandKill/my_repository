<?php

class Package extends \Eloquent 
{
	protected $table = 'packages';

    protected $guarded = array('id');

    public function created_by()
    {
        return $this->belongsTo('User', 'created_by');
    }

    public function updated_by()
    {
        return $this->belongsTo('User', 'updated_by');
    }

    public function lang(){
        return $this->hasMany('PackageLanguage');
    }

    public function detail(){
        return $this->hasMany('PackageDetail');
    }
}