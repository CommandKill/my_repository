<?php

class Province extends \Eloquent {
	protected $fillable = [];
	protected $table = 'province';

    protected $guarded = array('id');

    public function amphur(){
        return $this->hasMany('Aumphur');
    }

    public function geography(){
        return $this->belongsTo('Geography');
    }
}