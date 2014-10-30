<?php

class Carbase extends \Eloquent {
	protected $fillable = [];
	protected $table = 'cars';
	
	protected $guarded = array('id');

	public function answer(){
	    return $this->belongsToMany('Answer', 'car_answer');
	}

	public function year()
    {
        return $this->belongsTo('CarbaseYear', 'year_id');
    }

	public function make()
    {
        return $this->belongsTo('CarbaseMake', 'make_id');
    }

	public function model()
    {
        return $this->belongsTo('CarbaseModel', 'model_id');
    }

	public function engine()
    {
        return $this->belongsTo('CarbaseEngine', 'engine_id');
    }

	public function gear()
    {
        return $this->belongsTo('CarbaseGear', 'gear_id');
    }

	public function fuel()
    {
        return $this->belongsTo('CarbaseFuel', 'fuel_id');
    }

	public function color()
    {
        return $this->belongsTo('CarbaseColor', 'color_id');
    }
}