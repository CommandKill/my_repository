<?php

class AdminController extends BaseController 
{
	var $data = array();

	public function __construct()
	{
		parent::__construct();

		// Default meta data
		$this->data['title'] = trans('site.site_name');
		$this->data['description'] = trans('site.site_desc');
		$this->data['author'] = '';
		
		// Store language for auto use in view
        $this->data['languages'] = $this->languages;
        $this->data['locale'] = $this->current_lang;
        $this->data['locale_id'] = $this->data['languages'][$this->current_lang]['id'];
        $this->data['status'] = $this->status;

        $this->data['user'] = Sentry::getUser();

        // echo '<pre>'; dd($this->data['user']['first_name']);

		// This scope for bound data before bind to all view
		View::composer('admin.*', function($view)
		{
		    $view->with('data',  $this->data);
		});

	}

}