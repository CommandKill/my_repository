<?php
class AdminPageController extends \AdminController 
{
    var $item_per_page = 20;

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Pages';
		$this->data['description'] = '';
	}

    public function getIndex()
    {
        $q = Input::get('q','');
        $slug = Input::get('slug','');
        $pages = Page::with('lang');
        $allowed_sort = ['created_at'];
        $sort = in_array(Input::get('sort'), $allowed_sort) ? Input::get('sort') : 'pages.created_at';
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';

        $pages = Page::select('pages.*','pages_languages.title as title')
                ->join('pages_languages', 'pages_languages.page_id', '=', 'pages.id')
                ->where('status', '!=', $this->status['deleted'])
                ->groupby('pages_languages.page_id')
                ->with('post_by');

        if($q!='') {
            $pages = $pages->where('pages_languages.title', 'LIKE', "%$q%")->groupby('pages_languages.page_id');
        }
        if($slug!='') {
            $pages = $pages->where('pages.slug', 'LIKE', "%$slug%");
        }

        $pages = $pages->orderBy($sort, $order)->paginate($this->item_per_page);

        if($pages->count() > 0) {
            $this->data['pages'] = $pages;
            Debugbar::info($this->data['pages']);
            $this->data['pagination'] = $pages->appends(array('q' => $q))->links();
        } else {
            $this->data['pages'] = false;
        }

        return View::make('admin.page.index');
    }

    public function postStore()
    {
        $inputs = Input::all();
        $rules = array();

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['title_'.$lang->short_code] = 'required';
        }

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $p = Page::create(array(
                'slug'      => Str::slug($inputs['title_en']), // used en lang for slug
                'publish'   => new DateTime,
                'created_by' => $this->data['user']->id
            ));
            $lastinsert_id = $p->id;
            foreach($languages as $lang) {
                PageLanguage::create(array(
                    'page_id'       => $lastinsert_id,
                    'title'         => $inputs['title_'.$lang->short_code],
                    'language_id'   => $lang->id
                ));
            }

            Notification::success('The page was saved.');
            return Redirect::to('admin/page/edit/'.$lastinsert_id);
        } else {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
        }

        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function getEdit($id)
    {
        $page = Page::where('id',$id)
                ->with('lang')
                ->with('post_by')
                ->with('modify_by')
                ->first();
        $this->data['page'] = $page;
        $this->data['available_period'] = isset($page->available_from)? 
                                            date("Y/m/d", strtotime($page->available_from)).' - '.date("Y/m/d", strtotime($page->available_to))
                                            :'';
        $lang = array();
        foreach ($page->lang->toArray() as $key => $value) {
            $lang[$value['language_id']] = $value;
        }
        
        $this->data['page']['lang'] = $lang;
        // Debugbar::info($this->data['page']['lang']->toArray());
        return View::make('admin.page.edit');
    }

    public function postUpdate($id)
    {
        $inputs = Input::all();
        $rules = array();

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['title_'.$lang->short_code] = 'required';
        }
		$rules['slug'] = 'required';
		$rules['publish'] = 'required';
		
        $validator = Validator::make($inputs, $rules);
        if ( ! $validator->fails())
        {
			
            $page = Page::find($id);
			
			// $slug = Str::slug($inputs['title_en']);
			// $slug = ($inputs['title_en']!=)
            // $page->slug = Str::slug($inputs['title_en']);
			$page->slug = Str::slug($inputs['slug']);
            $page->status = $inputs['status'];
            $page->updated_by = Sentry::getUser()->id;
            $page->publish = $inputs['publish'] != ''? $inputs['publish'] : '';

            $available_date  = $inputs['available_period'] != ''? explode("-",trim($inputs['available_period'])) : '';
            if (is_array($available_date)) {
                $page->available_from = trim($available_date[0]);
                $page->available_to = trim($available_date[1]);
            }
            $page->update();

            foreach($languages as $lang){
                if (Input::has('title_'.$lang->short_code))
                {
                    $page_content = array(
                        'title' => $inputs['title_'.$lang->short_code],
                        'body'  => $inputs['body_'.$lang->short_code]
                    );
                    PageLanguage::where('page_id','=',$id)
                        ->where('language_id','=',$lang->id)
                        ->update($page_content);
                }
            }

            Notification::success('The page was saved.');

            return Redirect::to('admin/page/edit/'.$id);
        } else {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
        }

        return Redirect::back()->withInput();
    }
}