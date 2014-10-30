<?php

class Setting extends \Eloquent {

    protected $table = 'settings';

    public $timestamps = false;

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

    protected $guarded = array('key');

}