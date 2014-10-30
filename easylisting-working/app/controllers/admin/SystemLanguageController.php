<?php
class SystemLanguageController extends AdminController 
{
	var $item_per_page = 100;

	public function __construct()
	{
		parent::__construct();
		$this->data['title'] = 'System Languages ';
	}

    public function getIndex()
    {
       	$this->data['title'] .= '';
        $this->data['langauges'] = Language::paginate(15);

		return View::make('admin.system-language.index');
    }

	public function postStore()
	{	
		$input = Input::all();
	
		$data['title'] = $input['title'];
		$data['code'] = $input['code'];
		$data['short_code'] = $input['short_code'];
		$data['status'] = 1;
		$data['created_at'] = new DateTime;
		$data['created_at'] = new DateTime;
		
		$lang = Language::create($data);

		// get all en field in text_langauge and new insert to new lang
		$global_text_en = TextLanguage::where('language_id', 1)->get();
		$arr = array();
		foreach ($global_text_en as $key => $value) {
			$arr[] = array(
				'language_id' => $lang->id,
				'key' => $value->key,
				'value' => $value->value,
				'input_type' => $value->input_type,
				'module' => $value->module,
				'input_option' => $value->input_option,
				'autoload' => $value->autoload
			); 
		}
		// dd($arr);
		if(is_array($arr) && !empty($arr))
			DB::table('texts_languages')->insert($arr);

		Cache::flush();

		return Redirect::to('admin/system-language/edit/'.$lang->id);
	}
	
	public function getEdit($id) 
	{
		$this->data['title'] .= '- Edit';	
		$lang = Language::find($id);
		
		return View::make('admin.system-language.edit',array('lang'=>$lang));
	}
	
	public function postUpdate() 
	{	
		$input = Input::all();
		
		$data['code'] = $input['code'];
		$data['short_code'] = $input['short_code'];
		$data['title'] = $input['title'];
		$data['updated_at'] = new DateTime;
		
		$lang = Language::find($input['id']);
		$success = $lang->update($data);
		if($success) {
			Notification::success('Update Completed!');
		}else {
			Notification::warning('Update Failed.');
		}

		Cache::flush();
		return Redirect::to('admin/system-language');
	}
	
	public function getDestroy($id)
	{
		$lang = Language::destroy($id);
		return Redirect::to('admin/system-language');		
	}
}	
?>