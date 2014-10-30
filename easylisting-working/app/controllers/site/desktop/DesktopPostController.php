<?php

class DesktopPostController extends PostController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
    	$this->data['title'] = 'Post desktop version)';
		return View::make('site.desktop.post.listing');
    }
}