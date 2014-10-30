<?php

class QuestionLanguage extends \Eloquent {

	protected $table = 'questions_languages';

    protected $guarded = array('id');

    public function question(){
        return $this->belongsTo('Question');
    }

}