<?php

class ListingController extends SiteController 
{
    public function __construct()
    {
        parent::__construct();
        // $this->data['text_page'] = $this->get_language_by_module('search_form');
        $this->data['text_page'] = $this->get_language_in_module(array('search_form', 'report_listing'));

    }

    public function getDataFromElasticsearch() 
    {
        // // default value
        // $distance_in_km = 10;// default at 1km
        // $lat = 13.6851977;
        // $lon = 100.6149348;
        // $sortby = '';
        // $order = 'asc';
        // $q = '';
        // $min_price = 0;
        // $max_price = 100000000;
        // $engine_size = '';
        // $make = '';
        // $model = '';
        // $door = '';

        // $distance_in_km = (int)$distance_in_km = Input::get('distance_in_km', '') == ''? $distance_in_km : Input::get('distance_in_km');   
        // $lat = (float)$lat = Input::get('lat', '') == ''? $lat : Input::get('lat');
        // $lon = (float)$lon = Input::get('lon', '') == ''? $lon : Input::get('lon');
        // $sortby = Input::get('sortby', '') == ''? $sortby : Input::get('sortby');
        // $order = Input::get('order', '') == ''? $order : Input::get('order');
        // $q = Input::get('q', '') == ''? $q : Input::get('q');
        // $min_price = (int)$min_price = Input::get('min_price', '') == ''? $min_price : Input::get('min_price');
        // $max_price = (int)$max_price = Input::get('max_price', '') == ''? $max_price : Input::get('max_price');
        // $engine_size = Input::get('engine_size', '') == ''? $engine_size : Input::get('engine_size');
        // $make = Input::get('make', '') == ''? $make : Input::get('make');
        // $model = Input::get('model', '') == ''? $model : Input::get('model');
        // $door = Input::get('door', '') == ''? $door : Input::get('door');
		
        // $searchParams = null;
        // $searchParams['index'] = 'car';
        // $searchParams['type']  = 'post';

        // // Distance
        // $searchParams['body']['fields'] = array('_source');
        // $searchParams['body']['script_fields']['distance']['script'] = 'distance-in-km'; // add this function in Elasticsearch script foder on server
        // $searchParams['body']['script_fields']['distance']['params'] = array(
        //     'location_field' => 'post.locations',
        //     'lat' => $lat,
        //     'lon' => $lon
        // );

        // // search by location
        // $searchParams['body']['query']['filtered']['filter']['geo_distance'] = array(
        //     'distance' => $distance_in_km.'km',
        //     'post.locations' => array("lat"=>$lat, "lon"=>$lon)
        // );

        // // sorting by distance
        // if ($sortby == 'distance') {
        //     $searchParams['body']['sort']['_geo_distance'] = array(
        //         'locations' => array("lat"=>$lat, "lon"=>$lon),
        //         'order' => $order,
        //         'unit' => 'km'
        //     );            
        // } else {
        //     if ($sortby != '')
        //         $searchParams['body']['sort'][$sortby] = array('order'=>$order); 
        //     else
        //         $searchParams['body']['sort']['id'] = array('order'=>'asc'); 
        // }

        // // Smart search
        // if ($q != ''){
        //     // $searchParams['body']['query']['filtered']['query']['bool']['should'][]['match']['post.lang.th.title'] = $q;
        //     // $searchParams['body']['query']['filtered']['query']['bool']['should'][]['match']['post.lang.en.title'] = $q;
        //      $searchParams['body']['query']['filtered']['query']['bool']['should']['fuzzy_like_this']['fields'] = array(
        //         "post.information.make",
        //         "post.information.model",
        //         "post.lang.en.title",
        //         "post.lang.th.title",
        //         "post.information.engineSize",
        //         ""
        //      );
        //      $searchParams['body']['query']['filtered']['query']['bool']['should']['fuzzy_like_this']['like_text'] = $q;
        // }

        // // Make
        // if($make != '')
        // $searchParams['body']['query']['filtered']['query']['bool']['must'][]['query_string'] = array(
        //     'default_field' => 'post.information.make',
        //     'query' => $make
        // );

        // // Model
        // if($model != '')
        // $searchParams['body']['query']['filtered']['query']['bool']['must'][]['query_string'] = array(
        //     'default_field' => 'post.information.model',
        //     'query' => $model
        // );

        // // Door
        // if($door != '')
        // $searchParams['body']['query']['filtered']['query']['bool']['must'][]['query_string'] = array(
        //     'default_field' => 'post.information.numberOfDoors',
        //     'query' => $door
        // );

        // // Engine size
        // if($engine_size != '')
        // $searchParams['body']['query']['filtered']['query']['bool']['must'][] = array(
        //     'term' => array('post.information.engineSize' => $engine_size)
        // );

        // // Price
        // $searchParams['body']['query']['filtered']['query']['bool']['should'][]['range'] = array(
        //     'post.price' => array(
        //         'from' => $min_price,
        //         'to' => $max_price
        //     )
        // );

        // // Pagination
        // $page = Input::has('page')? (int)Input::get('page') - 1 : 0;
        // // $page = 0;
        // $item_per_page = 8;

        // $searchParams['body']['from'] = $page;
        // $searchParams['body']['size'] = $item_per_page;

        // // Saerch...
        // $result = Es::search($searchParams);

        // $all_items = $result['hits']['total'];
        // $items = $result['hits']['hits'];

        // // pagination
        // $paginator = Paginator::make($items, $all_items, $item_per_page);
        // $inputs = Input::all();
        // unset($inputs['page']);
        // $pagination = $paginator->appends($inputs);

        // // return View::make('site.desktop.listing.listing_elasticsearch')
        // //         ->with('inputs', Input::all())
        // //         ->with('total', $all_items)
        // //         ->with('pager', $pagination)
        // //         ->with('posts', $items);
    }
}