<?php
class AdminReviewController extends \AdminController 
{
    var $item_per_page = 20;
    var $img_root_url;
    var $img_root_path = 'uploaded/review/';
    var $img_root_full_path;
    var $thumb_all_size = '80x50;110x73;160x100;320x200';
    var $thumb_size = '160x100';
    var $pattern_thumb = '%s-%s'; // '[thumbnail size]_[filename]'
    var $pattern_post_id = 'CS%s-%s-%s'; // 'CS[car_styleid]-[post_id]-[id]'
    var $gallery_thumb_quality = 80;

	public function __construct()
	{
		parent::__construct();

        $this->img_root_full_path = public_path($this->img_root_path);
        $this->img_root_url = URL::asset($this->img_root_path).'/';

		$this->data['title'] = 'Reviews';
		$this->data['description'] = '';
	}

    public function getIndex()
    {
        $q = Input::get('q','');
        $slug = Input::get('slug','');
        $pages = Review::with('lang');
        $allowed_sort = ['created_at'];
        $sort = in_array(Input::get('sort'), $allowed_sort) ? Input::get('sort') : 'reviews.created_at';
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';

        $pages = Review::select('reviews.*','reviews_languages.title as title')
                ->join('reviews_languages', 'reviews_languages.review_id', '=', 'reviews.id')
                ->where('status', '!=', $this->status['deleted'])
                ->groupby('reviews_languages.review_id')
                ->with('post_by');

        if($q!='') {
            $pages = $pages->where('reviews_languages.title', 'LIKE', "%$q%")->groupby('reviews_languages.review_id');
        }
        if($slug!='') {
            $pages = $pages->where('reviews.slug', 'LIKE', "%$slug%");
        }

        $pages = $pages->orderBy($sort, $order)->paginate($this->item_per_page);

        if($pages->count() > 0) {
            $this->data['pages'] = $pages;
            Debugbar::info($this->data['pages']);
            $this->data['pagination'] = $pages->appends(array('q' => $q))->links();
        } else {
            $this->data['pages'] = false;
        }

        $this->data['thumbnail_url'] = $this->img_root_url;

        return View::make('admin.review.index');
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
            $p = Review::create(array(
                'slug'      => Str::slug($inputs['title_en']), // used en lang for slug
                'publish'   => new DateTime,
                'created_by' => $this->data['user']->id
            ));
            $lastinsert_id = $p->id;
            foreach($languages as $lang) {
                ReviewLanguage::create(array(
                    'review_id'       => $lastinsert_id,
                    'title'         => $inputs['title_'.$lang->short_code],
                    'language_id'   => $lang->id
                ));
            }

            Notification::success('The review was saved.');
            return Redirect::to('admin/content-review/edit/'.$lastinsert_id);
        } else {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
        }

        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function getEdit($id)
    {
        $page = Review::where('id',$id)
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
        $this->data['thumbnail_url'] = $this->img_root_url.$id.'/'.sprintf($this->pattern_thumb, $this->thumb_size, '%s');
        // Debugbar::info($this->data['page']['lang']->toArray());
        return View::make('admin.review.edit');
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
			
            $page = Review::find($id);
			
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

            foreach($languages as $lang){
                if (Input::has('title_'.$lang->short_code))
                {
                    $page_content = array(
                        'title' => $inputs['title_'.$lang->short_code],
						'short_desc' => $inputs['short_desc_'.$lang->short_code],
                        'body'  => $inputs['body_'.$lang->short_code]
                    );
                    ReviewLanguage::where('review_id','=',$id)
                        ->where('language_id','=',$lang->id)
                        ->update($page_content);
                }
            }

            Notification::success('The review was saved.');

            return Redirect::to('admin/content-review/edit/'.$id);
        } else {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
        }

        return Redirect::back()->withInput();
    }

    public function postFileThumbnail()
    {
        $file_input_name = 'thumbnail';
        $id = Input::get('id');
        $file = Input::file($file_input_name);

        $img_folder_url = $this->img_root_url.$id.'/';
        $img_folder_path = $this->img_root_full_path.$id.'/';
        
        // Prepare folder for store all images
        $this->makeDirectory($img_folder_path);

        if (Input::hasFile($file_input_name))
        {
            $filesize = $file->getSize();
            $filename = Carbon::now()->timestamp . '.' . Input::file($file_input_name)->guessExtension();

            // Save original file
            $file->move($img_folder_path, $filename);

            // resize image process
            $img_size = explode(';', $this->thumb_all_size);
            if(is_array($img_size) && !empty($img_size))
            foreach ($img_size as $key => $value) {
                $size = $value;
                $this->resizeImage($img_folder_path.$filename, $img_folder_path.$size.'-'.$filename, $size);
            }

            // Save thumbnail to db
            $review = Review::find($id);
            $review->update(array(
                'thumbnail' => $filename
            ));

            $thumbnail_url = $img_folder_url . sprintf($this->pattern_thumb, $this->thumb_size, $filename);
            $original_url = $img_folder_url . $filename;
            $results = array(
                'name'          => $filename,
                'thumbnailUrl'  => $thumbnail_url,
                'url'           => $original_url,
                'size'          => $filesize,
                'deleteType'    =>'get',
                'deleteUrl'     => URL::to('admin/content-review/delete-thumbnail/'.$id)
            );
            $res[] = $results;

            // refresh index
            Event::fire('post.indexing');

            return array('files'=>$res);
        }else {
            $res[] = ['error'=>true];
            return array('files'=>$res);
        }
    }
}