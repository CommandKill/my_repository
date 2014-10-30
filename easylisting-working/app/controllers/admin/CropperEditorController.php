<?php
class CropperEditorController extends ContentController 
{
	public function __construct()
	{
		parent::__construct();
	}

    public function getIndex()
    {
    	$src = Input::get('src');
    	$dest_size = Input::get('dest_size');
    	$dest = Input::get('dest');
    	list($dest_width, $dest_height) = explode('x', $dest_size);
		return View::make('admin.toolkit.cropper-editor')
				->with('src', $src)
				->with('dest_width', $dest_width)
				->with('dest_height', $dest_height)
				->with('dest', $dest);
    }

    public function postCrop()
    {
    	$src = Input::get('src', '');
    	$dest = Input::get('dest', '');
    	$x = Input::get('x', '');
    	$y = Input::get('y', '');
    	$width = Input::get('width', '');
    	$height = Input::get('height', '');
        $dest_width = Input::get('dest_width', '');
        $dest_height = Input::get('dest_height', '');

    	if($src == '' 
    		|| $dest == ''
    		|| $x == ''
    		|| $y == ''
    		|| $width == ''
    		|| $height == '') {
    		dd('*missing some params*');
    	}

		// open an image file
		$img = Image::make($src);

		// crop image
		$img->crop($width, $height, (int)$x, (int)$y);

		// $img->resize($dest_width, $dest_height);
        $img->resize($dest_width, $dest_height,function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

		// save image in desired format
		$img->save($dest);

		// send HTTP header and output image data
		header('Content-Type: image/png');
		echo $img->encode('png');
    }
}	
?>