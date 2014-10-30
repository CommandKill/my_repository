<?php
	class BannerFileController extends \AdminController {
		var $user;
		public function __construct()
		{
			parent::__construct();
			$this->user = Sentry::getUser();
	        if (Request::is('admin/banner-file/*'))
	        {
	            // code
	            Debugbar::info('banner files');
	        }
			//Debugbar::info('call2');

			$this->data['title'] = 'Banner Files';
			// $this->data['description'] = 'File management Control';
		}

	    public function getIndex()
	    {
			$list = BannerFile::paginate(15);
		    return View::make('admin.banner.file-index',['list'=>$list]);
	    }
	    public function postStore()
	    {
			$file = Input::file('files');
			
			if (Input::hasFile('files')) {
				$type = ($file->getExtension()=='swf') ? 'flash' : 'image' ;
		        $destinationPath = public_path().'/uploaded/banner';
				$file->move($destinationPath,$file->getClientOriginalName());
				
				list($width, $height) = getimagesize($destinationPath.'/'.$file->getClientOriginalName());
				// $file->getSize()
				$data = ['name'=>$file->getClientOriginalName(),
						 'size'=> $width.'x'.$height,
						 'content_type' => $type,
					 	 'created_by'=>$this->user->id,
						 'updated_by'=>$this->user->id,
						 'created_at'=> new DateTime,
						 'updated_at'=> new DateTime];
			
			
				// dd($data);
					 
				$c = BannerFile::create($data);

			}
			
			return Redirect::to('admin/banner-file/');
				
	    }
		public function getEdit($id){
			
			$data = BannerFile::find($id);
			
			return View::make('admin.banner.file-edit',['d'=>$data]);
		}
		public function postUpdate(){
			
			$input = Input::all();
			
			$b = BannerFile::find($input['id']);
			
			$file = Input::file('files');

			if (Input::hasFile('files')) {
				$type = ($file->getExtension()=='swf') ? 'flash' : 'image' ;
				
		        $destinationPath = public_path().'/uploaded/banner';
				
				$success = File::delete($destinationPath.'/'.$b->image);
				
				$file->move($destinationPath,$file->getClientOriginalName());
				
				list($width, $height) = getimagesize($destinationPath.'/'.$file->getClientOriginalName());
				// $file->getSize()
				$data = ['name'=>$file->getClientOriginalName(),
						 'size'=> $width.'x'.$height,
						 'content_type' => $type,
						 'updated_by'=>$this->user->id,
						 'updated_at'=> new DateTime];
						 
						 $b->update($data);

			}
			
			
			return Redirect::to('admin/banner-file/');
			
		}
		public function getDestroy($id){
		
			$b = BannerFile::find($id); //Content::where('id','=',$id)->get();
			
		    $destinationPath = public_path().'/uploaded/banner';
			
			$success = File::delete($destinationPath.'/'.$b->image);


			$b->delete();
	
			return Redirect::to('/admin/banner-file');	
		}
	}
?>