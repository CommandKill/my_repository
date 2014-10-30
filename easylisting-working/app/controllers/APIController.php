<?php

class APIController extends BaseController 
{
	public function __construct()
	{
		parent::__construct();
	}

    public function getList()
    {
        $class_methods = get_class_methods('APIController');
        echo '<pre>';
        dd($class_methods);
    }

    public function printMethod($class_name, $prefix)
    {
        $class_methods = get_class_methods($class_name);
        $res = array();
        foreach ($class_methods as $key => $value) {
            if (substr($value, 0, 3) === 'get' && strpos($value, 'Filter') === false && strpos($value, 'Index') === false) {
                $link =  URL::to('api/'.$prefix.'/'.strtolower(str_replace('get', '', $value)));
                $res[] = '<a href="'.$link.'">'.$link.'</a>';
            }
        }

        if(isset($_GET['html'])) {
            echo '<ul><li>';
            echo implode('</li><li>', $res);
            echo '</li></ul>';
        } else {
            return Response::json(array(
                'error' => false,
                'method' => $res),
                200
            );
        }
        
    }
}