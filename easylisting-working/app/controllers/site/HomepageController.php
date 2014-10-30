<?php

class HomepageController extends SiteController {

    public function __construct()
    {
        parent::__construct();

        $this->data['text_page'] = $this->get_language_by_module('search_form');
    }

}