<?php

class ApiCarElasticSearchController extends APIController
{
	public function __construct()
	{
		parent::__construct();
	}

    public function getIndex()
    {
        $this->printMethod('ApiCarElasticSearchController','v2/car');
    }

    public function getYear()
    {
        $searchParams['index'] = 'car_year';
        $searchParams['type'] =  'year';
        // $searchParams['body']['fields'] = array('make', 'car_avaliable');
        $searchParams['body']['query']['match_all'] = array();
        $searchParams['body']['sort']['year'] = array('order'=>'desc');
        $searchParams['body']['size'] = 100;
        $result = Es::search($searchParams);

        $data = array();
        foreach ($result['hits']['hits'] as $key => $value) {
            $data[] = $value['_source']['year'];
        }

        return Response::json(array(
            'error' => false,
            'year' => $data),
            200
        );
    }

    public function getMake()
    {
        $searchParams['index'] = 'car_make';
        $searchParams['type'] =  'make';
        // $searchParams['body']['fields'] = array('make', 'car_avaliable');
        $searchParams['body']['query']['match_all'] = array();
        $searchParams['body']['sort']['make'] = array('order'=>'asc');
        $searchParams['body']['size'] = 100;
        $result = Es::search($searchParams);

        $data = array();
        foreach ($result['hits']['hits'] as $key => $value) {
            $data[] = array(
                'make' => $value['_source']['make'],
                'avaliable' => $value['_source']['car_avaliable']
            );
        }

        return Response::json(array(
            'error' => false,
            'makes' => $data),
            200
        );
    }

    public function getModel()
    {
        $make = Input::get('make','');

        $searchParams['index'] = 'car_model';
        $searchParams['type'] =  'model';
        // $searchParams['body']['fields'] = array('model', 'car_avaliable'); //!!!!!!!! FIXME: BUG fix this later
        $searchParams['body']['query']['bool']['must'][]['query_string'] = array(
            'default_field' => 'model.make',
            'query' => $make
        );
        $searchParams['body']['size'] = 100;
        $searchParams['body']['sort'][]['model'] = array('order'=>'asc');
        $result = Es::search($searchParams);

        $data = array();
        foreach ($result['hits']['hits'] as $key => $value) {
            $data[] = array(
                'model' => $value['_source']['model'],
                'avaliable' => $value['_source']['car_avaliable']
            );
        }

        return Response::json(array(
            'error' => false,
            'models' => $data),
            200
        );
    }

    public function getDoor()
    {
        $searchParams['index'] = 'car_door';
        $searchParams['type'] =  'door';
        // $searchParams['body']['fields'] = array('make', 'car_avaliable');
        $searchParams['body']['query']['match_all'] = array();
        $searchParams['body']['sort']['door'] = array('order'=>'asc');
        $searchParams['body']['size'] = 100;
        $result = Es::search($searchParams);

        $data = array();
        foreach ($result['hits']['hits'] as $key => $value) {
            $data[] = $value['_source']['door'];
        }

        return Response::json(array(
            'error' => false,
            'door' => $data),
            200
        );
    }

    public function getTransmission()
    {
        $searchParams['index'] = 'car_transmission';
        $searchParams['type'] =  'transmission';
        // $searchParams['body']['fields'] = array('make', 'car_avaliable');
        $searchParams['body']['query']['match_all'] = array();
        $searchParams['body']['sort']['transmission'] = array('order'=>'asc');
        $searchParams['body']['size'] = 100;
        $result = Es::search($searchParams);

        $data = array();
        foreach ($result['hits']['hits'] as $key => $value) {
            $data[] = $value['_source']['transmission'];
        }

        return Response::json(array(
            'error' => false,
            'transmission' => $data),
            200
        );
    }

    public function getFuel()
    {
        $searchParams['index'] = 'car_fuel';
        $searchParams['type'] =  'fuel';
        // $searchParams['body']['fields'] = array('make', 'car_avaliable');
        $searchParams['body']['query']['match_all'] = array();
        $searchParams['body']['sort']['fuel'] = array('order'=>'asc');
        $searchParams['body']['size'] = 100;
        $result = Es::search($searchParams);

        $data = array();
        foreach ($result['hits']['hits'] as $key => $value) {
            $data[] = $value['_source']['fuel'];
        }

        return Response::json(array(
            'error' => false,
            'fuels' => $data),
            200
        );
    }

    public function getEngine()
    {
        $searchParams['index'] = 'car_engine';
        $searchParams['type'] =  'engine';
        // $searchParams['body']['fields'] = array('make', 'car_avaliable');
        $searchParams['body']['query']['match_all'] = array();
        $searchParams['body']['sort']['engine'] = array('order'=>'asc');
        $searchParams['body']['size'] = 100;
        $result = Es::search($searchParams);

        $data = array();
        foreach ($result['hits']['hits'] as $key => $value) {
            $data[] = $value['_source']['engine'];
        }

        return Response::json(array(
            'error' => false,
            'door' => $data),
            200
        );
    }

    public function getBody()
    {
        $searchParams['index'] = 'car_body';
        $searchParams['type'] =  'body';
        // $searchParams['body']['fields'] = array('make', 'car_avaliable');
        $searchParams['body']['query']['match_all'] = array();
        $searchParams['body']['sort']['body'] = array('order'=>'asc');
        $searchParams['body']['size'] = 100;
        $result = Es::search($searchParams);

        $data = array();
        foreach ($result['hits']['hits'] as $key => $value) {
            $data[] = $value['_source']['body'];
        }

        return Response::json(array(
            'error' => false,
            'body' => $data),
            200
        );
    }

    public function getCarTypeWithModel()
    {
        $year = Input::get('year');
        $make = Input::get('make');
        $model = Input::get('model');

        $data = DB::table('cars_vehicle')->select('model','vehicleStyle as type')->distinct();
        
        if ($year != null) {
            $data = $data->where('year', $year);
        }
        if ($make != null) {
            $data = $data->where('make', $make);
        }
        if ($model != null) {
            $data = $data->where('model', $model);
        }

        $data = $data->orderBy('vehicleStyle', 'asc')->get();
        return Response::json(array(
            'error' => false,
            'types' => $data),
            200
        );
    }

    public function getColor()//Interior
    {
        $make = Input::get('make','');
        $model = Input::get('model','');

        $searchParams['index'] = 'car_color';
        $searchParams['type'] =  'color';
        $searchParams['body']['query']['bool']['must'][]['query_string'] = array(
            'default_field' => 'color.make',
            'query' => $make
        );
        $searchParams['body']['query']['bool']['must'][]['query_string'] = array(
            'default_field' => 'color.model',
            'query' => $model
        );
        // $searchParams['body']['size'] = 100;
        // $searchParams['body']['sort'][]['color'] = array('order'=>'asc');
        // echo '<pre>';
        // var_dump($searchParams);
        // echo '<hr>';
        $result = Es::search($searchParams);
        
        // var_dump($result);
        // $data = array();
        foreach ($result['hits']['hits'] as $key => $value) {
            $data = $value['_source']['color'];
        }

        return Response::json(array(
            'error' => false,
            'colors' => $data),
            200
        );
    }
}