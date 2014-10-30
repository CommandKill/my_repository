<?php

class PackageDetail extends \Eloquent {

	protected $table = 'packages_details';

    protected $guarded = array('id');

    public function package(){
        return $this->belongsTo('Package');
    }

    public function language(){
        return $this->belongsTo('Language');
    }
}