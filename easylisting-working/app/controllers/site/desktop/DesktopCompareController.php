<?php

class DesktopCompareController extends SiteController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex($str = '')
    {
		// Session::put('car_compare',$str);
    	$this->data['page_title'] = 'Compare';
    	$this->data['page_body'] = '';
		$ids = explode(',',$str);
		
		$posts = Post::whereIn('id', $ids)
					//->with('gallery')
					->with('color')
					->with('engine')
					->with('fuel')
					->with('year')
                    ->with('gear')
                    ->with('amphur')
                    ->with('district')
                    ->with('province')
					->with('make')
					->with('model')
					->with('submodel')
                    ->with('post_by')
                    ->with('modify_by')
					->get();
		if ($posts) {
			$posts = $posts->toArray();

	        $parts = CarbasePart::with(array('lang' => function($query) { 
	               $query->where('language_id', $this->data['locale_id']);
	           }))->get();

	        $p = array();
	        foreach ($parts as $key => $value) {
	        	$p[$value->id] = $value->lang[0]->title;
	        }

	        foreach ($posts as $key => $value) {
				$parts_ids = (isset($value['parts_ids'])) ? explode(',', $value['parts_ids']) : '';

				foreach ($parts_ids as $keyp => $valuep) {
					if (array_key_exists($valuep, $p)) {
						$posts[$key]['parts'][] = $p[$valuep];
					}
				}
	        }

	        // echo '<pre>';
	        // dd($posts[0]['parts']);


		} else {
			App::abort(404);
		}

        return View::make('site.desktop.compare.index')
        		->with('posts', $posts);
    }

}