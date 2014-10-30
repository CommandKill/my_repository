<?php

class PostController extends SiteController 
{
    var $img_root_url;
    var $img_root_path = 'uploaded/post/';
    var $img_root_full_path;
    var $thumb_all_size = '80x50;110x73;160x100;320x200';
    var $thumb_size = '160x100';
    var $gallery_all_size = '80x50;110x73;160x100;330x200;512x342';
    var $gallery_thumb_size = '160x100';
    var $pattern_thumb = '%s-%s'; // '[thumbnail size]_[filename]'
    var $pattern_post_id = 'CS%s-%s-%s'; // 'CS[car_styleid]-[post_id]-[id]'
    var $item_per_page = 20;
    var $gallery_thumb_quality = 80;

    public function __construct()
    {
        parent::__construct();

        // filter route ro something before
		$this->img_root_full_path = public_path($this->img_root_path);
		$this->img_root_url = URL::asset($this->img_root_path).'/';
		
        $this->beforeFilter('@filterRequests');
    }

	/**
     * Filter the incoming requests.
     */
    public function filterRequests($route, $request)
    {
        Debugbar::info('route ',$route, 'request',$request);
    }

    public function postStore()
    {
        $input = Input::all(); 
        $member_id = Session::get('member.id');
		
		$date = new DateTime;
		
		$interval = new DateInterval('P1M');

		
		
        $data = array(
                    'created_by'     => $member_id,
					 'status'		=> $this->status['draft'],
					 'available_from' =>$date,
					 'available_to' => $date->add($interval),
                     'ip' => Request::getClientIp(true)
                );
				
        $post = Post::create($data);
        
        $insert_id = $post->id;
        
        $langs = Language::all();
        foreach($langs as $lang)
        {
            PostLanguage::create(array(
                'post_id'    => $insert_id,
                'title'         => '',
                'description'   => '',
                'detail'        => '',
                'language_id'   => $lang->id
            ));
			
			// PostTag::create(array('post_id'=>$insert_id,'tag_text'=>'','language_id'=>$lang->id));
        }

        $post = Post::find($insert_id);

        // return post id in json format
        return Response::json(array(
            'error' => false,
            'post' => $post),
            200
        );
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
			// dd($img_folder_path." > name > ".$filename." > id ".$id. ' > root url '.$img_folder_url );
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
            return array('files'=>$res);
        }else {
            $res[] = ['error'=>true];
            return array('files'=>$res);
        }
    }
	public function getDeleteThumbnail($id){
		
        $img_folder_path = $this->img_root_full_path.$id.'/';
		
		$post = Post::find($id);
		$filename = $post->thumbnail;
		File::delete($img_folder_path.$filename);
		
        $post->thumbnail = '';
		$post->update();
		
		
	        
        // refresh index
        // Event::fire('post.indexing');

        return json_encode(array($filename=>true));
		
		
		
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
        return json_encode(array('status'=>'success'));
    }

    public function postFileupload()
    {
		
		// dd(Input::file('gallery')[0]);
        $file_input_name = 'gallery';
        $id = Input::get('id');
		$gal_id = (Input::has('gal_id')) ? Input::get('gal_id') : 0;

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
			
			$gal = '';		
			if($gal_id!=0) {
				$gal = PostGallery::find($gal_id);
				$gal->update($data);
			}else {		
            	$gal = PostGallery::create($data);
			}
            $lastinsert_id = $gal->id;
			
			// save thumbnail first
			$gallery =PostGallery::where('post_id',$id)->get();
			// dd($id.'<br />'.$gallery);
			if($gallery->count()==1) {
	        	$post = Post::find($id);
	            $post->update(array(
	            	'thumbnail' => $filename
	            ));
			}
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
                        'deleteUrl'=> URL::to('post/delete-gallery/'.$id.'/'.$lastinsert_id)];
            $res[] = $results;          
            return array('files'=>$res);
        }else {
            $res[] = ['error'=>true];
            return array('files'=>$res);
        }   
        
    }

    public function getDeleteGallery($post_id, $gallery_id) {
        // dd($post_id, $gallery_id);
        $gallery_path = $this->img_root_full_path.$post_id.'/gallery/';
		
		$gallery = PostGallery::find($gallery_id);
        $filename = $gallery->name;
        $gallery->delete();
        File::delete($gallery_path.$filename);
		
		$img_size = explode(';', $this->gallery_all_size);
        if(is_array($img_size) && !empty($img_size))
        foreach ($img_size as $key => $value) {
			$size = $value;
			File::delete($gallery_path.$size.'-'.$filename);
		   
        }
		
		
	        
        // refresh index
        // Event::fire('post.indexing');

        return json_encode(array($filename=>true));
		
		
    }

    public function getDetail($id)
    {
        // $post = Post::find($id)->with('post_by')->with('lang')->with('gallery');
		 $post = Post::where('id', $id)->with('lang')->with('post_by')->with('tags')->with('gallery')->first();
		$provinceName = '';
		$gallery = $post->gallery()->orderBy('order','ASC')->get();
		$lang = $post->lang()->orderBy('id', 'DESC')->get();
	
		
		$post_by = $post->post_by;
		
		$province_id = ($post_by->province_id!=0) ? $post_by->province_id : $post->province_id;
		
		if($province_id!='' && $province_id!=0) {
			$province = Province::find($province_id);
			$provinceName = $province->name;
		}
		
	   $tags = array();
       foreach ($post->tags as $key => $value) {
           $tags[] = $value->tag_text;
       }
       $tags_line = '';
       if (!empty($tags)) {
           $tags_line = implode(',', $tags);
       }
			   

        return Response::json(array(
            'error' => false,
            'post' => $post,
			'tags' => $tags,
			'gallery' => $gallery,
			'lang'=>$lang,
			'post_by'=>$post_by,
			'province'=>$provinceName),
            200
        );
    }

    //latitude=13.6854414
    // &longitude=100.61480840000002
    // &year=4
    // &make=1
    // &model=5
    // &submodel=26
    // &gear=1
    // &car_not_exist=yes
    // &suggest=dsadsadsadsadadasdsad
    // &price=432
    // &mileage=3213
    // &part%5B%5D=3&part%5B%5D=5&part%5B%5D=6&part%5B%5D=8
    // &description_en=32131
    // &description_th=3213213
    // &use_current_location=
    // &type=on
    // &province=1
    // &amphur=18
    // &district=122
    // &phone=3213
    // &line_id=13213213 

    public function postUpdate()
    {
        $input = Input::all();
        $post_id = $input['post_id'];
        $post = Post::find($post_id);
        $post->mileage = (Input::has('mileage')) ? $input['mileage'] : '';
        $post->price = (Input::has('price')) ? $input['price'] : '';
		$post->phone = (Input::has('phone')) ? $input['phone'] : '';
		$post->line_id = (Input::has('line_id')) ? $input['line_id'] : '';
		// check if select use current location
		
		if($input['submit_click']==1 && ($post->status != $this->status['active'] && $post->status != $this->status['inactive'])) {
			$post->status = $this->status['waiting'];
		}
		
        if(isset($inputs['use_current_location'])) {
            $lat = $input['latitude'];
            $lon = $input['longitude'];
            $geo = $this->geoFromLatLon($lat, $lon);
        } else {
            $address = $input['address'];
            $geo = $this->geoFromAddress($address);
        }

		            // Here is the mapping:
		            // Street Number: %n
		            // Street Name: %S
		            // City: %L
		            // City District: %D
		            // Zipcode: %z
		            // County: %P
		            // County Code: %p
		            // Region: %R
		            // Region Code: %r
		            // Country: %C
		            // Country Code: %c
		            // Timezone: %T

		            // $formatter = new \Geocoder\Formatter\Formatter($geo);
		            // dd($formatter->format('%S %n %z %L'));


        $address = '';

        if ($geo->getCityDistrict()) {
            $address .= ' '.$geo->getCityDistrict();
        }
        if ($geo->getCity()) {
            $address .= ' '.$geo->getCity();
        }
        if ($geo->getZipcode() ) {
            $address .= ' '.$geo->getZipcode() ;
        }
        if ($geo->getCountry()) {
            $address .= ' '.$geo->getCountry();
        }
        $post->latitude = $geo->getLatitude();
        $post->longitude = $geo->getLongitude();
		$post->address = $address;
		
        $post->province_id = (Input::has('province_id')) ? $input['province_id'] : '';
        $post->amphur_id = (Input::has('amphur_id')) ? $input['amphur_id'] : '';
        $post->district_id = (Input::has('district_id')) ? $input['district_id'] : '';
        $post->zipcode_id = (Input::has('zipcode_id')) ? $input['zipcode_id'] : '';
        // $post->latitude = (Input::has('latitude')) ? $input['latitude'] : '';
        // $post->longitude = (Input::has('longitude')) ? $input['longitude'] : '';
        //
        // $post->province_id = (Input::has('province_id')) ? $input['province_id'] : '';
        // $post->amphur_id = (Input::has('amphur_id')) ? $input['amphur_id'] : '';
        // $post->district_id = (Input::has('district_id')) ? $input['district_id'] : '';
        // $post->zipcode_id = $input['zipcode_id'];

        // if (Input::has('same_address')) {
        //     $post->user_info_addr = 1;
        // } else {
        //     $post->user_info_addr = 0;
        // }

        if (Input::has('car_not_exist')) {
            $post->suggest = (Input::has('suggest')) ? $input['suggest'] : '';
        } else {
            $post->suggest = '';
        }

        $post->year_id = (Input::has('year_id')) ? $input['year_id'] : '';
        $post->make_id = (Input::has('make_id')) ? $input['make_id'] : '';
        $post->model_id = (Input::has('model_id')) ? $input['model_id'] : '';
        $post->submodel_id = (Input::has('submodel_id')) ? $input['submodel_id'] : '';

        $post->gear_id = (Input::has('gear_id')) ? $input['gear_id'] : '';
        $post->fuel_id = (Input::has('fuel_id')) ? $input['fuel_id'] : '';
        $post->engine_id = (Input::has('engine_id')) ? $input['engine_id'] : '';
        $post->color_id = (Input::has('color_id')) ? $input['color_id'] : '';
		$post->parts_ids = (Input::has('part')) ? implode(",",$input['part']) : '';
        $post->update();  

        Debugbar::info($this->languages);
		
		
		PostTag::where('post_id','=', $post_id)->delete();
		// dd($post_id);
		
		$tags = explode(',',$input['tags']);
		foreach($tags as $k=>$v){
			$tags_data = array();
			$tags_data['post_id'] = $post_id;
			$tags_data['tag_text'] = $v;
			PostTag::create($tags_data);
		}
		
        foreach($this->languages as $key => $lang){
            if (Input::has('description_'.$key) || Input::has('detail_'.$key))
            {
                $content_data = array();
                //$title = $input['title_'.$lang->short_code];
                $description = $input['description_'.$key];
                $detail = $input['detail_'.$key];
                //$content_data['title'] = $title;
                $content_data['description'] = $description;
                $content_data['detail'] = $detail;
				// dd($lang);
				// dd('post id ::'.$post_id." , lang id :: ".$);
                PostLanguage::where('post_id',$post_id)
                            ->where('language_id',$lang['id'])->update($content_data);
            }
			
			// if(Input::has('tags_'.$key)) {
			// 	$tags = explode(',',$input['tags_'.$key]);
			// 	foreach($tags as $k=>$v){
			// 		$tags_data = array();
			// 		$tags_data['post_id'] = $post_id;
			// 		$tags_data['tag_text'] = $v;
			// 		$tags_data['language_id'] = $lang['id'];
			// 		PostTag::create($tags_data);
			// 	}
			//
			// 	// PostTag::where('post_id',$post_id)->where('language_id',$lang['id'])->update($content_data);
			// }
			
			
			
        }

        $post = Post::find($post_id);

        // return post id in json format
        return Response::json(array(
            'error' => false,
            'post' => $post),
            200
        );
    }


}






