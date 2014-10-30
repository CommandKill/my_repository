<?php

class District extends \Eloquent {
	protected $fillable = [];
	protected $table = 'district';

    protected $guarded = array('id');

    public function geography(){
        return $this->belongsTo('Geography');
    }

    public function province(){
        return $this->belongsTo('Province');
    }

    public function amphur(){
        return $this->belongsTo('Amphur');
    }

    public function zipcode(){
        return $this->hasOne('ZipCode');
    }
}