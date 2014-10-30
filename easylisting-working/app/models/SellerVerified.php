<?php

class SellerVerified extends \Eloquent {

	// protected $fillable = [];
	protected $table = 'seller_verified';
    protected $guarded = array('id');
    // public $timestamps = false;

    public function member(){
        return $this->belongsTo('Member');
    }

}