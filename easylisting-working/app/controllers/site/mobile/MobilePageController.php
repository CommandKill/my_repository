<?php

class MobilePageController extends PageController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
    	$this->data['title'] = 'Page mobile version:) ';
        $this->getPage();
        return View::make('site.mobile.page.index');
    }

}