<?php
class AdminBlogController extends \AdminController 
{
    var $item_per_page = 20;
    var $img_root_url;
    var $img_root_path = 'uploaded/blog/';
    var $img_root_full_path;
    var $thumb_all_size = '80x50;110x73;160x100;320x200;709x400';
    var $thumb_size = '160x100';
    var $pattern_thumb = '%s-%s'; // '[thumbnail size]_[filename]'
    var $pattern_post_id = 'CS%s-%s-%s'; // 'CS[car_styleid]-[post_id]-[id]'
    var $gallery_thumb_quality = 80;

	public function __construct()
	{
		parent::__construct();

        $this->img_root_full_path = public_path($this->img_root_path);
        $this->img_root_url = URL::asset($this->img_root_path).'/';

		$this->data['title'] = 'Blogs';
		$this->data['description'] = '';
	}

    public function getIndex()
    {
        $q = Input::get('q','');
        $slug = Input::get('slug','');
        $pages = Page::with('lang');
        $allowed_sort = ['created_at'];
        $sort = in_array(Input::get('sort'), $allowed_sort) ? Input::get('sort') : 'blogs.created_at';
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';

        $blogs = Blog::select('blogs.*','blogs_languages.title as title')
                ->join('blogs_languages', 'blogs_languages.blog_id', '=', 'blogs.id')
                ->where('status', '!=', $this->status['deleted'])
                ->groupby('blogs_languages.blog_id')
                ->with('post_by');

        if($q!='') {
            $blogs = $blogs->where('blogs_languages.title', 'LIKE', "%$q%")->groupby('blogs_languages.blog_id');
        }
        if($slug!='') {
            $blogs = $blogs->where('blogs.slug', 'LIKE', "%$slug%");
        }

        $blogs = $blogs->orderBy($sort, $order)->paginate($this->item_per_page);

        if($blogs->count() > 0) {
            $this->data['pages'] = $blogs;
            Debugbar::info($this->data['pages']);
            $this->data['pagination'] = $blogs->appends(array('q' => $q))->links();
        } else {
            $this->data['pages'] = false;
        }

        return View::make('admin.blog.index');
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
            $p = Blog::create(array(
                'slug'      => Str::slug($inputs['title_en']), // used en lang for slug
                'publish'   => new DateTime,
                'created_by' => $this->data['user']->id
            ));
            $lastinsert_id = $p->id;
            foreach($languages as $lang) {
                BlogLanguage::create(array(
                    'blog_id'       => $lastinsert_id,
                    'title'         => $inputs['title_'.$lang->short_code],
                    'language_id'   => $lang->id
                ));
            }

            Notification::success('The page was saved.');
            return Redirect::to('admin/content-blog/edit/'.$lastinsert_id);
        } else {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
        }

        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function getEdit($id)
    {
        $page = Blog::where('id',$id)
                ->with('lang')
                ->with('post_by')
                ->with('modify_by')
                ->with('tags')
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

        $tags = array();
        foreach ($this->data['page']->tags as $key => $value) {
            $tags[] = $value->tag_text;
        }
        $tags_line = '';
        if (!empty($tags)) {
            $tags_line = implode(',', $tags);
        }
        $this->data['page']->tags_line = $tags_line;

        $this->data['thumbnail_url'] = $this->img_root_url.$id.'/'.sprintf($this->pattern_thumb, $this->thumb_size, '%s');
        krsort($this->data['languages']);
        // Debugbar::info($this->data['page']['lang']->toArray());
        return View::make('admin.blog.edit');
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
			
            $page = Blog::find($id);
			
			// $slug = Str::slug($inputs['title_en']);
			// $slug = ($inputs['title_en']!=)
            // $page->slug = Str::slug($inputs['title_en']);
			$page->slug = Str::slug($inputs['slug']);
            $page->status = $inputs['status'];
            $page->promoted = isset($inputs['promoted'])? 1 : 0;
            $page->updated_by = Sentry::getUser()->id;
            $page->publish = $inputs['publish'] != ''? $inputs['publish'] : '';

            $available_date  = $inputs['available_period'] != ''? explode("-",trim($inputs['available_period'])) : '';
            if (is_array($available_date)) {
                $page->available_from = trim($available_date[0]);
                $page->available_to = trim($available_date[1]);
            }
            $page->update();

            if(Input::has('tags') && !empty($inputs['tags'])) {

                // remove all of this post_id first
                // PostTag::where('post_id', $id)->delete();

                // new add
                // echo '<pre>';
                $tags = explode(",",$inputs['tags']);
                foreach ($tags as $key => $value) {
                    $data['text'] = $value;
                    Tag::updateOrCreate($data);
                    $pt_data = array(
                        'blog_id' => $id,
                        'tag_text' => $value
                    );
                    BlogTag::updateOrCreate($pt_data);
                }

                //$post->tags()->sync(explode(",",$inputs['tags']));
            }

            foreach($languages as $lang){
                if (Input::has('title_'.$lang->short_code))
                {
					
                    $page_content = array(
                        'title' => $inputs['title_'.$lang->short_code],
						'short_desc' => $inputs['short_desc_'.$lang->short_code],
                        'body'  => $inputs['body_'.$lang->short_code]
                    );
                    BlogLanguage::where('blog_id','=',$id)
                        ->where('language_id','=',$lang->id)
                        ->update($page_content);
                }
            }

            Notification::success('The blog was saved.');

            return Redirect::to('admin/content-blog/edit/'.$id);
        } else {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
        }

        return Redirect::back()->withInput();
    }
}