<?php
 
class EmailTemplate extends \Eloquent {
 
    protected $table = 'emails_templates';

    protected $guarded = array('id');

    public function created_by()
    {
        return $this->belongsTo('User', 'created_by');
    }

    public function updated_by()
    {
        return $this->belongsTo('User', 'updated_by');
    }

    public function template()
    {
        return $this->hasMany('EmailTemplateLanguage');
    }
 
}