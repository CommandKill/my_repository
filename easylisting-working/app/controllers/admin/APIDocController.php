<?php
class APIDocController extends ContentController 
{
	var $item_per_page = 100;

	public function __construct()
	{
		parent::__construct();
	}

    public function getIndex()
    {
        $this->data['title'] = 'API - Index';
		return View::make('admin.api-doc.index');
    }

}	
?>