<?php

class DesktopQuickSaleController extends SiteController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
    	$this->data['page_title'] = 'Quick sale';
    	$this->data['page_body'] = '';
    	$posts = array();

        return View::make('site.desktop.quicksale.index')
        		->with('posts', $posts);
    }
    public function getInsurance()
    {
    	$this->data['page_title'] = 'Insurance';
    	$this->data['page_body'] = '';
    	$posts = array();

        return View::make('site.desktop.quicksale.index')
        		->with('posts', $posts);
    }
    public function getFinance()
    {
    	$this->data['page_title'] = 'Finance';
    	$this->data['page_body'] = '';
    	$posts = array();

        return View::make('site.desktop.quicksale.index')
        		->with('posts', $posts);
    }

}