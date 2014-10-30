<?php

class SellerVerifiedController extends SiteController 
{
    var $img_root_url;
    var $img_root_path = 'uploaded/seller_verified/';
    var $img_root_full_path;
    var $thumb_all_size = '80x50;110x73;160x100;320x200';
    var $thumb_size = '160x100';
    var $gallery_all_size = '80x50;110x73;160x100;330x200;512x342';
    var $gallery_thumb_size = '160x100';
    var $pattern_thumb = '%s-%s'; // '[thumbnail size]_[filename]'
    var $pattern_post_id = 'CS%s-%s-%s'; // 'CS[car_styleid]-[post_id]-[id]'
    var $item_per_page = 20;
    var $gallery_thumb_quality = 80;

    public function __construct()
    {
        parent::__construct();

        // filter route or something before
		$this->img_root_full_path = public_path($this->img_root_path);
		$this->img_root_url = URL::asset($this->img_root_path).'/';
		
        $this->beforeFilter('@filterRequests');
    }

	/**
     * Filter the incoming requests.
     */
    public function filterRequests($route, $request)
    {
        Debugbar::info('route ',$route, 'request',$request);
    }
    

    // public function addFileThumbnail()
    public function addID()
    {

    	$file_input_name = 'thumbnail-id';
        // $id = Input::get('id');
        $id = Session::get('member.id');
        $file = Input::file($file_input_name);

        $img_folder_url = $this->img_root_url.$id.'/';
        $img_folder_path = $this->img_root_full_path.$id.'/';

        // --- Delete old file
        if( $post = DB::table('seller_verified')->where( 'member_id', '=', Session::get('member.id') )->first() ){   

            $filename = $post->id_docs;

            File::delete($img_folder_path.$filename);

            $img_size = explode(';', $this->thumb_all_size);
            if(is_array($img_size) && !empty($img_size))
            foreach ($img_size as $key => $value) {
                $size = $value;
                File::delete($img_folder_path.$size.'-'.$filename);           
            }

            DB::table('seller_verified')->where( 'member_id', '=', Session::get('member.id') )->delete(); 
        }

        
        // Prepare folder for store all images
 		$this->makeDirectory($img_folder_path);

        if (Input::hasFile($file_input_name))
        {


            $filesize = $file->getSize();
        	$filename = Carbon::now()->timestamp . '.' . Input::file($file_input_name)->guessExtension();
			// dd($img_folder_path." > name > ".$filename." > id ".$id. ' > root url '.$img_folder_url );
        	// Save original file
        	$file->move($img_folder_path, $filename);

        	// resize image process
        	$img_size = explode(';', $this->thumb_all_size);
        	if(is_array($img_size) && !empty($img_size))
    		foreach ($img_size as $key => $value) {
    			$size = $value;
        		$this->resizeImage($img_folder_path.$filename, $img_folder_path.$size.'-'.$filename, $size);
    		}


            // $result = SellerVerified::find($id);
            // if( $result ){
            //     if( $result->verified != 1 ){
            //         DB::table('seller_verified')
            //         ->where( 'member_id', '=', Session::get('member.id') )
            //         ->update( array('id_docs' => $filename) );
            //     }
            // }

            if( $result = DB::table('seller_verified')->where( 'member_id', '=', Session::get('member.id') )->first() ){
                if( $result->verified != 1 ){
                    DB::table('seller_verified')
                    ->where( 'member_id', '=', Session::get('member.id') )
                    ->update( array('id_docs' => $filename) );
                }
            }else{
                DB::table('seller_verified')
                    ->insert( array(
                        'member_id'     => Session::get('member.id'), 
                        'verified'      => 0,
                        'id_docs'       => $filename )
                    );
            }



            $thumbnail_url = $img_folder_url . sprintf($this->pattern_thumb, $this->thumb_size, $filename);
            $original_url = $img_folder_url . $filename;
            $results = array(
                'name'          => $filename,
                'thumbnailUrl'  => $thumbnail_url,
                'url'           => $original_url,
                'size'          => $filesize,
                'deleteType'    =>'get',
                // 'deleteUrl'     => URL::to('admin/post/delete-thumbnail/'.$id)
                'deleteUrl'     => URL::to('verified/delete-id/'.$id)
            );
            $res[] = $results;
            return array('files'=>$res);
        }else {
            $res[] = ['error'=>true];
            return array('files'=>$res);
        }
    }

    public function deleteID(){

        $id = Session::get('member.id');
        $img_folder_path    = $this->img_root_full_path.$id.'/';
        
        $post = DB::table('seller_verified')->where( 'member_id', '=', Session::get('member.id') )->first();    

        $filename = $post->id_docs;

        File::delete($img_folder_path.$filename);

        $img_size = explode(';', $this->thumb_all_size);
        if(is_array($img_size) && !empty($img_size))
        foreach ($img_size as $key => $value) {
            $size = $value;
            File::delete($img_folder_path.$size.'-'.$filename);           
        }

        DB::table('seller_verified')->where( 'member_id', '=', Session::get('member.id') )->delete(); 
        
        return json_encode(array($filename=>true));

        
    }

    public function checkID(){

        $id = Session::get('member.id');
        $img_folder_url     = $this->img_root_url.$id.'/';
        $img_folder_path    = $this->img_root_full_path.$id.'/';

        // $result = DB::table('seller_verified')->where( 'member_id', '=', $id )->first();    

        // $verified = $result->verified;

        if( $result = DB::table('seller_verified')->where( 'member_id', '=', $id )->first() ){
            // $verified    = $result->verified;
            // $member_id   = $result->member_id;
            if($result->verified == 1){
                $detail     = DB::table('members')->where( 'id', '=', $result->member_id )->first();
                $results    = array(
                    'status'            => $result->verified,
                    'name'              => $detail->first_name,   
                    'id_docs_path'      => $img_folder_url.$result->id_docs,
                    // 'text'              => $data['text']['site'];      
                );
                // $res[] = $results;
                // return array('verified'=>$res);
            }else{
                // --- for waiting approve by admin
                $results    = array(
                    'status'            => $result->verified,
                    'name'              => '',    
                    'id_docs_path'      => $img_folder_url.$result->id_docs,
                    // 'text'              => $data['text']['site'];
                );
                // $res[] = $results;
                // return array('verified'=>$res);
            }
            
        }else{
                $results    = array(
                    'status'    => '99',
                    // 'name'      => '',                
                );
                // $res[] = $results;
                // return array('verified'=>$res);
        }
        $res[] = $results;
        return array('verified'=>$res);
        // return $verified;

    }

    /*
    |------------------------------------------------
    |   Car Document
    |------------------------------------------------
    */
    public function addCarDocs(){

        $file_input_name = 'thumbnail-carOwner';
        // $id = Input::get('id');
        $id = Session::get('member.id');
        $post_id = Input::get('id');
        $file = Input::file($file_input_name);

        $img_folder_url = $this->img_root_url.$id.'/'.$post_id.'/';
        $img_folder_path = $this->img_root_full_path.$id.'/'.$post_id.'/';

        // --- Delete old file
        if( $post = DB::table('car_owner_verified')->where( 'post_id', '=', $post_id )->first() ){   

            $filename = $post->car_owner_docs;

            File::delete($img_folder_path.$filename);

            $img_size = explode(';', $this->thumb_all_size);
            if(is_array($img_size) && !empty($img_size))
            foreach ($img_size as $key => $value) {
                $size = $value;
                File::delete($img_folder_path.$size.'-'.$filename);           
            }

            DB::table('car_owner_verified')->where( 'post_id', '=', $post_id )->delete(); 
        }

        
        // Prepare folder for store all images
        $this->makeDirectory($img_folder_path);

        if (Input::hasFile($file_input_name))
        {
            
            
            $filesize = $file->getSize();
            $filename = Carbon::now()->timestamp . '.' . Input::file($file_input_name)->guessExtension();
            // dd($img_folder_path." > name > ".$filename." > id ".$id. ' > root url '.$img_folder_url );
            // Save original file
            $file->move($img_folder_path, $filename);

            // resize image process
            $img_size = explode(';', $this->thumb_all_size);
            if(is_array($img_size) && !empty($img_size))
            foreach ($img_size as $key => $value) {
                $size = $value;
                $this->resizeImage($img_folder_path.$filename, $img_folder_path.$size.'-'.$filename, $size);
            }

            
            if( $result = DB::table('car_owner_verified')->where( 'post_id', '=', $post_id )->first() ){
                if( $result->verified != 1 ){
                    DB::table('car_owner_verified')
                    ->where( 'post_id', '=', $post_id )
                    ->update( array('car_owner_docs' => $filename) );
                }                
            }else{                
                DB::table('car_owner_verified')
                    ->insert( array(
                        'member_id'         => $id, 
                        'post_id'           => $post_id,
                        'verified'          => 0,
                        'car_owner_docs'    => $filename )
                    );
            }
            

            $thumbnail_url = $img_folder_url . sprintf($this->pattern_thumb, $this->thumb_size, $filename);
            $original_url = $img_folder_url . $filename;
            $results = array(
                'name'          => $filename,
                'thumbnailUrl'  => $thumbnail_url,
                'url'           => $original_url,
                'size'          => $filesize,
                'deleteType'    =>'get',
                // 'deleteUrl'     => URL::to('admin/post/delete-thumbnail/'.$id)
                // 'deleteUrl'     => URL::to('verified/delete-car-docs/'.$id)
            );
            $res[] = $results;
            return array('files'=>$res);
        }else {
            $res[] = ['error'=>true];
            return array('files'=>$res);
        }
    }

    public function deleteCarDocs(){

        $id = Session::get('member.id');
        // $post_id = Input::get('id');
        $post_id = $_GET['id'];
        $img_folder_path    = $this->img_root_full_path.$id.'/'.$post_id.'/';
        
        $post = DB::table('car_owner_verified')->where( 'post_id', '=', $post_id )->first();    

        $filename = $post->car_owner_docs;

        File::delete($img_folder_path.$filename);

        $img_size = explode(';', $this->thumb_all_size);
        if(is_array($img_size) && !empty($img_size))
        foreach ($img_size as $key => $value) {
            $size = $value;
            File::delete($img_folder_path.$size.'-'.$filename);           
        }

        DB::table('car_owner_verified')->where( 'post_id', '=', $post_id )->delete(); 
        
        return json_encode(array($filename=>true));

        
    }

    public function checkCar(){

        $id = Session::get('member.id');
        $post_id = Input::get('id');
        // $post_id = $_GET['id'];

        $img_folder_url     = $this->img_root_url.$id.'/'.$post_id.'/';
        $img_folder_path    = $this->img_root_full_path.$id.'/'.$post_id.'/';

        if( $result = DB::table('car_owner_verified')->where( 'post_id', '=', $post_id )->first() ){
            // if($result->verified == 1){
            //     $detail     = DB::table('members')->where( 'id', '=', $result->member_id )->first();
            //     $results    = array(
            //         'status'            => $result->verified,
            //         'docs_path'      => $img_folder_url.$result->id_docs,
            //     );
            // }else{
            //     // --- for waiting approve by admin
            //     $results    = array(
            //         'status'            => $result->verified,
            //         'docs_path'      => $img_folder_url.$result->id_docs,
            //     );
            // }
            $results    = array(
                    'status'         => $result->verified,
                    'docs_path'      => $img_folder_url.$result->car_owner_docs,
                );

        }else{
                $results    = array(
                    'status'         => '99',
                    'docs_path'      => '',
                );
        }
        $res[] = $results;
        return array('verified'=>$res);
    }

}






