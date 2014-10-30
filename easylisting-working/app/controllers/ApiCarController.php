<?php

class ApiCarController extends APIController
{
	public function __construct()
	{
		parent::__construct();
	}

    public function getIndex()
    {
        $this->printMethod('ApiCarController','v1/car');
    }

   	public function getYear()
    {
        $data = DB::table('carbase_years')->select('id','year');
        $data = $data->orderBy('year', 'desc')->get();
        return Response::json(array(
            'error' => false,
            'years' => $data),
            200
        );
    }

    public function getMake()
    {
        $data = DB::table('carbase_makes')->select('id','make');
        $data = $data->orderBy('make', 'asc')->get();
        return Response::json(array(
            'error' => false,
            'makes' => $data),
            200
        );
    }

    public function getMakeGroup()
    {
        $data = DB::select(DB::raw('select id, substr(make,1,1) as groupname, make, car_avaliable from `carbase_makes` order by make'));
        $res = array();
        // re format follow dropdown style
        foreach ($data as $key => $value) {
            $res[$value->groupname][] = array(
                'id' => $value->id,
                'make' => $value->make,
                'avaliable' => $value->car_avaliable
            );
        }

        // $data = DB::table('carbase_makes')->select('id','make');
        // $data = $data->orderBy('make', 'asc')->get();
        return Response::json(array(
            'error' => false,
            'makes' => $res),
            200
        );
    }

    public function getModelGroup()
    {
        $make_id = Input::get('make_id');
        // $data = DB::table('carbase_models')->select('id','model');
        // if ($make_id != null) {
        //     $data = $data->where('make_id', $make_id);
        // }

        // $data = $data->orderBy('model', 'asc')->get();

        $data = DB::select(
            DB::raw('select id, substr(model,1,1) as groupname, model, car_avaliable from `carbase_models` where make_id = :make_id order by model'),
            array('make_id' => $make_id)
        );
        $res = array();
        // re format follow dropdown style
        foreach ($data as $key => $value) {
            $res[$value->groupname][] = array(
                'id' => $value->id,
                'model' => $value->model,
                'avaliable' => $value->car_avaliable
            );
        }

        return Response::json(array(
            'error' => false,
            'models' => $res),
            200
        );
    }


    public function getModel()
    {
        $make_id = Input::get('make_id');
        $data = DB::table('carbase_models')->select('id','model');
        if ($make_id != null) {
            $data = $data->where('make_id', $make_id);
        }

        $data = $data->orderBy('model', 'asc')->get();
        return Response::json(array(
            'error' => false,
            'models' => $data),
            200
        );
    }

    public function getSubModel()
    {
        $model_id = Input::get('model_id');
        $data = DB::table('carbase_submodels')->select('id','sub_model');
        if ($model_id != null) {
            $data = $data->where('model_id', $model_id);
        }

        $data = $data->orderBy('sub_model', 'asc')->get();
        return Response::json(array(
            'error' => false,
            'submodels' => $data),
            200
        );
    }


    public function getColor()
    {
        $data = DB::table('carbase_colors')->select('id','color');
        $data = $data->orderBy('color', 'asc')->get();
        return Response::json(array(
            'error' => false,
            'colors' => $data),
            200
        );
    }

    public function getEngine()
    {
        $data = DB::table('carbase_engines')->select('id','size');
        $data = $data->orderBy('size', 'asc')->get();
        return Response::json(array(
            'error' => false,
            'engines' => $data),
            200
        );
    }

    public function getFuel()
    {
        $data = DB::table('carbase_fuels')->select('id','type');
        $data = $data->orderBy('type', 'asc')->get();
        return Response::json(array(
            'error' => false,
            'fuels' => $data),
            200
        );
    }

    public function getGear()
    {
        $data = DB::table('carbase_gears')->select('id','gear');
        $data = $data->orderBy('gear', 'asc')->get();
        return Response::json(array(
            'error' => false,
            'gears' => $data),
            200
        );
    }

    public function getBody()
    {
        $data = DB::table('carbase_bodies')->select('id','body');
        $data = $data->orderBy('body', 'asc')->get();
        return Response::json(array(
            'error' => false,
            'bodies' => $data),
            200
        );
    }

    public function getPart()
    {
        $cars = CarbasePart::where('id','>',0)
            //->with('lang');
            ->with(array('lang' => function($query) { 
               $query->where('language_id', '1');
           }))->get()->toArray();

        $res = array();
        foreach ($cars as $key => $value) {
            $res[$value['id']] = array(
                'parts_id' => $value['id'],
                'language_id' => $value['lang'][0]['language_id'],
                'title' => $value['lang'][0]['title']
                );
        }

        return Response::json(array(
            'error' => false,
            'parts' => $res),
            200
        );
    }
}