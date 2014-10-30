<?php

class DesktopReviewController extends SiteController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
    	$this->data['page_title'] = 'Review';
    	$this->data['page_body'] = '';
    	$posts = array();

        return View::make('site.desktop.review.index')
        		->with('posts', $posts);
    }

}