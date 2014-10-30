<?php

class Amphur extends \Eloquent {
	protected $fillable = [];
	protected $table = 'amphur';
    public $timestamps = false;

    protected $guarded = array('id');

    public function district(){
        return $this->hasMany('District');
    }

    public function geography(){
        return $this->belongsTo('Geography');
    }

    public function province(){
        return $this->belongsTo('Province');
    }
}