<?php
class IndexToolController extends ContentController 
{
	var $item_per_page = 100;

	public function __construct()
	{
		parent::__construct();
	}

    public function getIndex()
    {


        $this->data['title'] = 'Index';



		return View::make('admin.index-tool.index');
    }

    public function getUpdateCarAvariableSubModel()
    {
        // echo "<script language=\"javascript\">function pageScroll() {window.scrollBy(0,10); // horizontal and vertical scroll incrementsscrolldelay = setTimeout('pageScroll()',100); // scrolls every 100 milliseconds}</script>";
        // flush();
        // get car avaliable in make
        CarbaseSubModel::chunk(200, function($m)
        {
            foreach ($m as $key => $value) {
                $submodel_id = $value->id;
                $count = DB::table('posts')->where('submodel_id', $submodel_id)->count();
                $affectedRows  = CarbaseSubModel::where('id', $submodel_id)->update(array('car_avaliable' => $count));
                // if ($affectedRows > 0) {
                    echo $submodel_id.') '.$value->sub_model.' car total <b style="color:red">'.$count.'</b><br/>';
                    flush();
                // }
            }
           return true;
        });

        echo '[DONE!]';
    }

    public function getUpdateCarAvariableMakeModel()
    {
        // echo "<script language=\"javascript\">function pageScroll() {window.scrollBy(0,10); // horizontal and vertical scroll incrementsscrolldelay = setTimeout('pageScroll()',100); // scrolls every 100 milliseconds}</script>";
        // flush();
        // get car avaliable in make
        CarbaseMake::chunk(200, function($m)
        {
            foreach ($m as $key => $value) {
                $make_id = $value->id;
                $count = DB::table('posts')->where('make_id', $make_id)->count();
                $affectedRows = CarbaseMake::where('id', $make_id)->update(array('car_avaliable' => $count));
                // if ($affectedRows > 0) {
                    echo $make_id.') '.$value->make.' car total <b style="color:red">'.$count.'</b><br/>';
                    flush();
                // }
            }

            return true;
        });

        CarbaseModel::chunk(200, function($m)
        {
            foreach ($m as $key => $value) {
                $mode_id = $value->id;
                $count = DB::table('posts')->where('model_id', $mode_id)->count();
                $affectedRows  = CarbaseModel::where('id', $mode_id)->update(array('car_avaliable' => $count));
                // if ($affectedRows > 0) {
                    echo $mode_id.') '.$value->model.' car total <b style="color:red">'.$count.'</b><br/>';
                    flush();
                // }
            }
           return true;
        });

        // CarbaseSubModel::chunk(200, function($m)
        // {
        //     foreach ($m as $key => $value) {
        //         $submodel_id = $value->id;
        //         $count = DB::table('posts')->where('submodel_id', $submodel_id)->count();
        //         $affectedRows  = CarbaseSubModel::where('id', $submodel_id)->update(array('car_avaliable' => $count));
        //         // if ($affectedRows > 0) {
        //             echo $submodel_id.') '.$value->sub_model.' car total <b style="color:red">'.$count.'</b><br/>';
        //             flush();
        //         // }
        //     }
        //    return true;
        // });

        echo '[DONE!]';

        // $make = CarbaseMake::(500, function($results)
        // {
        //     $make_id = $value->id;
        //     $count = DB::table('posts')->where('make_id', $make_id)->count();
        //     echo $results->id.'|'.$results->make.'='.$count.'<br/>';
        //     // your logic
        //     return $results;
        // };
        // foreach ($make as $key => $value) {
        //     $make_id = $value->id;
        //     $count = DB::table('posts')->where('make_id', $make_id)->count();
        //     // echo $value->id.'|'.$value->make.'='.$count.'<br/>';
        //     CarbaseMake::where('make_id', $make_id)->update(array('car_avaliable' => $count));
        // }

        // // get car avaliable in model
        // $model = CarbaseModel::all();
        // foreach ($model as $key => $value) {
        //     $model_id = $value->id;
        //     $count = DB::table('posts')->where('model_id', $model_id)->count();
        //     // echo $value->id.'|'.$value->model.'='.$count.'<br/>';
        //     CarbaseModel::where('model_id', $model_id)->update(array('car_avaliable' => $count));
        // }

        // // get car avaliable in sub model
        // $submodel = CarbaseSubModel::all();
        // foreach ($submodel as $key => $value) {
        //     $submodel_id = $value->id;
        //     $count = DB::table('posts')->where('submodel_id', $submodel_id)->count();
        //     // echo $value->id.'|'.$value->sub_model.'='.$count.'<br/>';
        //     CarbaseSubModel::where('submodel_id', $submodel_id)->update(array('car_avaliable' => $count));
        // }

        // echo '<pre>';
        // dd($make->toArray());
    }

    static function indexPostAction($pure = true){
    	$index_name = 'posts';
    	$index_type = 'post';

        try {
            $deleteParams['index'] = $index_name;
            Es::indices()->delete($deleteParams);
        } catch (Exception $e) {

        }

    	// Example Index Mapping
        $post_mapping = array(
            'properties' => array(
                'locations' => array('type' => 'geo_point'),
                "car_suggest" => array(
                    'type' => 'completion',
                    'index_analyzer' => 'thai',
                    "payloads" => true
                ),
                'price' => array('type' => 'integer')
            )
        );

        //Create index with setting properties
        $params = array();
        $params['index'] = $index_name;
        // $params['type'] = 'post';
        $params['body']['mappings']['post'] = $post_mapping;

        // "analyzer" 
        $params['body']['settings']['analysis']['analyzer']['thai'] = array(
        	'tokenizer' => 'thai',
        	'filters' => array(
        		'lowercase',
        		'thai_stop'
        	)
        );
        $params['body']['settings']['analysis']['filter'] = array(
        	'thai_stop' => array(
        		'type'=>'stop', 
        		'stopwords'=> '_thai_'
        	)
        );

        $i = Es::indices()->create($params);
        // var_dump($i);

    	// get all post only status == active
    	$posts = Post::select('*')
            ->where('status','=', Config::get('site.status.active'))
            ->with(array('gallery' => function($q) { 
                $q->orderBy('order', 'asc');
            }))
            ->with(array('lang' => function($query){
                $query->with('language');
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
            ->with('tags')
            ->with('seller_verified')
            ->get();
        // echo '<pre>';
        // foreach ($posts->toArray() as $key => $value) {
        //     echo 'id ' . $value['id'].'<br/>';
        // }
        // dd($posts->toArray());

        if(!$posts && !is_array($posts) && empty($posts)) {
        	return;
        }

        $posts = $posts->toArray();
        $completed = true;
        $res = '';
        foreach ($posts as $key => $value) {

            $tags = array();
            foreach ($value['tags'] as $key_tags => $value_tags) {
                $tags[] = $value_tags['tag_text'];
            }
            $value['tags'] = $tags;

        	$lang = array();
            foreach ($value['lang'] as $key_lang => $value_lang) 
            {
                $lang[$value_lang['language']['short_code']] = array(
                    'title' => $value_lang['title'],
                    'description' => $value_lang['description'],
                    'detail' => $value_lang['detail'],
                );
            }
            $value['lang'] = $lang;

	        $car_suggest = array();
	        if (isset($value['make']) && isset($value['model']['model'])) {
                $car_suggest = array(
                    'input' => array( $value['make']['make'], $value['model']['model']),
                    'output' => $value['make']['make'].' '.$value['model']['model'],
                    'payload' => array('post_id' => $value['id'])
                );
            }

	        $item = $value;
        	$item['price'] = (int)$item['price'];
        	$item_extent = array(
                'car_suggest' => $car_suggest,
                'locations' => array(
                    'lat'=>(float)$value['latitude'],
                    'lon'=>(float)$value['longitude']
                )
            );
        	$item = array_merge($item, $item_extent);

        	// index process
            $params = array();
            $params['index'] = $index_name;
            $params['type'] =  $index_type;
            $params['id'] = $value['id'];
            $params['body']  = $item;
            $ret = Es::index($params);

            if (!$pure) {
	            if (!$ret['created']) {
	            	Notification::warning('Index post id '.$value['id'].' not work!');
	            } else {
	            	$res .= 'Post id '.$value['id'].' index is <b>[Done]</b><br/>'; 
	            }
            }

			// echo '<pre>';
			// var_dump($ret);
			// echo '<hr>';
        }

        if (!$pure && $completed) {
        	Notification::success('Indexing completed <br/>'.$res);
        }
    }

    public function getIndexPost()
    {
    	IndexToolController::indexPostAction(false);

        return Redirect::to('admin/index-tool');
    }
}	
?>