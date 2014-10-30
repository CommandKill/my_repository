<?php
 
class Blog extends \Eloquent {
 
    protected $table = 'blogs';

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
        return $this->hasMany('BlogLanguage');
    }

    public function tags(){
        return $this->hasMany('BlogTag');
    }
 
}