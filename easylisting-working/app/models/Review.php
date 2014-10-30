<?php
 
class Review extends \Eloquent {
 
    protected $table = 'reviews';

    protected $guarded = array('id');

    public function post_by()
    {
//        return $this->hasOne('User', 'foreign_key', 'created_by');
        return $this->belongsTo('User', 'created_by');
    }

    public function modify_by()
    {
        return $this->belongsTo('User', 'updated_by');
    }

    public function lang(){
        return $this->hasMany('ReviewLanguage');
    }
 
}