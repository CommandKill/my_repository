<?php

class DesktopPageController extends PageController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
        $this->getPage();
        return View::make('site.desktop.page.index');
    }

}