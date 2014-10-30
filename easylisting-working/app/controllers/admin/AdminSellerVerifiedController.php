<?php
class AdminSellerVerifiedController extends ContentController
{
	var $img_root_url;
	var $img_root_path = 'uploaded/seller_verified/';
	var $img_root_full_path;
	var $thumb_all_size = '80x50;110x73;160x100;320x200;226x142';
	var $thumb_size = '160x100';
    var $gallery_all_size = '80x50;110x73;160x100;330x200;512x342';
    var $gallery_thumb_size = '160x100';
	var $pattern_thumb = '%s-%s'; // '[thumbnail size]_[filename]'
	var $pattern_post_id = 'CN%s'; // 'CS[car_styleid]-[post_id]-[id]'
	var $item_per_page = 2;
    var $gallery_thumb_quality = 80;

	public function __construct()
	{
		parent::__construct();

		$this->img_root_full_path = public_path($this->img_root_path);
		$this->img_root_url = URL::asset($this->img_root_path).'/';
	}

    public function getIndex($params = null)
    {

        // return View::make('admin.seller_verified.waiting-index');
        return Redirect::to('admin/seller-verified/waiting-for-approve/');

    }

    public function getWaitingForApprove($params = null)
    {
        // dd(new \DateTime('tomorrow'));
        $this->data['title'] = 'Waiting for approval';
        $this->data['description'] = '';

        $allowed_sort = ['created_at'];
        $sort = in_array(Input::get('sort'), $allowed_sort) ? Input::get('sort') : 'seller_verified.created_at';
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        // $posts = Post::select('posts.*','posts_languages.title as title', 'posts_languages.description as description')
        //         ->join('posts_languages', 'posts_languages.post_id', '=', 'posts.id')
        //         ->where('status', '=', $this->status['waiting'])
        //         ->groupby('posts_languages.post_id')
        //         ->with('post_by');

        $posts = DB::table('members')
                    ->join('seller_verified', 'seller_verified.member_id', '=', 'members.id')
                    ->where( 'seller_verified.verified', '=', 0 )
                    ->orderBy('seller_verified.created_at', 'desc')
                    ->paginate($this->item_per_page);

        // $posts = SellerVerified::where( 'verified', '=', 0 );
        //             // ->join('members', 'seller_verified.member_id', '=', 'members.id')
        //             // ->where( 'verified', '=', 0 )
        //             // ->orderBy('created_at', 'desc');

        if($posts) {
            $this->data['posts'] = $posts;
            // Debugbar::info($this->data['posts'][0]->post_by);

            // $this->data['pagination'] = $pages->appends(array('q' => $q))->links();
            $this->data['pagination'] = $posts->links();
            $this->data['thumbnail_url'] = $this->img_root_url.'%s/'.sprintf($this->pattern_thumb, $this->thumb_size, '%s');
            $this->data['thumbnail_large'] = $this->img_root_url;
            $this->data['pattern_post_id'] = $this->pattern_post_id;
            // $this->data['seller_verified_id'] = $this->pattern_post_id;
        } else {
            $this->data['posts'] = false;
        }


        // echo '<pre>';
        // dd( $this->data['posts']->toArray());
        return View::make('admin.seller-verified.waiting-index');
    }

    public function getApprove($member_id)
    {
        // $post = Post::find($post_id);
        // $post->status = $this->status['active'];
        // $post->update();
        // Notification::success('Approved.');

        // // refresh index
        // Event::fire('post.indexing');

        $post = SellerVerified::find($member_id);
        $post->verified = 1;
        $post->update();
        if( $post ){
            Notification::success('Approved.');
        }

        // $update = DB::table('seller_verified')
        //     ->where('id', $member_id)
        //     ->update(array('verified' => 1, 'updated_at' => DB::raw('NOW()')));
        // if( $update ){
        //     Notification::success('Approved.');
        // }


        // refresh index
        Event::fire('seller-verified.indexing');
        // return Redirect::to('admin/seller-verified/waiting-for-approve/');
        return Redirect::back();
    }

    public function getDisapprove($member_id)
    {
        $post = SellerVerified::find($member_id);
        $post->verified = 99;
        $post->update();
        if( $post ){
            Notification::success('Disapproved.');
        }

        // $update = DB::table('seller_verified')
        //     ->where('id', $member_id)
        //     ->update(array('verified' => 99));
        // if( $update ){
        //     Notification::success('Disapproved.');
        // }

        // refresh index
        Event::fire('seller-verified.indexing');
        // return Redirect::to('admin/seller-verified/waiting-for-approve/');
        return Redirect::back();
    }

    public function getUndo($post_id)
    {
        $post = Post::find($post_id);
        $post->status = $this->status['waiting'];
        $post->update();
        Notification::success('Completed. status back to waiting for approve');

        // refresh index
        Event::fire('seller-verified.indexing');
        return Redirect::to('admin/seller-verified/waiting-for-approve/');
    }

    public function getApprovedList($params = null)
    {
        // dd(new \DateTime('tomorrow'));
        $this->data['title'] = 'Approved List';
        $this->data['description'] = '';

        // $posts = Post::select('posts.*','posts_languages.title as title', 'posts_languages.description as description')
        //         ->join('posts_languages', 'posts_languages.post_id', '=', 'posts.id')
        //         ->where('status', '=', $this->status['waiting'])
        //         ->groupby('posts_languages.post_id')
        //         ->with('post_by');

        $posts = DB::table('members')
                    ->join('seller_verified', 'seller_verified.member_id', '=', 'members.id')
                    ->where( 'seller_verified.verified', '=', 1 )
                    ->orderBy('seller_verified.created_at', 'desc')
                    ->paginate($this->item_per_page);
        // $posts = SellerVerified::select('seller_verified.*', 'members.*')
        //             ->join('members', 'seller_verified.member_id', '=', 'members.id')
        //             ->where( 'verified', '=', 0 )
        //             ->orderBy('created_at', 'desc');


        if($posts) {
            $this->data['posts'] = $posts;
            // Debugbar::info($this->data['posts'][0]->post_by);

            $this->data['pagination'] = $posts->links();
            $this->data['thumbnail_url'] = $this->img_root_url.'%s/'.sprintf($this->pattern_thumb, $this->thumb_size, '%s');
            $this->data['pattern_post_id'] = $this->pattern_post_id;
            // $this->data['seller_verified_id'] = $this->pattern_post_id;
        } else {
            $this->data['posts'] = false;
        }


        // echo '<pre>';
        // dd( $this->data['posts']->toArray());
        return View::make('admin.seller-verified.approved');
    }

    public function getDisapprovedList($params = null)
    {
        // dd(new \DateTime('tomorrow'));
        $this->data['title'] = 'Disapproved List';
        $this->data['description'] = '';

        $posts = DB::table('members')
                    ->join('seller_verified', 'seller_verified.member_id', '=', 'members.id')
                    ->where( 'seller_verified.verified', '=', 99 )
                    ->orderBy('seller_verified.created_at', 'desc')
                    ->paginate($this->item_per_page);
        // $posts = SellerVerified::select('seller_verified.*', 'members.*')
        //             ->join('members', 'seller_verified.member_id', '=', 'members.id')
        //             ->where( 'verified', '=', 0 )
        //             ->orderBy('created_at', 'desc');


        if($posts) {
            $this->data['posts'] = $posts;
            // Debugbar::info($this->data['posts'][0]->post_by);

            $this->data['pagination'] = $posts->links();
            $this->data['thumbnail_url'] = $this->img_root_url.'%s/'.sprintf($this->pattern_thumb, $this->thumb_size, '%s');
            $this->data['pattern_post_id'] = $this->pattern_post_id;
            // $this->data['seller_verified_id'] = $this->pattern_post_id;
        } else {
            $this->data['posts'] = false;
        }


        // echo '<pre>';
        // dd( $this->data['posts']->toArray());
        return View::make('admin.seller-verified.disapproved');
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

  
}	
?>