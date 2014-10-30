<?php
	class BannerPositionController extends \AdminController {
		var $user;
		public function __construct()
		{
			parent::__construct();
			$this->user = Sentry::getUser();
	        if (Request::is('admin/banner-position/*'))
	        {
	            // code
	            Debugbar::info('banner position');
	        }
			//Debugbar::info('call2');

			$this->data['title'] = 'Banner Positions';
		}

	    public function getIndex()
	    {
			$list = BannerPosition::paginate(15);
		    return View::make('admin.banner.position-index',['list'=>$list]);
	    }
	    public function postStore()
	    {
			$input = Input::all();
			
			$data = ['name'=>$input['name'],
					 'banner_size'=>$input['size'],
				 	 'created_by'=>$this->user->id,
					 'updated_by'=>$this->user->id,
					 'created_at'=> new DateTime,
					 'updated_at'=> new DateTime];

			$c = BannerPosition::create($data);

			return Redirect::to('admin/banner-position');
				
	    }
		public function getEdit($id){
			
			$data = BannerPosition::find($id);
			
			return View::make('admin.banner.position-edit',['d'=>$data]);
		}
		public function postUpdate(){
			
			$input = Input::all();
			
			$b = BannerPosition::find($input["id"]);
			
			$data = ['name'=>$input['name'],
					 'banner_size'=>$input['size'],
					 'updated_by'=>$this->user->id,
					 'updated_at'=> new DateTime];

			$b->update($data);
			return Redirect::to('admin/banner-position');
			
		}
		public function getDestroy($id){
		
			$b = BannerPosition::find($id); //Content::where('id','=',$id)->get();
			$b->delete();
	
			return Redirect::to('/admin/banner-position');	
		}
	}
?>