<?php
class AdminCarPartController extends AdminController 
{
    var $item_per_page = 25;

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
        $part = Input::get('part','');
        $lang = Input::get('lang','th');
        $lang_id = $this->data['languages'][$lang]['id'];

        // $cars = CarbasePart::where('id','>',0)->;
     //    $cars->orderBy('part', 'asc');
        $cars = CarbasePart::where('id','>',0)
                 ->with(array('lang' => function($query) use ($lang_id) { 
                    $query->where('language_id', $lang_id);
                }));
                
        // $cars = CarbasePart::where('id','>',0)
//             ->with(array('lang' => function($query) {
//                $query->where('language_id', $this->language_id);
//            }));
           // ->orderBy('part', 'asc');
        //$this->data['parts'] = $parts->toArray();

        $this->data['title'] = 'Car Parts';
        if($cars->count() > 0) {
            $this->data['cars'] = $cars->paginate($this->item_per_page);
            $this->data['pagination'] = $this->data['cars']->appends(array('part' => $part))->links();
        } else {
            $this->data['cars'] = false;
        }
        
        return View::make('admin.car.parts')->with('input', Input::all());
    }

    public function postIndex()
    {
        $id = Input::get('edit_id','');
        $name = Input::get('name','');

        $c = CarbasePartLanguage::find($id);
        $c->title = $name;
        $c->save();

        return Redirect::back();
    }

}   
?>