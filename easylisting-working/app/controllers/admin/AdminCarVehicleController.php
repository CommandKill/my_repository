<?php
class AdminCarVehicleController extends AdminController 
{
	var $item_per_page = 20;

	public function __construct()
	{
		parent::__construct();

        $this->data['title'] = 'Car Vehicle';
	}

    public function getIndex()
    {
    	$make = Input::get('make','');
    	$model = Input::get('model','');
    	$cars = CarVehicle::where('id','>',0)->with('colors');

    	if($make!='') {
            $cars = $cars->where('make', 'LIKE', "%$make%");
        }

    	if($model!='') {
            $cars = $cars->where('model', 'LIKE', "%$model%");
        }

        $cars->orderBy('make', 'asc')->orderBy('model', 'asc');

        if($cars->count() > 0) {
            $this->data['cars'] = $cars->paginate($this->item_per_page);
            $this->data['pagination'] = $this->data['cars']->appends(array('make' => $make))->links();
        } else {
            $this->data['cars'] = false;
        }

		return View::make('admin.car.vehicle');
    }

}	
?>