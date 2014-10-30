<?php
class TagsController extends AdminController {

	public function __construct()
	{
		parent::__construct();
	}

	public function getAll()
    {
        // $tags = Tag::all(array('id as value','text','continent'))->toArray();
       	// return Response::json($tags, 200);
       	$res = [];
       	$tags = Tag::all();
       	foreach ($tags as $key => $value) {
       		$res[] = $value->text;
       	}

       	return Response::json($res, 200);
    }
}	
?>