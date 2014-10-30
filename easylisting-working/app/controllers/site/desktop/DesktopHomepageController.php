<?php

class DesktopHomepageController extends HomepageController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
        $this->data['title'] = 'Homepage desktop version)';

        $p = Post::where('status',$this->status['active']);
        $this->data['car_avaliable'] = $p->count();

        //     echo '<pre>';
        // dd(Session::all());

        $today = new DateTime('today');
        // $promotes = Promote::where('content_type','promote')
        //             ->where('status', $this->status['active'])
        //             //->whereBetween('available_from', array($from, $to))
        //             ->where('available_from', '<=', $today)->where('available_to', '>=', $today)
        // 			->with(array(
        // 				'data' => function($query){ 
        // 					$query->where('language_id', $this->language['current_language_id']);
        // 				}))
        //             ->take(3)
        //             ->get();

       $latest_post = Post::where('status', $this->status['active'])
                    ->with(array(
                        'lang' => function($query){ 
                            $query->where('language_id', $this->data['locale_id']);
                        }))
                    ->take(4)
                    ->get();

        // echo '<pre>';
        // dd($latest_post->toArray());

        $post_image_url = URL::asset('uploaded/post/');
        $post_image_file_template = $post_image_url.'/%s/gallery/330x200-%s';

        $promotes = Promote::where('status', $this->status['active'])
        			->with(array(
        				'lang' => function($query){ 
        					$query->where('language_id', $this->data['locale_id']);
        				}))
                    ->take(3)
                    ->get();

        // echo '<pre>';
        // dd($promotes->toArray());

        $promote_image_url = URL::asset('uploaded/promote/');
        $promotes_image_file_template = $promote_image_url.'/%s/709x400-%s';

        return View::make('site.desktop.homepage.index')
	        ->with('promotes_image_file_template',$promotes_image_file_template)
	        ->with('promotes', $promotes)
            ->with('post_image_file_template',$post_image_file_template)
            ->with('posts', $latest_post);
    }

}