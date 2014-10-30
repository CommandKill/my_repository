<?php

class SiteController extends BaseController 
{
	var $data = array();
	// var $mobile_version = false;

	public function __construct()
	{
		parent::__construct();

		// $this->mobile_version = (Agent::isMobile() && Agent::isTablet()) ? true : false;

		if (Config::get('site.cache_enable')) {
			// Caching
	        $this->beforeFilter('cache.grab', array('on' => 'get'));
	        // $this->afterFilter('log', array('only' => array('getIndex')));
	        $this->afterFilter('cache.set', array('on' => 'get'));
		}
		// save search and favorite car
		$this->data['favorite_count'] = Bookmark::where('member_id',Session::get('member.id'))->get()->count();
		$this->data['savesearch_count'] = SaveSearch::where('member_id',Session::get('member.id'))->get()->count();
        // Store language for auto use in view
        $this->data['languages'] = $this->languages;
        $this->data['locale'] = $this->current_lang;
        $this->data['locale_id'] = $this->data['languages'][$this->current_lang]['id'];

		Debugbar::info('read in SiteController');

		// Default meta data
		$this->data['title'] = trans('site.site_name');
		$this->data['description'] = trans('site.site_desc');
		$this->data['author'] = '';

		// For facebook share
		$this->data['og:description'] = '';
		$this->data['og:type'] = '';
		$this->data['og:site_name'] = '';
		$this->data['og:image'] = '';
		$this->data['og:url'] = '';
		$this->data['og:title'] = '';
		$this->data['og:description'] = '';

		$this->data['member_root_url'] = $this->member_root_url;

		// google webmaster verify
		$this->data['google-site-verification'] = '';

		// global_text
		$key_global_text = 'global_text_'.$this->data['locale'];
		///////////////////////////////////
		// Cache::forget($key_global_text);// for test
		///////////////////////////////////
		if (Cache::has($key_global_text)){
			$this->data['text'] = Cache::get($key_global_text);
			Debugbar::info($key_global_text.' from cache');
		} else {
			// Load global text
            $this->data['text'] = $this->get_language_autoload();

	        Cache::forever($key_global_text, $this->data['text']);
	        Debugbar::info($key_global_text.' from db');
		}

		$key_global_setting = 'global_setting';
		if (Cache::has($key_global_setting)){
			$this->data['setting'] = Cache::get($key_global_setting);
			Debugbar::info($key_global_setting.' from cache');
		} else {
			$settings = Setting::where('autoload',1)->where('module','global')->get();
			foreach ($settings as $key => $value) {
				$this->data['setting'][$value->key] = $value->value;
			}
			Cache::forever($key_global_setting, $this->data['setting']);
			Debugbar::info($key_global_setting.' from db');
		}

		// This scope for bound data before bind to all view
		View::composer('site.*', function($view)
		{
			// dd($this->data);
		    $view->with('data',  $this->data);
		});

		Debugbar::info($this->data);
	}

    public function get_language_autoload()
    {
        // Load global text
        $global_text = TextLanguage::where('language_id', $this->languages[$this->current_lang]['id'])
            ->where('autoload', 1)
            ->get()
            ->toArray();

        $res = array();
        if (is_array($global_text) && !empty($global_text))
            foreach ($global_text as $key => $value) {
                $res[$value['key']] = $value['value'];
            }

        return $res;
    }

    public function get_language_by_module($module='global')
    {
        // Load global text
        $global_text = TextLanguage::where('language_id', $this->languages[$this->current_lang]['id'])
            ->where('module', $module)
            ->get()
            ->toArray();

        $res = array();
        if (is_array($global_text) && !empty($global_text))
            foreach ($global_text as $key => $value) {
                $res[$value['key']] = $value['value'];
            }

        return $res;
    }

     public function get_language_in_module($module=array('global'))
    {
        // Load global text
        $global_text = TextLanguage::where('language_id', $this->languages[$this->current_lang]['id'])
            ->whereIn('module', $module)
            ->get()
            ->toArray();

        $res = array();
        if (is_array($global_text) && !empty($global_text))
            foreach ($global_text as $key => $value) {
                $res[$value['key']] = $value['value'];
            }

        return $res;
    }  
}