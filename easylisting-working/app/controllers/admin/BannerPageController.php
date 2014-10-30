<?php
	class BannerPageController extends \AdminController {
		var $user;
		public function __construct()
		{
			parent::__construct();
			$this->user = Sentry::getUser();
	        if (Request::is('admin/banner-page/*'))
	        {
	            // code
	            Debugbar::info('call banner page');
	        }
			//Debugbar::info('call2');

			$this->data['title'] = 'Banner Pages';
			// $this->data['description'] = 'Banner Page management Control';
		}

	    public function getIndex()
	    {
			$list = BannerPage::paginate(15);
		    return View::make('admin.banner.page-index',['list'=>$list]);
	    }
	    public function postStore()
	    {
			$input = Input::all();
			
			$data = ['name'=>$input['name'],
				 	 'created_by'=>$this->user->id,
					 'updated_by'=>$this->user->id,
					 'created_at'=> new DateTime,
					 'updated_at'=> new DateTime];

			$c = BannerPage::create($data);

			return Redirect::to('admin/banner-page');
				
	    }
		public function getEdit($id){
			
			$data = BannerPage::find($id);
			
			return View::make('admin.banner.page-edit',['d'=>$data]);
		}
		public function postUpdate(){
			
			$input = Input::all();
			
			$b = BannerPage::find($input["id"]);
			
			
			$data = ['name'=>$input['name'],
					 'updated_by'=>$this->user->id,
					 'updated_at'=> new DateTime];

			$b->update($data);
			return Redirect::to('admin/banner-page');
			
		}
		public function getDestroy($id){
		
			$b = BannerPage::find($id); //Content::where('id','=',$id)->get();
			$b->delete();
	
			return Redirect::to('/admin/banner-page');	
		}
	}
?>