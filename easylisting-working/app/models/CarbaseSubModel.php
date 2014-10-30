<?php

class CarbaseSubModel extends \Eloquent {
	protected $fillable = [];
	protected $table = 'carbase_submodels';
	protected $guarded = array('id');
	public $timestamps = false;
	public function model()
    {
        return $this->belongsTo('CarbaseModel', 'model_id');
    }
}