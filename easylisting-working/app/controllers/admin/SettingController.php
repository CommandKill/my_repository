<?php
class SettingController extends AdminController 
{
	var $item_per_page = 100;

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Setting';
	}

	public function getIndex()
	{
		$settings = Setting::all()->toArray();

		foreach ($settings as $key => $value) {
			if($value['input_type'] == 'option') {
                if ($value['input_option'] != '') {
                    // 'key1,option1|key2,option2' <- required this format only!!!!!!!
                    $options = explode('|', $value['input_option']);
                    $option_result = array();
                    foreach ($options as $option) {
                        list($option_key, $option_value) = explode(',', $option); 
                        $option_result[$option_key] = $option_value;
                    }
                    $value['option'] = $option_result;
                } else {
                    $value['option'] = $this->{$value['input_custom']}();
                }
            }
            $this->data['setting'][$value['module']][$value['key']] = $value;
		}

		return View::make('admin.setting.index');
	}

    // this function define for setting will look up at input_custom field and input_type field equal 'option'
    public function emailTemplate()
    {
        $email_template = EmailTemplate::with('template')->get();
        $result = array();
        foreach ($email_template as $key => $value) {
            //$result[$value->id] = $value->template[0]->title;
            $result[$value->id] = $value->key;
        }   
        return $result;
    }

    public function questionaireListing()
    {
        $questionaire = Questionaire::whereIn('status', array($this->status['active']))
                        ->with('lang')
                        ->get();
        $result = array();
        foreach ($questionaire as $key => $value) {
            $result[$value->id] = $value->lang[0]->name;
        }   
        return $result;
    }

	public function postStore()
	{
        $inputs = Input::all();

        $settings = Setting::all();

        Debugbar::info($settings);

        $data = array();
        foreach($settings as $config) {
            if (Input::has($config->key)) {
                $config->value = $inputs[$config->key];

                Setting::where('key','=',$config->key)->update(array('value'=>$config->value));
            }
        }

        Cache::flush();

        return Redirect::to('admin/setting');
	}

}	
?>