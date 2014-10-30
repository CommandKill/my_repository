<?php

class AnswerLanguage extends \Eloquent {

	protected $table = 'answers_languages';

    protected $guarded = array('id');

    public function answer(){
        return $this->belongsTo('Answer');
    }

}