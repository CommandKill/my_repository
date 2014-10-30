<?php

class DesktopBlogController extends BlogController {

    public function __construct()
    {
        parent::__construct();
        // dd('xxx');
    }

    public function getIndex()
    {
        $this->getBlog();
        return View::make('site.desktop.blog.index');
    }

}