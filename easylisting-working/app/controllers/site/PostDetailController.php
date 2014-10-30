<?php

class PostDetailController extends SiteController 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDetail($post_id)
    {
        $car_favorite_added = false;
		$gallery = array();
        if (Session::has('member')) {
            $member = Session::get('member');
            $member_id = $member['id'];
            $bookmarks = Bookmark::where('member_id', $member_id)
                        ->where('post_id', $post_id)
                        ->with('post')
                        ->get()->toArray();
			// d// d($bookmarks);
            if($bookmarks) $car_favorite_added = true;
        }
        $post = Post::where('id',$post_id)
                    ->with(array('lang'=> function($q){
                    	$q->where('language_id', $this->data['locale_id']);
                    }))
					->with('gallery')
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
                    ->first();
        if (!$post) {
            App::abort(404);
        }

        $post = $post->toArray();

        // echo '<pre>';
        // dd($post);

        if ($post['lang'] && is_array($post['lang']) && !empty($post['lang'])) {
            $title = $post['lang'][0]['title'];
            $description = $post['lang'][0]['description'];
            $detail = $post['lang'][0]['detail'];
        }

        if ($post['gallery'] && is_array($post['gallery']) && !empty($post['gallery'])) {
            $gallery = $post['gallery'];
        }

        if ($post['post_by'] && is_array($post['post_by']) && !empty($post['post_by'])) {
            $post_by = array(
                    'member_id' => $post['post_by']['id'],
                    'username' => ($post['post_by']['username']) ? $post['post_by']['username'] : '',
                    'avatar' => ($post['post_by']['avatar']) ? $post['post_by']['avatar'] : '',
                    'email' => ($post['post_by']['email']) ? $post['post_by']['email'] : '',
                    'first_name' => ($post['post_by']['first_name']) ? $post['post_by']['first_name'] : '',
                    'last_name' => ($post['post_by']['last_name']) ? $post['post_by']['last_name'] : '',
                    'phone' => ($post['post_by']['phone']) ? $post['post_by']['phone'] : '',
					'province_id' => ($post['post_by']['province_id']) ? $post['post_by']['province_id'] : 0
                );
        }
        // echo '<pre>';
        // dd($province);
		//
		// $detail['province'] = $province['name'];
        // get parts
        if($post['parts_ids'] && $post['parts_ids'] != '') {
            $ids = explode(',', $post['parts_ids']);
            $parts = CarbasePart::whereIn('id', $ids)
                                ->with(array('lang' => function($q) { 
                                    $q->where('language_id', $this->data['locale_id']);
                                }))
                                ->get()
                                ->toArray();
            foreach ($parts as $key => $value) {
                $res[] = $value['lang'][0]['title'];
            }
            $post['parts_ids'] = $res;
        }
        
        $views = '0';
        $address = ($post['address']) ? $post['address'] : '';
        $mileage = ($post['mileage']) ? $post['mileage'] : '';
        $price = ($post['price']) ? $post['price'] : '';
        $parts = ($post['parts_ids']) ? $post['parts_ids'] : array();       
        $year = ($post['year']) ? $post['year']['year'] : '';
        $engine = ($post['engine']) ? $post['engine']['size'] : '';
        $fuel = ($post['fuel']) ? $post['fuel']['type'] : '';
        $submodel = ($post['submodel']) ? $post['submodel']['sub_model'] : '';
        $model = ($post['model']) ? $post['model']['model'] : '';
        $make = ($post['make']) ? $post['make']['make'] : '';
        $color = ($post['color']) ? $post['color']['color'] : '';
        $gear = ($post['gear']) ? $post['gear']['gear'] : '';
        $title = $make . ' ' . $model . ' ' . $submodel . ' ' . $year;

        return compact('post_id', 'title','description', 'detail', 'car_favorite_added', 'gallery', 'parts', 'address',
            'year', 'engine', 'fuel', 'submodel', 'model', 'make', 'color', 'gear', 'price', 'mileage', 'post_by', 'views'
        );
    }
}