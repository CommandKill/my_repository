<?php

class SaveSearchJobController extends AdminController
{
    var $item_per_page = 1;
    var $params;

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Save search';
	}

    public function getIndex()
    {
        // Get save search for all member
        MemberSaveSearch::with('search_by')->chunk(200, function($m)
        {
            foreach ($m as $key => $value) {

                if (is_object($value)) {
                    $this->params = $value->toArray();
                    $result = $this->search();
                    $items = $result['hits']['hits'];

                    $all_items = $result['hits']['total'];

                    if ($all_items > 0) {
                        $items = $result['hits']['hits'];

                        // pagination
                        $paginator = Paginator::make($items, $all_items, $this->item_per_page);
                        $inputs = Input::all();
                        unset($inputs['page']);
                        $pagination = $paginator->appends($inputs);

                        // for save search
                        $count = (count($items) >= 10) ? 10 : count($items);
                        for ($i=0;$i<$count;$i++){
                            $result_ids[] = $items[$i]['_source']['id'];
                        }

                        //dd(implode(",",$result_ids));
//                        echo '<pre>';
//                        var_dump($items);
//                        echo '<br/>';

                        // check result diff with db

                        // update latest search to db

                        // bind data to template

                        // send email to member
                        $member_id = $value->member_id;
                        $email = $value->search_by['email'];

                        // test with email id 9
                        $email_template = EmailTemplate::where('id', 9)->with('template')->first();
                        $template = $email_template->template[0]['template'];
                        $template = $this->phrserBBcode($template, $items);

                        $subject = $email_template->template[0]['subject'];

                        Mail::send('email.blank', array('email_template'=>$template), function($message) use ($subject, $email)
                        {
                            $message->to($email)
                                ->subject($subject)
                                ->from(getenv('ADMIN_EMAIL'), getenv('ADMIN_NAME'));
                        });

                        if (Mail::failures()) {
                            Log::info('fail to '. $email);
                        } else {
                            Log::info('sent to '. $email);
                        }
                        flush();
                    }
                }
            }
            return true;
        });
    }

    function phrserPostItem($data='', $item=array())
    {
        $res = '';
        foreach ($item as $value) {

            $id = $value['_source']['id'];
            $title = $value['_source']['lang']['en']['title'];
            $price = $value['_source']['price'];
            $thumbnail = $value['_source']['thumbnail'];

            $thumbnail = asset('uploaded/post/'.$id.'/gallery/330x200-'.$thumbnail);

            $year = $value['_source']['year']['year'];
            $make = $value['_source']['make']['make'];
            $model = $value['_source']['model']['model'];
            $submodel = $value['_source']['submodel']['sub_model'];
            $province = $value['_source']['province']['name'];
            $amphur =  $value['_source']['amphur']['name'];
            $district = $value['_source']['district']['name'];

            // bind to template
            $p = '';
            BBCode::setParser('title', '/\[title\]/', "$year $make $model");
            BBCode::setParser('description', '/\[description\]/', $submodel);
            BBCode::setParser('price', '/\[price\]/', "$price");
            BBCode::setParser('thumbnail', '/\[thumbnail\]/', $thumbnail);

            //$templates = str_replace('/js/plugins/elfinder/php/../../../..', 'http://128.199.140.65', $email_template->template[0]['template']);

            $res .= BBCode::parse($data);
        }
        return $res;
    }

    public function phrserBBcode($data, $item=array())
    {
        $data = str_replace("\n",'', $data);
        BBCode::setParser('resultcar', '/\[resultcar\](.*)\[\/resultcar\]/', $this->phrserPostItem('$1', $item));
        $bbcode = BBCode::parse($data);
        return $bbcode;
    }

    public function getParam($key, $default='')
    {
        return isset($this->params[$key])? $this->params[$key] : $default;
    }

    public function search($params=array())
    {
        $all_items = 0;
        $items = array();
        $pagination = array();

        $result_ids = array();

        // default value
        $distance_in_km = 10000;// default at 1km
        $lat = 0;
        $lon = 0;
        $sortby = '';
        $order = 'asc';
        $q = '';
        $min_price = 0;
        $max_price = 100000000;
        $engine_size = '';
        $make = '';
        $model = '';
        $door = '';

        //$distance_in_km = (int)$distance_in_km = $this->getParam('distance', '') == ''? distance : $this->getParam('distance');
//        $lat = (float)$lat = $this->getParam('lat', '') == ''? $lat : $this->getParam('lat');
//        $lon = (float)$lon = $this->getParam('lon', '') == ''? $lon : $this->getParam('lon');
        $sortby = $this->getParam('sortby', '') == ''? $sortby : $this->getParam('sortby');
        $order = $this->getParam('order', '') == ''? $order : $this->getParam('order');
        $q = $this->getParam('q', '') == ''? $q : $this->getParam('q');
        $min_price = (int)$min_price = $this->getParam('min_price', '') == ''? $min_price : $this->getParam('min_price');
        $max_price = (int)$max_price = $this->getParam('max_price', '') == ''? $max_price : $this->getParam('max_price');
        $engine_size = $this->getParam('car_engine', '') == ''? $engine_size : $this->getParam('car_engine');
        $make = $this->getParam('car_make', '') == ''? $make : $this->getParam('car_make');
        $model = $this->getParam('car_model', '') == ''? $model : $this->getParam('car_model');
        $door = $this->getParam('car_door', '') == ''? $door : $this->getParam('car_door');

        $province = $this->getParam('province', '') == ''? '' : $this->getParam('province');
        $amphur = $this->getParam('amphur', '') == ''? '' : $this->getParam('amphur');
        $district = $this->getParam('district', '') == ''? '' : $this->getParam('district');

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
        if ($province != '' || $amphur != '' || $district != '') {
            $address = $p . ' ' . $a . ' ' . $d;
            $geo = $this->geoFromAddress($address);
            $lat = $geo->getLatitude();
            $lon = $geo->getLongitude();
//            $distance_in_km = 50;
        }

        if ($lat == 0 || $lon == 0) {

        } else {
            // Distance
            $searchParams['body']['fields'] = array('_source');
            $searchParams['body']['script_fields']['distance']['script'] = 'distance-in-km'; // add this function in Elasticsearch script foder on server
            $searchParams['body']['script_fields']['distance']['params'] = array(
                'location_field' => 'post.locations',
                'lat' => $lat,
                'lon' => $lon
            );

            // search by location
            $searchParams['body']['query']['filtered']['filter']['geo_distance'] = array(
                'distance' => $distance_in_km.'km',
                'post.locations' => array("lat"=>$lat, "lon"=>$lon)
            );

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
                "post.engine.size"
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

        $searchParams['body']['from'] = $page * $this->item_per_page;
        $searchParams['body']['size'] = $this->item_per_page;

        // Saerch...
        $result = Es::search($searchParams);

        return $result;

    }
}	
?>