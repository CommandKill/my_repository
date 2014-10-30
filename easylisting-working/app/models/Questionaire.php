<?php

class Questionaire extends \Eloquent {
	
	protected $table = 'questionaires';

    protected $guarded = array('id');

    public function created_by()
    {
        return $this->belongsTo('User', 'created_by');
    }

    public function updated_by()
    {
        return $this->belongsTo('User', 'updated_by');
    }

    public function lang(){
        return $this->hasMany('QuestionaireLanguage');
    }

    public function question(){
        return $this->hasMany('Question');
    }

}