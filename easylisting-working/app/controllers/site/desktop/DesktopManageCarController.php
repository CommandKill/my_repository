<?php

class DesktopManageCarController extends SiteController
{
	var $content_type;
	var $languages;

	var $image_size;
	var $image_url;
	var $image_path;
	var $thumb_size;
	var $image_large_size;
	var $image_small_size;
	var $image_file_format;
	var $gallery_thumb_prefix;
	var $gallery_thumb_size;
	var $gallery_thumb_quality;
	
    public function __construct()
    {
        parent::__construct();
		$this->languages = Language::all();

		$this->content_type = Config::get('site.content_type.car');

       	$this->image_size = Config::get('site.car_images_size');
		$this->image_url = Config::get('site.uploaded_url').Config::get('site.car_image_folder_name');
		$this->image_path = Config::get('site.uploaded_path').Config::get('site.car_image_folder_name');
		$this->image_file_format = Config::get('site.car_image_file_format');
		$this->thumb_size = $this->image_size[Config::get('site.index_car_image_thumbnail_size')];
		$this->image_large_size = $this->image_size[Config::get('site.index_car_image_large_size')];
		$this->image_small_size = $this->image_size[Config::get('site.index_car_image_small_size')];

		$this->gallery_thumb_prefix = Config::get('site.car_gallery_thumb_prefix');
		$this->gallery_thumb_size = Config::get('site.car_gallery_thumb_size');
		$this->gallery_thumb_quality = Config::get('site.car_gallery_thumb_quality');
		
		if(!Session::has('member.id')) {
			// return Redirect::to('/signin');
			App::abort(404);
		}
    }

    public function getNew()
    {
    	$action = URL::to(App::getLocale().'/my-garage/car/new');
    	return View::make('site.desktop.member.my-garage.car-select')
    			->with('new',true)
    			->with('action', $action);
    }

    public function getSelect($car_id=0)
    {
    	if ($car_id == 0) {
    		$car_base = '';
    		$car_colors = '';
    		$car_parts = '';
    		$content = '';
    	} else {
    		$content = Content::find($car_id);
    		$car_base = CarVehicles::where('id',$content->car_id)->first();	
    		$car_colors = CarColors::where('id','=',$content->car_color)->first();
    		$car_parts = ($content->car_parts != '')? 
    						CarParts::whereIn('id', explode(',', $content->car_parts))->get() 
    						: '';
    		//(strpos($content->car_parts,',') !== false)? 
    	}

    	$action = URL::to(App::getLocale().'/my-garage/car/'.$car_id.'/select');
    	return View::make('site.member.my-garage.car-select')
    			->with('new',false)
    			->with('action', $action)
    			->with('id', $car_id)
    			->with('content', $content)
    			->with('car_base', $car_base)
    			->with('car_colors', $car_colors)
    			->with('car_parts', $car_parts)
    			->with('languages', $this->languages);
    }

    public function getInformation($car_id=0)
    {
    	// first status == draft
    	$action = URL::to(App::getLocale().'/my-garage/car/'.$car_id.'/information');
    	$content = Content::where('id', $car_id)->with('data')->first();

    	return View::make('site.member.my-garage.car-information')
    			->with('id', $car_id)
    			->with('action', $action)
    			->with('content', $content)
    			->with('languages', $this->languages);
    }

    public function getAddress($car_id=0)
    {
    	$action = URL::to(App::getLocale().'/my-garage/car/'.$car_id.'/address');
    	$content = Content::where('id', $car_id)->with('data')->first();

    	return View::make('site.member.my-garage.car-address')
    			->with('id', $car_id)
    			->with('action', $action)
    			->with('content', $content)
    			->with('languages', $this->languages);
    }

    public function getImage($car_id=0)
    {
    	$content = Content::find($car_id);
    	$gallery = Gallery::where('content_id',$car_id)->orderBy('order', 'asc')->get();
		if(is_object($gallery) && ($gallery->count() > 0)) {
			foreach ($gallery as $gal) {
				$gal->size = $this->byteFormat($gal->size,"MB",1);
			}
		}

		$destination_url = $this->image_path . $car_id . '/';
		
        // check all image size are exist
        $all_thumbnail = array();
        foreach($this->image_size as $size) {
        	$filename = sprintf($this->image_file_format, $size, $content->thumbnail);
			
            //if (file_exists($destination_path.$filename)) {
                $all_thumbnail[] = array(
                    'filename'      => $filename,
                    'image_path'    => $destination_url.$filename,
                    'size'          => $size
                );
            //}
        }

        $action = URL::to(App::getLocale().'/my-garage/car/'.$car_id.'/image');
    	return View::make('site.member.my-garage.car-image')
    			->with('id', $car_id)
    			->with('action', $action)
    			->with('content', $content)
    			->with('gallery', $gallery)
    			->with('destination_url', $destination_url)
    			->with('all_thumbnail', $all_thumbnail)
    			->with('languages', $this->languages);
    }

    public function getPreview($car_id=0)
    {
    	// if confirm == YES
    	// set status == 'waiting for approve'
		$content = Content::find($car_id);

		if ($content->user_info_addr == 0) {
			$province = Province::find($content->province_id);
			$amphur = Amphur::find($content->amphur_id);
			$district = District::find($content->district_id);
			$zipcode = ZipCode::find($content->zipcode_id);
		} else {
			$province = '';
			$amphur = '';
			$district = '';
			$zipcode = '';
		}

		$car_base = CarVehicles::where('id',$content->car_id)->first();	
		$car_colors = CarColors::where('id','=',$content->car_color)->first();
		$car_parts = ($content->car_parts != '')? 
						CarParts::whereIn('id', explode(',', $content->car_parts))->get() 
						: '';
		$car_gallery = Gallery::where('content_id',$car_id)->orderBy('order', 'asc')->get();

		$action = URL::to(App::getLocale().'/my-garage/car/'.$car_id.'/confirm');
    	return View::make('site.member.my-garage.car-preview')
    			->with('action', $action)
		    	->with('province', $province)
		    	->with('amphur', $amphur)
		    	->with('district', $district)
		    	->with('zipcode', $zipcode)
    			->with('id', $car_id)
    			->with('content', $content)
    			->with('car_base', $car_base)
    			->with('car_colors', $car_colors)
    			->with('car_parts', $car_parts)
    			->with('car_gallery', $car_gallery)
    			->with('destination_url', $this->image_path . $car_id . '/');
    }

    public function getThankyou($car_id=0)
    {
    	return View::make('site.member.my-garage.car-thankyou')
    			->with('id', $car_id);
    }

    public function postConfirm($car_id=0)
    {
    	// save status to waiting for approve
    	$content = Content::find($car_id);
    	$content->status = $this->status['waiting'];
    	$content->update();
		return Redirect::to(App::getLocale().'/my-garage/car/'.$car_id.'/thankyou');
    }

   	public function postNew()
   	{
		$input = Input::all(); 
		$member_id = Session::get('member.id');
		$car_available_id = $input['car_available'];
		$car_id = '';
		$car_style_id = '';
		if ($car_available_id == 'suggest') {

		} else {
			$car = CarVehicles::find($car_available_id);
			$car_id = $car->id;
			$car_style_id = $car->styleId;
		}

		$data = array(
				 	'member_id'		=> $member_id,
				 	'car_id'		=> $car_id,
				 	'car_styleid'	=> $car_style_id,
				 	'car_color'		=> $input['color'],
				 	'car_suggest'	=> $input['suggest'],
				 	'car_parts'		=> (Input::has('parts')) ? implode(',',$input['parts']) : ''
				);

		$content = Content::create($data);
		
		$insert_id = $content->id;
		
		$langs = Language::all();
		foreach($langs as $lang)
		{
			ContentData::create(array(
				'content_id' 	=> $insert_id,
				'title' 		=> '',
				'description' 	=> '',
				'detail' 		=> '',
				'language_id' 	=> $lang->id
			));
		}
		
		return Redirect::to(App::getLocale().'/my-garage/car/'.$insert_id.'/select');
	}

	public function postSelect($car_id=0)
   	{	
   		$input = Input::all(); 
   		$content = Content::find($car_id);

   		// echo '<pre>';
   		// var_dump($content);die();

   		if (Input::has('cb-have-not')) {
   			$content->car_suggest = (Input::has('suggest')) ? $input['suggest'] : '';
   			$content->car_styleid = 0;
   			$content->car_id = 0;
   			$content->car_styleid = 0;
   			$content->car_color = '';
   			$content->car_parts = '';
   		} else{
   			$car_available_id = $input['car_available'];
	   		
	   		if ($car_available_id == '') {

			} else {
				$car = CarVehicles::find($car_available_id);
				$content->car_styleid = $car->styleId;
				$content->car_id = $car_available_id;
			}
   			
   			$content->car_suggest = '';
   			$content->car_color = (Input::has('color')) ? $input['color'] : '';
   			$content->car_parts = (Input::has('parts')) ? implode(',',$input['parts']) : '';	
   		}

   		$content->update();
		return Redirect::to(App::getLocale().'/my-garage/car/'.$car_id.'/select');
	}

	public function postInformation($car_id=0)
	{
   		$input = Input::all(); 
   		$content = Content::find($car_id);
   		$content->mileage = (Input::has('mileage')) ? $input['mileage'] : '';
   		$content->price = (Input::has('price')) ? $input['price'] : '';
   		$content->video = (Input::has('video')) ? $input['video'] : '';
   		$content->update();   

   		foreach($this->languages as $lang){
			if (Input::has('title_'.$lang->short_code))
			{
				$content_data = array();
				$title = $input['title_'.$lang->short_code];
				$description = $input['description_'.$lang->short_code];
				$detail = $input['detail_'.$lang->short_code];
				$content_data['title'] = $title;
				$content_data['description'] = $description;
				$content_data['detail'] = $detail;
				
				ContentData::where('content_id',$car_id)
							->where('language_id',$lang->id)
							->update($content_data);
			}
		}

		return Redirect::to(App::getLocale().'/my-garage/car/'.$car_id.'/address');
	}

	public function postAddress($car_id=0)
	{
		$input = Input::all(); 

		$content = Content::find($car_id);

		if(Input::has('same_address')) {
			$data['user_info_addr'] = 1;
			$data['latitude'] = '';
			$data['longitude'] = '';
			$data['address'] = '';
			$data['province_id'] = '';
			$data['amphur_id'] = '';
			$data['district_id'] = '';
			$data['zipcode_id'] = '';
		} else {
			$data['user_info_addr'] = 0;
			$data['latitude'] = (Input::has('lat')) ? $input['lat'] : '';
			$data['longitude'] = (Input::has('lng')) ? $input['lng'] : '';
			$data['address'] = (Input::has('address')) ? $input['address'] : '';
			$data['province_id'] = (Input::has('province')) ? $input['province'] : '';
			$data['amphur_id'] = (Input::has('amphur')) ? $input['amphur'] : '';
			$data['district_id'] = (Input::has('district')) ? $input['district'] : '';
			$data['zipcode_id'] = (Input::has('zipcode')) ? $input['zipcode'] : '';
		}

		// 		echo '<pre>';
		// var_dump($data);die();

		$content->update($data);

		return Redirect::to(App::getLocale().'/my-garage/car/'.$car_id.'/image');
	}

    public function postFileThumbnail()
    {
        $id = Input::get('id');
        $file = Input::file('thumbnail');

        $c = Content::find($id);
		File::makeDirectory($this->image_path.'/'.$id, 0775, true, true);
		
        $data['thumbnail'] = $file->getClientOriginalName();

        if (Input::hasFile('thumbnail'))
        {
            foreach($this->image_size as $size) 
            {
            	$filename = sprintf($this->image_file_format, $size, $data['thumbnail']);
                $oldfile = sprintf($this->image_file_format, $size, $c->thumbnail);

                File::delete($this->image_path.$oldfile);

                list($w,$h) = explode('x', $size);

                $image_filename_destination = $this->image_path . $id . '/' . $filename;

                Image::make($file->getRealPath())
                    ->resize($w,$h,function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->save($image_filename_destination);
            }

            $c->update($data);

            $thumbnail_url = $this->image_url . $id . '/' . sprintf($this->image_file_format, $this->thumb_size, $data['thumbnail']);
            $original_url = $this->image_url . $id . '/' . $data['thumbnail'];
            $results = array(
                'name'          => $data['thumbnail'],
                'thumbnailUrl'  => $thumbnail_url,
                'url'           => $original_url,
                'size'          => $this->thumb_size,
                'deleteType'    =>'get',
                'deleteUrl'     => URL::to(App::getLocale().'/my-garage/delete-thumbnail/'.$id)
            );
            $res[] = $results;
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
			$gal = Gallery::find($input[$i]);
			
			$gal->update(array('order'=>$i,'updated_at'=> new DateTime));
		}
		return json_encode(array('status'=>'success'));
	}

	public function postFileUpload(){
		$id = Input::get('id');
		
		$gallery_path = $this->image_path.'/'.$id.'/gallery/';
		$gallery_url = $this->image_url.'/'.$id.'/gallery/';

		File::makeDirectory($gallery_path, 0775, true, true);
		
		$file = Input::file('files')[0];
		

		$oriname = $file->getClientOriginalName();
        $filename = $oriname;
		$fileSize = $file->getSize();
		$success = $file->move($gallery_path, $filename);
		if($success) {
			// stamp database
			$data = ['content_id'=>$id,
					 'name'=>$oriname,
					 'size'=>$fileSize,
					 'order'=>0];
			$gal = Gallery::create($data);
			$insetedID = $gal->id;
			
			$resizeName = $this->gallery_thumb_prefix.$oriname;
			list($w,$h) = explode('x', $this->gallery_thumb_size);
			$img = Image::make($gallery_path.$filename)->resize((int)$w, null, function ($constraint) {
                $constraint->aspectRatio();
            });

			// save file as png with medium quality
			$img->save($gallery_path.$resizeName, $this->gallery_thumb_quality);
			
			$results = ['name'=>$filename,
						'thumbnailUrl'=> $gallery_url.$resizeName,
						'url'=> $gallery_url.$filename,
						'size'=>$fileSize,
						'deleteType'=>'get',
						'id' => $gal->id,
						'deleteUrl'=> URL::to(App::getLocale().'/my-garage/delete-gallery/'.$id.'/'.$gal->id)];
			$res[] = $results;
						
			return array('files'=>$res);
		}else {
			$res[] = ['error'=>true];
			return array('files'=>$res);
		}	
		
	}

	public function getDeleteGallery($id,$gid){
		// echo "test";
		$gal = Gallery::find($gid);
		// var_dump($gal);
		if($gal!=null) {
			$gal->delete();
			$gallery_path = $this->image_path.'/'.$id.'/gallery/';
			
			$destinationPath = $gallery_path.$gal->name;
			// $destinationPath_small = $gallery_path.$this->gallery_thumb_prefix.$oriname;
		
			$success = File::delete($destinationPath);
			// File::delete($destinationPath_small);
			
			if($success) {
				return array('files'=>array('status'=>'success'));
			}else {
				
				return array('files'=>array('status'=>'delete failed'));
			}
			
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
}
?>