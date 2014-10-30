<?php

class MobilePostController extends PostController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
    	$this->data['title'] = 'Post mobile version)';
		return View::make('site.mobile.post.listing');
    }
}