<?php
	class BannerController extends \AdminController {
		var $user;
		public function __construct()
		{
			parent::__construct();
			$this->user = Sentry::getUser();
	        if (Request::is('admin/banner/*'))
	        {
	            // code
	            Debugbar::info('call banner');
	        }
			//Debugbar::info('call2');

			$this->data['title'] = 'Banners';
			$this->data['description'] = '';
		}

	    public function getIndex()
	    {
			$list = Banner::paginate(15);
			
			// dd($list[0]->page()->get()[1]->name);
			
			$page = BannerPage::all();
			$pos = BannerPosition::all();
			$file = BannerFile::all();
		    return View::make('admin.banner.index',['list'=>$list,'page'=>$page,'pos'=>$pos,'file'=>$file]);
			
	    }
	    public function postStore()
	    {
			$input = Input::all();
			
			$data = ['page_id'=>$input['page'],
					 'position_id'=>$input['position'],
					 'file_id' => $input['file'],
					 'link' => $input['link'],
					 'status'=>0,
					 'view' => 0,
					 'click' => 0,
				 	 'created_by'=>$this->user->id,
					 'updated_by'=>$this->user->id,
					 'created_at'=> new DateTime,
					 'updated_at'=> new DateTime];

			$c = Banner::create($data);
			
			return Redirect::to('admin/banner');
				
	    }
		public function getEdit($id){
			
			$data = Banner::find($id);
			
			
			$page = BannerPage::all();
			$pos = BannerPosition::all();
			$file = BannerFile::all();
			
			return View::make('admin.banner.edit',['d'=>$data,'page'=>$page,'pos'=>$pos,'file'=>$file]);
		}
		public function postUpdate(){
		
			$input = Input::all();
			
			$b = Banner::find($input['id']);
			
			$status = isset($input['status']) ? 1 : 0;
			
			$data = ['page_id'=>$input['page'],
					 'position_id'=>$input['position'],
					 'file_id' => $input['file'],
					 'link' => $input['link'],
					 'available_from' => $input['available_from'],
					 'available_to' => $input['available_to'],
					 'status'=>$status,
					 'updated_by'=>$this->user->id,
					 'updated_at'=> new DateTime];
			
			$b->update($data);
			return Redirect::to('admin/banner/');
			
		}
		public function getDestroy($id){
		
			$b = Banner::find($id); //Content::where('id','=',$id)->get();
			$b->delete();
	
			return Redirect::to('/admin/banner');	
		}
	}
	
?>