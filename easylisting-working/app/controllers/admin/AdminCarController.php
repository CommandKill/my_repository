<?php
class AdminCarController extends AdminController 
{
	var $item_per_page = 20;

	public function __construct()
	{
		parent::__construct();
	}

    public function getIndex()
    {
    	$make = Input::get('make','');
    	$model = Input::get('model','');
    	// $cars = Car::where('id','>',0)
    	// 						->with(array('answer'=>function($query){
    	// 							$query->with('lang');
    	// 						}));

        $cars = CarbaseSubModel::where('id','>',0)
                ->with(array('model'=>function($q){
                    $q->with('make');
                }));
               

        // echo '<pre>';
        // dd($cars->get()->toArray());

    	// if($make!='') {
     //        $cars = $cars->where('make', 'LIKE', "%$make%");
     //    }

    	// if($model!='') {
     //        $cars = $cars->where('model', 'LIKE', "%$model%");
     //    }

        // get questionare
        $this->data['questionaire'] = Questionaire::where('id','>',0)
        								->with('lang')->get();
        // get question
        // get answer

        //Debugbar::info($this->data['questionaire'][0]->lang[0]->name);


        $this->data['title'] = 'All Cars';

        if($cars->count() > 0) {
            $this->data['cars'] = $cars->paginate($this->item_per_page);

// echo '<pre>';
// dd($this->data['cars'][0]->makex);
// Debugbar::info($this->data['cars'][0]);

            $this->data['pagination'] = $this->data['cars']->appends(array('make' => $make))->links();
        } else {
            $this->data['cars'] = false;
        }

		return View::make('admin.car.index');
    }

}	
?>