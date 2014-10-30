<?php
class LanguageController extends AdminController 
{
	var $item_per_page = 100;

	public function __construct()
	{
		parent::__construct();
		$this->data['title'] = 'Languages ';
	}

  public function index($lang='en', $module='all')
  {
   	$this->data['title'] .= '';

   	$texts = TextLanguage::where('language_id', $this->data['languages'][$lang]['id']);
   	if($module!='all') {
   		$texts->where('module', $module);
   	}
    $this->data['text'] = $texts->get();

   	$this->data['modules'] = TextLanguage::distinct()->get(array('module'))->toArray();
   	$this->data['lang'] = $lang;
   	$this->data['module'] = $module;

   	Debugbar::info($this->data['module']);

	  return View::make('admin.language.index');
  }

	public function save($lang='en', $module='all')
  {
    // $lang = Request::segment(3);
    // $scope = Request::segment(4);

    $lang_all = Input::all();
    foreach ($lang_all as $key => $value) {
    	$affectedRows = TextLanguage::where('language_id', '=', $this->data['languages'][$lang]['id'])
    					->where('key', $key)
    					->update(array('value' => $value));
    }

    Cache::flush();
    return Redirect::to('admin/language/'.$lang.'/'.$module);
  }
}	
?>