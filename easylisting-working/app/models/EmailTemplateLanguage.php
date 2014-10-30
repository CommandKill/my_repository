<?php
 
class EmailTemplateLanguage extends \Eloquent {
 
    protected $table = 'emails_templates_languages';
    public $timestamps = false;
    protected $guarded = array('id');

    public function email_template(){
        return $this->belongsTo('EmailTemplate');
    }

    public function language(){
        return $this->belongsTo('Language');
    }
 
}