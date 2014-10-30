<?php

class Tag extends \Eloquent {
	protected $fillable = [];
	protected $table = 'tags';
	protected $guarded = array('id');
	// protected $guarded = array('text');
	public $timestamps = false;
}