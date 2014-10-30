<?php
class AdminPostController extends ContentController 
{
	var $img_root_url;
	var $img_root_path = 'uploaded/post/';
	var $img_root_full_path;
	var $thumb_all_size = '80x50;110x73;160x100;320x200;226x142';
	var $thumb_size = '160x100';
    var $gallery_all_size = '80x50;110x73;160x100;330x200;512x342';
    var $gallery_thumb_size = '160x100';
	var $pattern_thumb = '%s-%s'; // '[thumbnail size]_[filename]'
	var $pattern_post_id = 'CN%s'; // 'CS[car_styleid]-[post_id]-[id]'
	var $item_per_page = 20;
    var $gallery_thumb_quality = 80;

	public function __construct()
	{
		parent::__construct();

		$this->img_root_full_path = public_path($this->img_root_path);
		$this->img_root_url = URL::asset($this->img_root_path).'/';
	}

    public function getWaitingForApprove($params = null)
    {
        // dd(new \DateTime('tomorrow'));
        $this->data['title'] = 'Waiting for approval';
        $this->data['description'] = '';

        $q = Input::get('q','');
        $post_id = Input::get('post_id','');
        $allowed_sort = ['created_at'];
        $sort = in_array(Input::get('sort'), $allowed_sort) ? Input::get('sort') : 'posts.created_at';
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $posts = Post::select('posts.*','posts_languages.title as title', 'posts_languages.description as description')
                ->join('posts_languages', 'posts_languages.post_id', '=', 'posts.id')
                ->where('status', '=', $this->status['waiting'])
                ->groupby('posts_languages.post_id')
                ->with('post_by');

        if($q!='') {
            $posts = $posts->where('posts_languages.title', 'LIKE', "%$q%")->groupby('posts_languages.post_id');
        }

        if($post_id!='') {
            list($style_id, $car_id, $post_id) = explode('-', $post_id);
            $posts = $posts->where('posts.id', $post_id);
        }

        $posts = $posts->orderBy($sort, $order)->paginate($this->item_per_page);

        if($posts->count() > 0) {
            $this->data['posts'] = $posts;
            Debugbar::info($this->data['posts'][0]->post_by);

            $this->data['pagination'] = $posts->appends(array('q' => $q))->links();
            $this->data['thumbnail_url'] = $this->img_root_url.'%s/gallery/'.sprintf($this->pattern_thumb, $this->thumb_size, '%s');
            $this->data['pattern_post_id'] = $this->pattern_post_id;
        } else {
            $this->data['posts'] = false;
        }


        // echo '<pre>';
        // dd( $this->data['posts']->toArray());
        return View::make('admin.post.waiting-index');
    }

    public function getApprove($post_id)
    {
        $post = Post::find($post_id);
        $post->status = $this->status['active'];
        $post->update();
        Notification::success('Approved.');

        // refresh index
        Event::fire('post.indexing');

        return Redirect::to('admin/post/waiting-for-approve/');
    }

    public function getDisapprove($post_id)
    {
        $post = Post::find($post_id);
        $post->status = $this->status['deleted'];
        $post->update();
        Notification::success('Disapproved.');

        // refresh index
        Event::fire('post.indexing');
        return Redirect::to('admin/post/waiting-for-approve/');
    }

    public function getUndo($post_id)
    {
        $post = Post::find($post_id);
        $post->status = $this->status['waiting'];
        $post->update();
        Notification::success('Completed. status back to waiting for approve');

        // refresh index
        Event::fire('post.indexing');
        return Redirect::to('admin/post/waiting-for-approve/');
    }

    public function getIgnore($report_id)
    {
        $report = PostReportAbuses::find($report_id);
        $report->delete();
        Notification::success('Completed.');

        // refresh index
        Event::fire('post.indexing');
        return Redirect::to('admin/post/report-listing/');
    }

    public function getRemove($post_id)
    {
        $post = Post::find($post_id);
        $post->status = $this->status['deleted'];
        $post->update();
        Notification::success('Disapproved.');

        // refresh index
        Event::fire('post.indexing');
        return Redirect::to('admin/post/');
    }

    public function getIndex($params = null)
    {
        // dd(new \DateTime('tomorrow'));
        $this->data['title'] = 'All listings';
        $this->data['description'] = '';

        $q = Input::get('q','');
        $post_id = Input::get('post_id','');
        $allowed_sort = ['created_at'];
        $sort = in_array(Input::get('sort'), $allowed_sort) ? Input::get('sort') : 'posts.created_at';
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $posts = Post::select('posts.*','posts_languages.title as title', 'posts_languages.description as description')
                ->join('posts_languages', 'posts_languages.post_id', '=', 'posts.id')
                ->where('status', '!=', $this->status['deleted'])
                ->where('status', '!=', $this->status['draft'])
                ->groupby('posts_languages.post_id')
                ->with('post_by');



        if($q!='') {
            $posts = $posts->where('posts_languages.title', 'LIKE', "%$q%")->groupby('posts_languages.post_id');
        }

        if($post_id!='') {
            list($style_id, $car_id, $post_id) = explode('-', $post_id);
            $posts = $posts->where('posts.id', $post_id);
        }

        $posts = $posts->orderBy($sort, $order)->paginate($this->item_per_page);

        if($posts->count() > 0) {
            $this->data['posts'] = $posts;
            Debugbar::info($this->data['posts'][0]->post_by);

            $this->data['pagination'] = $posts->appends(array('q' => $q))->links();
            $this->data['thumbnail_url'] = $this->img_root_url.'%s/gallery/'.sprintf($this->pattern_thumb, $this->thumb_size, '%s');
            $this->data['pattern_post_id'] = $this->pattern_post_id;
        } else {
            $this->data['posts'] = false;
        }

        // echo '<pre>';
        // dd( $this->data['posts']->toArray());
        return View::make('admin.post.index');
    }

    public function getReportListing($params = null)
    {
        // dd(new \DateTime('tomorrow'));
        $this->data['title'] = 'Reported listings';
        $this->data['description'] = '';

        $lang = Input::get('lang','th');
        $lang_id = $this->data['languages'][$lang]['id'];

        $q = Input::get('q','');
        $post_id = Input::get('post_id','');
        $allowed_sort = ['created_at'];
        $sort = 'posts_reports_abuses.created_at';
        $order = 'desc';
        $posts = Post::select('posts.*','posts_languages.title as title', 'posts_languages.description as description', 'answers_languages.title as answer_title', 'posts_reports_abuses.email as report_by', 'posts_reports_abuses.id as report_id')
                ->join('posts_languages', 'posts_languages.post_id', '=', 'posts.id')
                ->join('posts_reports_abuses', 'posts_reports_abuses.post_id', '=', 'posts.id')
                ->join('answers', 'answers.id', '=', 'posts_reports_abuses.answer_id')
                ->join('answers_languages', 'answers_languages.answer_id', '=', 'answers.id')
                //->where('status', '!=', $this->status['deleted'])
                ->where('posts_languages.language_id', '=', $lang_id)
                ->groupby('posts_languages.post_id')
                ->with('post_by');

        if($q!='') {
            $posts = $posts->where('posts_languages.title', 'LIKE', "%$q%")->groupby('posts_languages.post_id');
        }

        if($post_id!='') {
            list($style_id, $car_id, $post_id) = explode('-', $post_id);
            $posts = $posts->where('posts.id', $post_id);
        }

        $posts = $posts->orderBy($sort, $order)->paginate($this->item_per_page);

        if($posts->count() > 0) {
            $this->data['posts'] = $posts;
            Debugbar::info($this->data['posts'][0]->post_by);

            $this->data['pagination'] = $posts->appends(array('q' => $q))->links();
            $this->data['thumbnail_url'] = $this->img_root_url.'%s/gallery/'.sprintf($this->pattern_thumb, $this->thumb_size, '%s');
            $this->data['pattern_post_id'] = $this->pattern_post_id;
        } else {
            $this->data['posts'] = false;
        }


        // echo '<pre>';
        // dd( $this->data['posts']->toArray());
        return View::make('admin.post.report-index');
    }

    public function getDeleteListing($params = null)
    {
        // dd(new \DateTime('tomorrow'));
        $this->data['title'] = 'Deleted listings';
        $this->data['description'] = '';

        $q = Input::get('q','');
        $post_id = Input::get('post_id','');
        $allowed_sort = ['updated_by'];
        $sort = 'posts.updated_by';
        $order = 'desc';
        $posts = Post::select('posts.*','posts_languages.title as title', 'posts_languages.description as description', 'answers_languages.title as answer_title')
                ->join('posts_languages', 'posts_languages.post_id', '=', 'posts.id')
                ->join('answers', 'answers.id', '=', 'posts.delete_reason')
                ->join('answers_languages', 'answers_languages.answer_id', '=', 'answers.id')
                ->where('posts.status', '=', $this->status['deleted'])
                ->groupby('posts_languages.post_id')
                ->with('post_by');

        if($q!='') {
            $posts = $posts->where('posts_languages.title', 'LIKE', "%$q%")->groupby('posts_languages.post_id');
        }

        if($post_id!='') {
            list($style_id, $car_id, $post_id) = explode('-', $post_id);
            $posts = $posts->where('posts.id', $post_id);
        }

        $posts = $posts->orderBy($sort, $order)->paginate($this->item_per_page);

        if($posts->count() > 0) {
            $this->data['posts'] = $posts;
            Debugbar::info($this->data['posts'][0]->post_by);

            $this->data['pagination'] = $posts->appends(array('q' => $q))->links();
            $this->data['thumbnail_url'] = $this->img_root_url.'%s/gallery/'.sprintf($this->pattern_thumb, $this->thumb_size, '%s');
            $this->data['pattern_post_id'] = $this->pattern_post_id;
        } else {
            $this->data['posts'] = false;
        }

        // echo '<pre>';
        // dd( $this->data['posts']->toArray());
        return View::make('admin.post.delete-index');
    }

    // add method require just title of all languages
    public function postStore()
    {
        $inputs = Input::all();
        $rules = array();

        $rules['year'] = 'required';
        $rules['make'] = 'required';
        $rules['model'] = 'required';
        $rules['submodel'] = 'required';

        $languages = Language::all();

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $now = new DateTime;

            $request = Request::instance();
            $request->setTrustedProxies(array('127.0.0.1')); // only trust proxy headers coming from the IP addresses on the array (change this to suit your needs)
            $ip = $request->getClientIp();

            $post = Post::create(array(
                    'publish'       => $now,
//                    'slug'          => Str::slug($inputs['title_en']),
                    'available_from'=> $now,
                    'available_to'  => Carbon::now()->addDays(30),
                    'status'        => $this->status['draft'],
                    'created_by'    => $this->data['user']->id,
                    'make_id'       => $inputs['make'],
                    'model_id'      => $inputs['model'],
                    'submodel_id'   => $inputs['submodel'],
                    'year_id'       => $inputs['year'],
                    'ip'            => $ip
            ));

            $lastinsert_id = $post->id;
        
            foreach($languages as $lang){
                PostLanguage::create(array(
                    'post_id'       => $lastinsert_id,
                    'title'         => '',
                    'description'   => '',
                    'detail'        => '',
                    'language_id'   => $lang->id
                ));
            }

            Notification::success('The post was saved.');
            return Redirect::to('admin/post/edit/'.$lastinsert_id);
        } else {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
        }

        return Redirect::back()->withInput();
    }

    public function getEdit($id)
    {
        $parts = CarbasePart::with(array('lang' => function($query) { 
               $query->where('language_id', '1');
           }))->get();
        $this->data['parts'] = $parts->toArray();
    	$this->data['post'] = Post::where('id', $id)
                        ->with('lang')
    					->with('post_by')
    					->with('modify_by')
                        ->with('tags')
    					->first();

        $lang = array();
        foreach ($this->data['post']->lang as $key => $value) {
            $lang[$value->language_id] = $value->toArray();
        }

        $tags = array();
        foreach ($this->data['post']->tags as $key => $value) {
            $tags[] = $value->tag_text;
        }
        $tags_line = '';
        if (!empty($tags)) {
            $tags_line = implode(',', $tags);
        }

        sort($this->data['languages']);

        $this->data['post_form'] = '';
        if ($this->data['post']->ip != '' && $this->data['post']->ip != '::1' && $this->data['post']->ip != '127.0.0.1') {
            $post_from = $this->geoFromIPAddress($this->data['post']->ip);

            if (isset($post_from['streetName'])) {
                $this->data['post_form'] .= $post_from['streetName'].' ';
            }
            if (isset($post_from['cityDistrict'])) {
                $this->data['post_form'] .= $post_from['cityDistrict'].' ';
            }
            if (isset($post_from['city'])) {
                $this->data['post_form'] .= $post_from['city'].' ';
            }
            if (isset($post_from['zipcode'])) {
                $this->data['post_form'] .= $post_from['zipcode'].' ';
            }
            if (isset($post_from['county'])) {
                $this->data['post_form'] .= $post_from['county'].' ';
            }
            if (isset($post_from['region'])) {
                $this->data['post_form'] .= $post_from['region'].' ';
            }
            if (isset($post_from['country'])) {
                $this->data['post_form'] .= $post_from['country'].' ';
            }
        }

        $this->data['post']->tags_line = $tags_line;
        $this->data['post']->lang = $lang;
        $this->data['post']->parts_ids = (isset($this->data['post']->parts_ids)) ? explode(',', $this->data['post']->parts_ids) : '';
    	$this->data['title'] = 'Edit post';
    	$this->data['gallery'] = PostGallery::where('post_id','=',$id)->orderBy('order','asc')->get();
        $this->data['thumbnail_url'] = $this->img_root_url.$id.'/'.sprintf($this->pattern_thumb, $this->thumb_size, '%s');
        $this->data['gallery_url'] = $this->img_root_url.$id.'/gallery/%s';
        $this->data['gallery_thumbnail_url'] = $this->img_root_url.$id.'/gallery/'.sprintf($this->pattern_thumb, $this->thumb_size, '%s');
        $this->data['gallery_delete_url'] = URL::to('admin/post/delete-gallery/'.$id.'/%s');
        $this->data['thumbnail_size_all'] = explode(';', $this->thumb_all_size);

		return View::make('admin.post.edit');
    }

    public function postEdit($id)
    {
		$inputs = Input::all();

// echo '<pre>';
// dd($inputs);

        $post = Post::where('id', $id)
                ->with('tags')->first();
		
        $rules = array();

        $languages = Language::all();
		
//         foreach($languages as $lang) {
//             $rules['title_'.$lang->short_code] = 'required';
//			 $rules['description_'.$lang->short_code] = 'required';
//         }
		
		$rules['price'] = 'required';
		// $rules['phone'] = 'required';
		$rules['publish'] = 'required';
		// $rules['available_period'] = 'required';
		

        $validator = Validator::make($inputs, $rules);
        if ( ! $validator->fails())
        {
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
                        'post_id' => $id,
                        'tag_text' => $value
                    );
                    PostTag::updateOrCreate($pt_data);
                }

	        	//$post->tags()->sync(explode(",",$inputs['tags']));
			}

            $post->updated_by = Sentry::getUser()->id;
			$post->updated_at = new DateTime;
            $post->publish = ($inputs['publish'] != '') ? $inputs['publish'] : '';
			
			$post->status = (Input::has('status')) ? $inputs['status'] : $this->status['inactive'];

            if (isset($available_date)) {
                $available_date  = ($inputs['available_period'] != '') ? explode("-",trim($inputs['available_period'])) : '';
                if (is_array($available_date)) {
                    $post->available_from = trim($available_date[0]);
                    $post->available_to = trim($available_date[1]);
                }
            }

			// $post->slug = Str::slug($inputs['title_en']);
			$post->price = $inputs['price'];
			$post->phone = $inputs['phone'];
			// $post->latitude = $inputs['lat'];
			// $post->longitude = $inputs['lng'];
			// $post->address = $inputs['address'];
			$post->year_id = $inputs['year'];
			$post->make_id = $inputs['make'];
			$post->model_id = $inputs['model'];
			$post->gear_id = $inputs['gear'];
			$post->color_id = $inputs['color'];
            $post->engine_id = $inputs['engine'];
            $post->fuel_id = $inputs['fuel'];
            $post->submodel_id = $inputs['submodel'];
            $post->parts_ids = (isset($inputs['parts']) && is_array($inputs['parts'])) ? implode(',', $inputs['parts']) : '';
			
			$post->province_id = $inputs['province'];
			$post->amphur_id = $inputs['amphur'];
			$post->district_id = $inputs['district'];

            $post->suggest = $inputs['suggest'];
			// $post->zipcode_id = $inputs['zipcode'];

            $amphur = '';
            $district = '';
            $province = '';
            if ($post->amphur_id != "") {
                $amphur = Amphur::where('id', $post->amphur_id)->first();
                $amphur = $amphur->name;
            }
            if ($post->district_id != "") {
                $district = District::where('id', $post->district_id)->first();
                $district = $district->name;
            }
            if ($post->province_id != "") {
                $province = Province::where('id', $post->province_id)->first();
                $province = $province->name;

                $address = $province.' '.$amphur.' '.$district;
                $geo = $this->geoFromAddress($address);
                $post->latitude = $geo->getLatitude();
                $post->longitude = $geo->getLongitude();

                $post->address = '';

                if ($geo->getCityDistrict()) {
                    $post->address .= ' '.$geo->getCityDistrict();
                }
                if ($geo->getCity()) {
                    $post->address .= ' '.$geo->getCity();
                }
                if ($geo->getZipcode() ) {
                    $post->address .= ' '.$geo->getZipcode() ;
                }
                if ($geo->getCountry()) {
                    $post->address .= ' '.$geo->getCountry();
                }
            }
			
			$post->update();

            foreach($languages as $lang){

//                echo Input::has('detail_'.$lang->short_code);
               // dd($_POST['detail_'.$lang->short_code]);

                //if (Input::has('detail_'.$lang->short_code))
                //{
                    $page_content = array(
                        // 'title' => $inputs['title_'.$lang->short_code],
//                        'description'  => $inputs['description_'.$lang->short_code],
						'detail' => $inputs['detail_'.$lang->short_code]
                    );

                    PostLanguage::where('post_id','=',$id)
                        ->where('language_id','=',$lang->id)
                        ->update($page_content);
                //}
            }
			// echo '<pre>';
			// dd(Input::all());
            Notification::success('The page was saved.');

            // refresh index
            Event::fire('post.indexing');

            return Redirect::to('admin/post/edit/'.$id);
			
        }else {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
        }

        return Redirect::back()->withInput();
		//
		// // dd(explode(",",$inputs['tags']));
		//
		//
		//
		//         echo '<pre>';
		//         Debugbar::info($post->tags->toArray());
		//         var_dump(Input::all());
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
        	$post = Post::find($id);
            $post->update(array(
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
                'deleteUrl'     => URL::to('admin/post/delete-thumbnail/'.$id)
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

    public function postUpdateGalleryOrder() {
        $input = Input::get('gal_id');
        // var_dump($input);
        for($i = 0;$i<count($input);$i++){
            $gal = PostGallery::find($input[$i]);
            if($i==0) {
                $post = Post::find($gal->post_id);
                $post->update(array(
                    'thumbnail' => $gal->name
                ));
            }
            $gal->update(array('order'=>$i,'updated_at'=> new DateTime));
        }
        // refresh index
        Event::fire('post.indexing');

        return json_encode(array('status'=>'success'));
    }

    public function postFileupload()
    {
        $file_input_name = 'files';
        $id = Input::get('id');

        $gallery_url = $this->img_root_url.$id.'/gallery/';
        $gallery_path = $this->img_root_full_path.$id.'/gallery/';

        $this->makeDirectory($gallery_path);

        if (Input::hasFile($file_input_name))
        {
            $file = Input::file($file_input_name)[0];
            // dd(Input::file($file_input_name)->getClientOriginalExtension());

            $filesize = $file->getSize();
            $filename = Carbon::now()->timestamp . '.' . $file->guessExtension();

            // Save original file
            $file->move($gallery_path, $filename);

            // stamp database
            $data = array(
                        'post_id'   =>$id,
                        'name'      =>$filename,
                        'size'      =>$filesize,
                        'order'     =>0
                    );
            $gal = PostGallery::create($data);
            $lastinsert_id = $gal->id;

            // resize image process
            $img_size = explode(';', $this->gallery_all_size);
            if(is_array($img_size) && !empty($img_size))
            foreach ($img_size as $key => $value) {
                $size = $value;
                $this->resizeImage($gallery_path.$filename, $gallery_path.$size.'-'.$filename, $size);
            }

            // save file as png with medium quality
            // $img->save($gallery_path.$resizeName, $this->gallery_thumb_quality);
            
            $results = ['name'=>$filename,
                        'thumbnailUrl'=> $gallery_url.$this->gallery_thumb_size.'-'.$filename,
                        'url'=> $gallery_url.$filename,
                        'size'=>$filesize,
                        'deleteType'=>'get',
                        'id' => $lastinsert_id,
                        'deleteUrl'=> URL::to('admin/post/delete-gallery/'.$id.'/'.$lastinsert_id)];
            $res[] = $results;

            // update thumbnail from first item of gallery
            $gallery =PostGallery::where('post_id',$id)->get();
            if($gallery->count()==1) {
                $post = Post::find($id);
                $post->update(array(
                    'thumbnail' => $filename
                ));
            }


            // refresh index
            Event::fire('post.indexing');

            return array('files'=>$res);
        }else {
            $res[] = ['error'=>true];
            return array('files'=>$res);
        }   
        
    }

    public function byteFormat($bytes, $unit = "", $decimals = 2) {
        $units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 
                'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);
 
        $value = 0;
        if ($bytes > 0) {
            // Generate automatic prefix by bytes 
            // If wrong prefix given
            if (!array_key_exists($unit, $units)) {
                $pow = floor(log($bytes)/log(1024));
                $unit = array_search($pow, $units);
            }
 
            // Calculate byte value by prefix
            $value = ($bytes/pow(1024,floor($units[$unit])));
        }
 
        // If decimals is not numeric or decimals is less than 0 
        // then set default value
        if (!is_numeric($decimals) || $decimals < 0) {
            $decimals = 2;
        }
 
        // Format output
        return sprintf('%.' . $decimals . 'f '.$unit, $value);
    }

    public function missingMethod($parameters = array())
    {
        //
    }

    public function getDeleteGallery($post_id, $gallery_id) {
        // dd($post_id, $gallery_id);
        // $gallery = PostGallery::where('post_id','=', $post_id)->where('id', $gallery_id)->first();


        $gallery_path = $this->img_root_full_path.$id.'/gallery/';
		
		$gallery = PostGallery::find($gallery_id);
        $filename = $gallery->name;
        $gallery->delete();
		File::delete($gallery_path.$filename);
	        
        // refresh index
        // Event::fire('post.indexing');

        return json_encode(array($filename=>true));


    }

    // public function getDestroy($id){
        
    //     $post = Post::find($id); //Content::where('id','=',$id)->get();

    //     $post_language = PostLanguage::where('post_id','=', $post->id);
    //     $post_language->delete();

    //     $gallery = PostGallery::where('post_id','=', $post->id);
    //     $gallery->delete();

    //     File::deleteDirectory($this->image_path.$id, true); // BOOM
        
    //     $post->delete();

    //     // refresh index
    //     //Event::fire('cars.indexing');
    
    //     return Redirect::to('/admin/post'); 
    // }
}	
?>