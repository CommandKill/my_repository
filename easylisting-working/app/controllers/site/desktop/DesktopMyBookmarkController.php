<?php

class DesktopMyBookmarkController extends SiteController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
        
        return View::make('site.desktop.member.my_bookmark');
    }

}