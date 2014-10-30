<?php

class DesktopWizardController extends PageController 
{
	var $questionaire_key = 'site_questionaire_id_for_wizard';
    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
        $wizard_questionaire_setting = Setting::where('key', $this->questionaire_key)->get();
        $questionaire = Questionaire::where('id', $wizard_questionaire_setting[0]->value)
                        ->with(array('lang' => function($query){ 
                            $query->where('language_id', $this->data['locale_id']);
                        }))
                        ->with(array('question' => function($query){ 
                            $query->where('status', $this->status['active'])
                                ->with(array('lang' => function($query){ 
                                $query->where('language_id', $this->data['locale_id']);
                            }));

                            $query->with(array('answer' => function($query){ 
                                $query->where('status', $this->status['active'])
                                    ->with(array('lang' => function($query){ 
                                    $query->where('language_id', $this->data['locale_id']);
                                }));
                            }));
                        }))
                        ->first();
        // echo '<pre>';
        // dd($questionaire->toArray());

        $this->data['page_title'] = 'Wizard';

        return View::make('site.desktop.wizard.index')
        		->with('thumbnail_path',$destinationPath = asset('/uploaded/questionaire/'.$wizard_questionaire_setting[0]->value.'/'))
                ->with('questionaire', $questionaire);
    }

    public function getCarFromQuestion()
    {
        $data = Post::where('status', $this->status['active'])
		        ->with(array('lang' => function($query){ 
		            $query->where('language_id', $this->data['locale_id']);
		        }))
		        ->with('make')->with('model')->with('submodel')->with('year')
		        ->orderBy('id', 'desc')
		        ->take(10)
		        ->get();
		if ($data) {
			$data = $data->toArray();
		} else {
			$data = array();
		}
        return Response::json(array(
            'error' => false,
            'data' => $data),
            200
        );
    }
}