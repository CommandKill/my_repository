<?php

class BlogController extends SiteController {

    public function __construct()
    {
        parent::__construct();
    }

    protected function getBlog()
    {
        $slug = Request::segment(3);

        $p = Blog::where('slug', $slug)->with('lang')->first();
        if ($p) {
            $page = $p->lang()->where('language_id',$this->data['locale_id'])->first();
            $this->data['title'] = $this->data['page_title'] = $page->title;
            $this->data['page_body'] = $page->body;
        } else {
            return App::abort(404); 
        } 
    }

    protected function getPromote($id)
    {
        $promote = Blog::where('id', $id)
                    ->with(array('lang'=>function($q){
                        $q->where('language_id',$this->data['locale_id']);
                    }))
                    ->first();
        if ($promote) {
            $this->data['title'] = $this->data['page_title'] = $promote->lang[0]->title;
            $this->data['page_body'] = $promote->lang[0]->body;
        } else {
            return App::abort(404); 
        } 
    }
}