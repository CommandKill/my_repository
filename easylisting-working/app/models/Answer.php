<?php

class Answer extends \Eloquent {

	protected $table = 'answers';

    protected $guarded = array('id');

    public function question(){
        return $this->belongsTo('Question');
    }

    public function language(){
        return $this->belongsTo('Language');
    }

    public function lang(){
        return $this->hasMany('AnswerLanguage');
    }

}