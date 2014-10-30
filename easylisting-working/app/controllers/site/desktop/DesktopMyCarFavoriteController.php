<?php

class DesktopMyCarFavoriteController extends SiteController
{
	var $content_type;
	var $languages;
	var $image_path;
	var $item_per_page = 6;
	
    public function __construct()
    {
        parent::__construct();
		
        $this->content_type = Config::get('site.content_type.car');

		$this->image_path = Config::get('site.uploaded_path').Config::get('site.car_image_folder_name');

		if(!Session::has('member.id')) {
			// dd(Session::get('member.id'));
			// return Redirect::to(App::getLocale().'/');
			App::abort(404);
		}
		
    }
    public function getIndex()
    {
    	$member_id = Session::get('member.id');

        $order = 'desc';
        $posts = Post::select('posts.*','posts_languages.title as title', 'posts_languages.description as description')
                ->join('posts_languages', 'posts_languages.post_id', '=', 'posts.id')
                ->join('members_bookmarks', 'members_bookmarks.post_id', '=', 'posts.id')
                ->join('members', 'members.id', '=', 'members_bookmarks.member_id')
                ->where('members.id', $member_id)
                ->where('posts.status', '!=', $this->status['deleted'])
                ->groupby('posts_languages.post_id')
                ->with('post_by')
                ->orderBy('posts.created_at', 'desc')
                ->paginate($this->item_per_page);
        $this->data['posts'] = $posts;

        // Debugbar::info($this->data['posts']);

        return View::make('site.desktop.member.myfavorite');
    }

	public function getDestroy($id)
	{
		$member_id = Session::get('member.id');


		$bookmark = Bookmark::where('member_id',$member_id)->where('post_id',$id);
		$bookmark->delete();

		$msg = "Delete Completed";
		return Response::json(array(
            'error' => false,
            'msg' => $msg),
            200
        );
		// return Redirect::to(App::getLocale().'/my-bookmark');
	}
}
?>