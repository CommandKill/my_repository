<?php

class Category extends \Eloquent {
	protected $fillable = [];
	protected $table = 'categories';
	
	protected $guarded = array('id');
}