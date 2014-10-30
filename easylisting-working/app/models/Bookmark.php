<?php
 
class Bookmark extends \Eloquent {
 
    protected $table = 'members_bookmarks';

    protected $guarded = array('id');
    
    public function member()
    {
        return $this->belongsTo('Member', 'member_id');
    }

    public function post()
    {
        return $this->belongsTo('Post', 'post_id');
    }
}