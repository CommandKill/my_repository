<?php

class DesktopPromoteController extends PageController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex($id)
    {
        $this->getPromote($id);
        return View::make('site.desktop.promote.index');
    }

}