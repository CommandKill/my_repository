<?php
class QuestionaireController extends AdminController 
{
	var $item_per_page = 100;

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Questionaires ';
	}

    public function getIndex()
    {
        $languages = Language::all();
        $list = Questionaire::paginate(15);

        $status = Config::get('site.status');

        $this->data['title'] .= '- All';

        return View::make('admin.questionaire.index',array(
                'list'      => $list,
                'languages' => $languages,
                'status'    => $status
            )
        );
    }

    public function postStore()
    {
        $inputs = Input::all();
        $rules = array();

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['title_'.$lang->short_code] = 'required';
        }

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $now = new DateTime;
            $questionaire = Questionaire::create(array(
                'status'        => $this->status['active'],
                'created_by'    => Sentry::getUser()->id,
                'available_from'=> $now,
                'available_to'  => $now
            ));
            $lastinsert_id = $questionaire->id;

            foreach($languages as $lang) {
                QuestionaireLanguage::create(array(
                    'questionaire_id' => $lastinsert_id,
                    'name'             => $inputs['title_'.$lang->short_code],
                    'language_id'       => $lang->id
                ));
            }

            Notification::success('The Questionaire was saved.');

            return Redirect::to('admin/questionaire/edit/'.$lastinsert_id);
        }

        return Redirect::back()->withInput()->withErrors($validator);
	}

    public function postQuestionStore()
    {
        $inputs = Input::all();
        $rules = array();

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['question_'.$lang->short_code] = 'required';
        }

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $questionaire_id = $inputs['questionaire_id'];
            $question = Question::create(array(
                'questionaire_id'   => $questionaire_id,
                'status'            => $this->status['active']
            ));

            foreach($languages as $lang) {
                QuestionLanguage::create(array(
                    'question_id'       => $question->id,
                    'title'             => $inputs['question_'.$lang->short_code],
                    'language_id'   	=> $lang->id
                ));
            }

            Notification::success('The question option was saved.');

            return Redirect::to('admin/questionaire/edit/'.$questionaire_id);
        }

        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function getEdit($id)
    {
        $this->data['title'] .= '- Edit';
        // $this->data['description'] .= 'and question';

        $language = Language::all();
        $questionaire = Questionaire::where('id',$id)->with('lang')
                        ->whereIn('status', array($this->status['active'], $this->status['inactive']))
                        ->with('created_by')
                        ->with('updated_by')->first();

        $question = Question::where('questionaire_id','=',$id)
                        ->whereIn('status', array($this->status['active'], $this->status['inactive']))
                        ->orderBy('weigth','asc')->get();

        //$question = $questionaire->question()->with('lang')->first();
        // Debugbar::info($questionaire->question()->with('lang')->first());
        //Debugbar::info($questionaire->question()->getRelations);

        return View::make('admin.questionaire.edit', array(
                'questionaire'  => $questionaire,
                'question'      => $question,
                'languages'     => $language
            )
        );
    }

    public function postUpdate()
    {
        $inputs = Input::all();
        $rules = array();
        $arr['status'] = 'Update Failed';

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['title_'.$lang->short_code] = 'required';
        }

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $questionaire_id = $inputs['id'];
            $questionaire = Questionaire::where('id', '=', $questionaire_id)->with('question')->with('lang')->first();
            $questionaire->updated_by = Sentry::getUser()->id;

            $available  = explode(" - ",$inputs['available_period']);
            $questionaire->available_from = trim($available[0]);
            $questionaire->available_to = trim($available[1]);

            $questionaire->status = $inputs['status'];
            $success = $questionaire->save();

            if($success) {

                foreach($languages as $lang){

                    // Data
                    if (Input::has('title_'.$lang->short_code))
                    {
                        $questionaire_data = array(
                            'name' => $inputs['title_'.$lang->short_code]
                        );

                        QuestionaireLanguage::where('questionaire_id','=',$questionaire_id)
                            ->where('language_id','=',$lang->id)
                            ->update($questionaire_data);
                    }

                    if ($success) {
                        $arr['status'] = 'Update Completed!';
                    }
                }
            }

            Notification::success('The questionaire was saved.');

            return Redirect::to('admin/questionaire/edit/'.$questionaire_id);
        }

        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function postUpdateQuestionOrder() {
        $input = Input::get('order_question_id');

        for($i = 0;$i<count($input);$i++){
            $question = Question::find($input[$i]);
            $question->update(array('weigth'=>$i));
        }
        return json_encode(array('status'=>'success', 'input'=>$input));
    }

    public function getQuestionEdit($questionaire_id, $question_id)
    {
        $this->data['title'] .= '- Question - Edit';

        $language = Language::all();
        $question = Question::where('id','=',$question_id)
                    ->whereIn('status', array($this->status['active'], $this->status['inactive']))
                    ->with('lang')->first();

        $answer = Answer::where('question_id','=',$question_id)
                    ->whereIn('status', array($this->status['active'], $this->status['inactive']))
                    ->with('lang')->orderBy('weigth','asc')->get();

       // echo '<pre>';
       //  dd($answer->toArray());

        return View::make('admin.questionaire.question_edit', array(
                'thumbnail_path'    => $destinationPath = asset('/uploaded/questionaire/'.$questionaire_id.'/'),
                'questionaire_id'   => $questionaire_id,
                'question'          => $question,
                'answer'            => $answer,
                'languages'         => $language
            )
        );
    }

    public function postQuestionUpdate()
    {
        $inputs = Input::all();
        $rules = array();
        $arr['status'] = 'Update Failed';

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['title_'.$lang->short_code] = 'required';
        }

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $questionaire_id = $inputs['questionaire_id'];
            $question_id = $inputs['question_id'];
            $question = Question::where('id', '=', $question_id)->with('answer')->with('lang')->first();
            $question->status = $inputs['status'];
            $success = $question->save();

            if($success) {

                foreach($languages as $lang){

                    // Data
                    if (Input::has('title_'.$lang->short_code))
                    {
                        $questiona_data = array(
                            'title' => $inputs['title_'.$lang->short_code]
                        );

                        QuestionLanguage::where('question_id','=',$question_id)
                            ->where('language_id','=',$lang->id)
                            ->update($questiona_data);
                    }

                    if ($success) {
                        $arr['status'] = 'Update Completed!';
                    }
                }
            }

            Notification::success('The question was saved.');

            return Redirect::to('admin/questionaire/question-edit/'.$questionaire_id.'/'.$question_id);
        }

        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function postAnswerStore()
    {
        $inputs = Input::all();
        $rules = array();

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['answer_'.$lang->short_code] = 'required';
        }

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $questionaire_id = $inputs['questionaire_id'];
            $question_id = $inputs['question_id'];
            $answer = Answer::create(array(
                'question_id'   => $question_id,
                'status'        => $this->status['active']
            ));

            if (Input::hasFile('answer_illustration')) {
                $destinationPath = public_path().'/uploaded/questionaire/'.$questionaire_id.'/';
                File::makeDirectory($destinationPath, 0775, true, true);
                $file = Input::file('answer_illustration');
                $filename = $file->getClientOriginalName();
                $thumbnail_destination = $destinationPath.'thumb_'.$filename;
                Image::make($file->getRealPath())
                    ->resize(80,60,function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->save($thumbnail_destination);

                    $file->move($destinationPath,$filename);

                $answer->illustration = $file->getClientOriginalName();
                $answer->update();
            }

            foreach($languages as $lang) {
                AnswerLanguage::create(array(
                    'answer_id'       => $answer->id,
                    'title'             => $inputs['answer_'.$lang->short_code],
                    'language_id'       => $lang->id
                ));
            }

            Notification::success('The answer was saved.');

            return Redirect::to('admin/questionaire/question-edit/'.$questionaire_id.'/'.$question_id);
        }

        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function postUpdateAnswerOrder() {
        $input = Input::get('order_answer_id');

        for($i = 0;$i<count($input);$i++){
            $answer = Answer::find($input[$i]);
            $answer->update(array('weigth'=>$i));
        }
        return json_encode(array('status'=>'success'));
    }

    public function getQuestionaireRemove($questionaire_id)
    {
        $data['status'] = $this->status['deleted'];
        $data['updated_at'] = new DateTime;
        
        $content = Questionaire::where('id','=',$questionaire_id)->update($data);
        
        return Redirect::to('admin/questionaire');
    }

    public function getQuestionRemove($questionaire_id, $question_id)
    {
        $data['status'] = $this->status['deleted'];
        $data['updated_at'] = new DateTime;
        
        $content = Question::where('id','=',$question_id)->update($data);
        
        return Redirect::to('admin/questionaire/'.$questionaire_id);
    }

    public function getAnswerRemove($questionaire_id, $question_id, $answer_id)
    {
        $data['status'] = $this->status['deleted'];
        $data['updated_at'] = new DateTime;
        
        $content = Answer::where('id','=',$answer_id)->update($data);
        
        return Redirect::to('admin/questionaire/question-edit/'.$questionaire_id.'/'.$question_id);
    }

    public function getAnswerDetail() {
        $answer_id = Input::get('answer_id');
        $answer = Answer::where('id', $answer_id)
                ->with('lang')
                ->first()
                ->toArray();        
        return json_encode(array(
            'error'=>0,
            'answer'=>$answer
        ));
    }

    public function postAnswerUpdateStore()
    {
        $inputs = Input::all();

        $questionaire_id = $inputs['questionaire_id'];
        $question_id = $inputs['question_id'];
        $answer_id = $inputs['answer_id'];


        $rules = array();

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['answer_'.$lang->short_code] = 'required';
        }

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $answer = Answer::find($answer_id);

            if (Input::hasFile('answer_illustration')) {
                $destinationPath = public_path().'/uploaded/questionaire/'.$questionaire_id.'/';
                File::makeDirectory($destinationPath, 0775, true, true);
                $file = Input::file('answer_illustration');
                $filename = $file->getClientOriginalName();
                $thumbnail_destination = $destinationPath.'thumb_'.$filename;
                Image::make($file->getRealPath())
                    ->resize(80,60,function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->save($thumbnail_destination);

                    $file->move($destinationPath,$filename);

                $answer->illustration = $file->getClientOriginalName();
                $answer->update();
            } else {
                $answer->illustration = $inputs['illustration'];
                $answer->update();
            }

            foreach($languages as $lang) {
                $answer_lang = AnswerLanguage::where('answer_id', '=', $answer_id)
                                ->where('language_id', '=', $lang->id)->first();
                $answer_lang->title = $inputs['answer_'.$lang->short_code];
                $answer_lang->update();
            }

            Notification::success('The answer was saved.');
        }

        return Redirect::to('admin/questionaire/question-edit/'.$questionaire_id.'/'.$question_id);
    }
}	
?>