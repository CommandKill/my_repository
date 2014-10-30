<?php

class MobileHomepageController extends HomepageController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
        $this->data['title'] = 'Homepage mobile version)';
        return View::make('site.mobile.homepage.index');
    }

}