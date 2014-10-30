<?php
	
use Artdarek\OAuth\Facade\OAuth as Social;

class DesktopMyGarageController extends SiteController
{
	var $content_type;
	var $languages;
	var $image_path;
	var $item_per_page = 6;
	var $questionaire_key = 'site_questionaire_id_for_delete_listing';
	
    public function __construct()
    {
        parent::__construct();
		
        $this->content_type = Config::get('site.content_type.car');

		$this->image_path = Config::get('site.uploaded_path').Config::get('site.car_image_folder_name');

		if(!Session::has('member.id')) {
			// dd(Session::get('member.id'));
			// return Redirect::to(App::getLocale().'/');
			// App::abort(404);
		}
		
    }
	public function getIndex() {
		if(!Session::has('member.id')) {
			return Redirect::to(App::getLocale().'/signin');
		}
		$id = Session::get('member.id');

		$upload_step = TextLanguage::where('language_id', $this->languages[$this->current_lang]['id'])
			        				->whereIn('module',array('upload_step'))
			        				->get()
			        				->toArray();
		
		// dd($upload_step);

		$this->data['upload_step'] = $upload_step;
        $this->data['carbase_part'] = CarbasePart::with(array('lang' => function($query) { 
               $query->where('language_id', $this->data['locale_id']);
           }))->get();
        Debugbar::info($this->data['carbase_part']->toArray());


        $wizard_questionaire_setting = Setting::where('key', $this->questionaire_key)->get();
        $questionaire = Questionaire::where('id', $wizard_questionaire_setting[0]->value)
            ->with(array('lang' => function($query){ 
                $query->where('language_id', $this->data['locale_id']);
            }))
            ->with(array('question' => function($query){ 
                $query->where('status', $this->status['active'])
                    ->with(array('lang' => function($query){ 
                    $query->where('language_id', $this->data['locale_id']);
                }));

                $query->with(array('answer' => function($query){ 
                    $query->where('status', $this->status['active'])
                        ->with(array('lang' => function($query){ 
                        $query->where('language_id', $this->data['locale_id']);
                    }));
                }));
            }))
            ->first();
		
		return View::make('site.desktop.member.mygarage')->with('questionaire',$questionaire);
	}
    public function myCars()
    {
    	
		
		if(!Session::has('member.id')) {
			return Redirect::to(App::getLocale().'/signin?url=my-cars');
		}
		$id = Session::get('member.id');
		// echo '<pre>';
		// dd($this->data);
        $order = 'desc';
        $posts = Post::select('posts.*','posts_languages.title as title', 'posts_languages.description as description')
                ->join('posts_languages', 'posts_languages.post_id', '=', 'posts.id')
                // ->leftJoin('car_owner_verified', 'car_owner_verified.post_id', '=', 'posts.id')
                ->where('status', '!=', $this->status['deleted'])
                ->groupby('posts_languages.post_id')
                ->with('post_by')
                ->with('make')
                ->with('model')
                ->with('submodel')
                ->with('year')
                ->with('car_verified')
                ->orderBy('posts.created_at', 'desc')
                ->paginate($this->item_per_page);
        $this->data['posts'] = $posts;

        Debugbar::info($this->data['posts']);
		
		$upload_step = TextLanguage::where('language_id', $this->languages[$this->current_lang]['id'])
			        				->whereIn('module',array('upload_step'))
			        				->get()
			        				->toArray();
		
		// dd($upload_step);

		$this->data['upload_step'] = $upload_step;
        $this->data['carbase_part'] = CarbasePart::with(array('lang' => function($query) { 
               $query->where('language_id', $this->data['locale_id']);
           }))->get();
        Debugbar::info($this->data['carbase_part']->toArray());


        $wizard_questionaire_setting = Setting::where('key', $this->questionaire_key)->get();
        $questionaire = Questionaire::where('id', $wizard_questionaire_setting[0]->value)
            ->with(array('lang' => function($query){ 
                $query->where('language_id', $this->data['locale_id']);
            }))
            ->with(array('question' => function($query){ 
                $query->where('status', $this->status['active'])
                    ->with(array('lang' => function($query){ 
                    $query->where('language_id', $this->data['locale_id']);
                }));

                $query->with(array('answer' => function($query){ 
                    $query->where('status', $this->status['active'])
                        ->with(array('lang' => function($query){ 
                        $query->where('language_id', $this->data['locale_id']);
                    }));
                }));
            }))
            ->first();
        // echo '<pre>';
        // dd($questionaire->toArray());


        // --- Seller Verified
        if( $result = DB::table('seller_verified')->where( 'member_id', '=', $id )->first() ){
                $results    = array(
                    'status'    => $result->verified,
                );
        }else{
                $results    = array(
                    'status'    => '99',
                );
        }
        // ---
        $this->data['seller_verified'] = $results;

        // --- Car Verified
		if( $car_result = DB::table('car_owner_verified')->where( 'member_id', '=', $id )->first() ){
        	// whereRaw('member_id = ? and post_id = ?', array($id, $post_id))
                $car_results    = array(
                    'status'    => $car_result->verified,
                );
        }else{
                $car_results    = array(
                    'status'    => '99',
                );
        }
        // ---
        $this->data['car_verified'] = $car_results;

		// dd($post);
		// print_r($posts->toArray());
        return View::make('site.desktop.member.mycars')
        		->with('questionaire', $questionaire);

    }

	public function getDestroy($id){

		// just update status to deleted not permanante delete

	 	$post = Post::find($id);
	 	$post->status = $this->status['deleted'];
	 	$post->update();

	 	// refresh index
	 	//Event::fire('cars.indexing');

		// $content = Content::find($id); //Content::where('id','=',$id)->get()
		// $thumbSize = Config::get('site.images_size');
		// $thumb_prefix = Config::get('site.thumbnail_prefix');
	 //        $destinationPath = public_path().'/uploaded';
		// for ($i = 0 ; $i< count($thumbSize);$i++){
		// 	$size = $thumbSize[$i];
		// 	$fname = $thumb_prefix.$size.'_'.$content->thumbnail;
		// 	$success = File::delete($destinationPath.'/'.$fname);
		// }
		
		// $this->getDeleteGallery($content->id);
		
		// $content->delete();
	
		return Redirect::to(App::getLocale().'/my-garage');	
	}

	public function getDeleteGallery($gid){

		$gal = Gallery::find($gid);

		if($gal!=null) {
			$gal->delete();
			$gallery_path = $this->image_path.'/'.$gid.'/gallery/';
			
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

    public function postDeleteListing(){

        $input = Input::all();
        $data = array();
        
        $status = false;
        $msg = '';

        $id = $input['delete-listing-id'];

    	$post = Post::find($id);
	 	$post->status = $this->status['deleted'];
	 	$post->delete_reason = $input['delete-reason'];
	 	$s = $post->update();

        if($s) {
            $msg = "Deleted";
            $status = true;
        }else {
            $msg = "Delete Failed";
        }

        return Response::json(array(
            'error' => false,
            'status' => $status,
            'msg' => $msg,
            'result' => ''),
            200
        );
    }
}
?>