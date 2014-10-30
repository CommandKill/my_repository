<?php
 
class MemberSaveSearch extends \Eloquent {
 
    protected $table = 'members_saves_search';

    protected $guarded = array('id');

    public function search_by()
    {
        return $this->belongsTo('Member', 'member_id');
    }

}