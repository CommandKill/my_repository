<?php

class QuestionaireLanguage extends \Eloquent {

	protected $table = 'questionaires_languages';

    protected $guarded = array('id');

    public function questionaire(){
        return $this->belongsTo('Questionaire');
    }

    public function language(){
        return $this->belongsTo('Language');
    }

}