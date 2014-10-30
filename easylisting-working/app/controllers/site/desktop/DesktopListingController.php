<?php

class DesktopListingController extends ListingController {

    // $page = 0;
    var $item_per_page = 4;
    var $questionaire_key = 'site_questionaire_id_for_listing_report';

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
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



    	// $this->data['title'] = 'Post desktop version)';
        // if($params) 
        // {
        //     $params = str_replace('/', '\\', $params);
        //     preg_match_all("/([^\\\\]+)\\\\([^\\\\]+)/", $params, $pairs);
        //     $params = array_combine($pairs[1], $pairs[2]);
        // }

        $p = Post::where('status',$this->status['active']);
        $this->data['car_avaliable'] = $p->count();


        $all_items = 0;
    	$items = array();
    	$pagination = array();

		$result_ids = array();


        // default value
        $distance_in_km = 10000;// default at 1km
        $lat = 13.6851977;
        $lon = 100.6149348;
        $sortby = '';
        $order = 'asc';
        $q = '';
        $min_price = 0;
        $max_price = 100000000;
        $engine_size = '';
        $make = '';
        $model = '';
        $door = '';

        $distance_in_km = $distance_in_km = Input::get('distance_in_km', '') == ''? $distance_in_km : Input::get('distance_in_km');   
        $lat = (float)$lat = Input::get('lat', '') == ''? $lat : Input::get('lat');
        $lon = (float)$lon = Input::get('lon', '') == ''? $lon : Input::get('lon');
        $sortby = Input::get('sortby', '') == ''? $sortby : Input::get('sortby');
        $order = Input::get('order', '') == ''? $order : Input::get('order');
        $q = Input::get('q', '') == ''? $q : Input::get('q');
        $min_price = (int)$min_price = Input::get('min_price', '') == ''? $min_price : Input::get('min_price');
        $max_price = (int)$max_price = Input::get('max_price', '') == ''? $max_price : Input::get('max_price');
        $engine_size = Input::get('engine_size', '') == ''? $engine_size : Input::get('engine_size');
        $make = Input::get('make', '') == ''? $make : Input::get('make');
        $model = Input::get('model', '') == ''? $model : Input::get('model');
        $door = Input::get('door', '') == ''? $door : Input::get('door');

        $province = Input::get('province', '') == ''? '' : Input::get('province');
        $amphur = Input::get('amphur', '') == ''? '' : Input::get('amphur');
        $district = Input::get('district', '') == ''? '' : Input::get('district');
		
        $searchParams = null;
        $searchParams['index'] = 'posts';
        $searchParams['type']  = 'post';

        $p = $a = $d = '';
        if ($province != '') {
            $p = Province::where('id', $province)->first()->toArray();
            $p = $p['name'];
        }

        if ($amphur != '') {
            $a = Amphur::where('id', $amphur)->first()->toArray();
            $a = $a['name'];
        }
        if ($district != '') {
            $d = District::where('id', $district)->first()->toArray();
            $d = $d['name'];
        }
        if ($province != '' || $amphur != '' || $district != ''){ 
            $address = $p.' '.$a.' '.$d;
            $geo = $this->geoFromAddress($address);
            $lat = $geo->getLatitude();
            $lon = $geo->getLongitude();
//            $distance_in_km = 50;
        }

        // Debugbar::info(Input::all());

        // echo '<pre>';
        // dd(Input::all());
        // die();

        // Distance
        $searchParams['body']['fields'] = array('_source');
        $searchParams['body']['script_fields']['distance']['script'] = 'distance-in-km'; // add this function in Elasticsearch script foder on server
        $searchParams['body']['script_fields']['distance']['params'] = array(
            'location_field' => 'post.locations',
            'lat' => $lat,
            'lon' => $lon
        );

        // search by location
        if ($distance_in_km != '' && $distance_in_km != 0 && $distance_in_km != 'all') {
            $searchParams['body']['query']['filtered']['filter']['geo_distance'] = array(
                'distance' => (int)$distance_in_km.'km',
                'post.locations' => array("lat"=>$lat, "lon"=>$lon)
            );
        }

        // sorting by distance
        if ($sortby == 'distance') {
            $searchParams['body']['sort']['_geo_distance'] = array(
                'locations' => array("lat"=>$lat, "lon"=>$lon),
                'order' => $order,
                'unit' => 'km'
            );            
        } else {
            if ($sortby != '')
                $searchParams['body']['sort'][$sortby] = array('order'=>$order); 
            else
                $searchParams['body']['sort']['id'] = array('order'=>'asc'); 
        }


        // Smart search
        if ($q != ''){
            // $searchParams['body']['query']['filtered']['query']['bool']['should'][]['match']['post.lang.th.title'] = $q;
            // $searchParams['body']['query']['filtered']['query']['bool']['should'][]['match']['post.lang.en.title'] = $q;
             $searchParams['body']['query']['filtered']['query']['bool']['must']['fuzzy_like_this']['fields'] = array(
                "post.make.make",
                "post.model.model",
                "post.submodel.sub_model",
                "post.year.year",
                "post.lang.en.title",
                "post.lang.th.title",
                "post.gear.gear",
                "post.engine.size",
                "post.color.color",
                "post.tags"
             );
             $searchParams['body']['query']['filtered']['query']['bool']['must']['fuzzy_like_this']['like_text'] = $q;
        }

        // Make
        if($make != '')
        $searchParams['body']['query']['filtered']['query']['bool']['must'][]['query_string'] = array(
            'default_field' => 'post.make.id',
            'query' => $make
        );

        // Model
        if($model != '')
        $searchParams['body']['query']['filtered']['query']['bool']['must'][]['query_string'] = array(
            'default_field' => 'post.model.id',
            'query' => $model
        );

        // $province
        // if($province != '')
        // $searchParams['body']['query']['filtered']['query']['bool']['must'][]['query_string'] = array(
        //     'default_field' => 'post.model.id',
        //     'query' => $model
        // );

        // Door
        // if($door != '')
        // $searchParams['body']['query']['filtered']['query']['bool']['must'][]['query_string'] = array(
        //     'default_field' => 'post.information.numberOfDoors',
        //     'query' => $door
        // );

        // Engine size
        if($engine_size != '')
        $searchParams['body']['query']['filtered']['query']['bool']['must'][] = array(
            'term' => array('post.engine.size' => $engine_size)
        );

        // Price
        $searchParams['body']['query']['filtered']['query']['bool']['should'][]['range'] = array(
            'post.price' => array(
                'from' => $min_price,
                'to' => $max_price
            )
        );

        // Pagination
        $page = Input::has('page')? (int)Input::get('page') - 1 : 0;
        // $page = 0;

        $searchParams['body']['from'] = $page * $this->item_per_page;
        $searchParams['body']['size'] = $this->item_per_page;

        // echo '<pre>';
        // dd($searchParams);

        // Saerch...
        $result = Es::search($searchParams);

        $all_items = $result['hits']['total'];

        if ($all_items > 0) {
	        $items = $result['hits']['hits'];

	        // echo '<pre>';
	        // echo 'found : '.$all_items;
	        // echo '<hr>';
	        // foreach ($items as $key => $value) {
	        //     var_dump($value['fields']['distance'][0]);
	        //     // var_dump($value['_source']['lang']['en']['title'].'|'.$value['_source']['lang']['th']['title'],
	        //     //     $value['_source']['information']['make'],
	        //     //     $value['_source']['information']['model'],
	        //     //     $value['fields']['distance'][0],
	        //     //     $value['_source']['price'],
	        //     //     $value['_source']['information']['engineSize']);
	        //     // echo '<br/>';
	        // }
	        // echo '<hr>';
         //    echo '<pre>';
	        // dd($searchParams);

	        // pagination
	        $paginator = Paginator::make($items, $all_items, $this->item_per_page);
	        $inputs = Input::all();
	        unset($inputs['page']);
	        $pagination = $paginator->appends($inputs);


			// for save search

			$count = (count($items) >= 10) ? 10 : count($items);
			for ($i=0;$i<$count;$i++){
				$result_ids[] = $items[$i]['_source']['id'];

                // $seller = Post::select('seller_verified.*')
                //         ->join('members', 'members.id', '=', 'posts.created_by')
                //         ->join('seller_verified', 'seller_verified.member_id', '=', 'members.id')
                //         ->where('posts.id', '=', $items[$i]['_source']['id'])
                //         ->first();

                // $items[$i]['_source']['seller_verified'] = $seller['verified'];

			}

            // Get Seller Verified
            // $seller = SellerVerified::select('seller_verified.*')
            //             ->join('members', 'members.id', '=', 'seller_verified.member_id')
            //             ->join('posts', 'posts.created_by', '=', 'members.id')
            //             ->whereIn('posts.id', $result_ids)
            //             ->get();
            // $i = 0;
            // foreach ($seller as $value) {
            //     $items[$i]['_source']['seller_verified'] = $value['verified'];
            //     $i++;
            // }


	        // echo $pagination;
	        // dd($searchParams);
	        // dd($pagination);
	        // echo '<pre>';
	        // dd(implode(",",$result_ids));

        }

// $_seller = $seller->toArray();
// echo "<pre>";
// print_r($items);
// echo "</pre>";

		return View::make('site.desktop.postlisting.index')
                ->with('questionaire', $questionaire)
                ->with('lat', $lat)
                ->with('lon', $lon)
				->with('inputs', Input::all())
                ->with('total', $all_items)
                ->with('pager', $pagination)
                ->with('posts', $items)
				->with('result_ids',implode(",",$result_ids));
    }
	
	public function saveSearch(){
		// Debugbar::info('save',Input::all());
		$input = Input::all();
		$id = Session::get('member.id');
		$data = array();
		
		$status = false;
		$msg = '';
		
		$data['member_id'] = $id;
		$data['query'] = $input['q'];
		$data['car_type'] = (Input::has('body')) ? $input['body'] : '';
		$data['car_transmission'] = (Input::has('gear')) ? $input['gear'] : '';
		$data['car_fuel'] = (Input::has('fuel')) ? $input['fuel'] : '';
		$data['car_door'] = (Input::has('door')) ? $input['door'] : '';
		$data['car_engine'] = (Input::has('engine_size')) ? $input['engine_size'] : '';
		$data['mileage'] = (Input::has('mileage')) ? $input['mileage'] : '';
		$data['car_colors'] = (Input::has('color')) ? $input['color'] :'';
		$data['distance'] = (Input::has('distance_in_km')) ? $input['distance_in_km'] : '';
		$data['max_price'] = (Input::has('max_price')) ? $input['max_price'] : '';
		$data['min_price'] = (Input::has('min_price')) ? $input['min_price'] : '';
		$data['car_make'] = (Input::has('make')) ? $input['make'] : '';
		$data['car_model'] = (Input::has('model')) ? $input['model'] : '';
		$data['car_year'] = (Input::has('year')) ? $input['year'] : '';
		$data['result_count'] = $input['result_count'];
		$data['result_ids'] = $input['result_ids'];
		
		
		// foreach($input as $k=>$v) {
		// 	$data[$k] = $v;
		// }
		$data['created_at'] = new DateTime;
		$data['updated_at'] = new DateTime;
		$s = SaveSearch::create($data);
		if($s) {
			$msg = "Save Success";
			$status = true;
		}else {
			$msg = "Save Failed";
		}
		return Response::json(array(
            'error' => false,
            'status' => $status,
            'msg' => $msg,
            'result' => ''),
            200
        );
		// return json_encode($arr);
	}

    public function saveReport(){

        $input = Input::all();
        $id = Session::get('member.id');
        $data = array();
        
        $status = false;
        $msg = '';
        
        $data['member_id'] = $id;
        $data['post_id'] = $input['post-id'];  
        $data['answer_id'] = $input['report-reason'];  
        $data['email'] = $input['report-email'];  

        $s = PostReportAbuses::create($data);
        if($s) {
            $msg = "Save Success";
            $status = true;
        }else {
            $msg = "Save Failed";
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