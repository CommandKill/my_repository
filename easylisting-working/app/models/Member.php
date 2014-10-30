<?php
 
class Member extends \Eloquent {
 
    protected $table = 'members';

    protected $guarded = array('id');
 
	public function favourites(){
	    return $this->hasMany('Bookmark');
	}
}