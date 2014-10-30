<?php
 
class UserGroup extends \Eloquent {
 
    protected $table = 'users_groups';

    protected $guarded = array('user_id','group_id');
}