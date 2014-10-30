<?php

class Question extends \Eloquent {

	protected $table = 'questions';

    protected $guarded = array('id');

    public function questionaire(){
        return $this->belongsTo('Questionaire');
    }

    // public function language(){
    //     return $this->belongsTo('Language');
    // }

    public function lang(){
        return $this->hasMany('QuestionLanguage');
    }

    public function answer(){
        return $this->hasMany('Answer');
    }

}