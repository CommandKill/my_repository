<?php

class DesktopPostDetailController extends PostDetailController 
{
	var $questionaire_key = 'site_questionaire_id_for_delete_listing';
    public function __construct()
    {
        parent::__construct();
    }

    public function index($post_id)
    {
    	$detail = parent::getDetail($post_id);

		
		$province = Province::find($detail['post_by']['province_id']);
		
		$detail['province'] = $province['name'];

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

    	return View::make('site.desktop.postdetail.index', $detail)
                ->with('destination_url',URL::asset('uploaded/member/'))->with('questionaire', $questionaire);
    }
	
    public function saveFavoriteSatatus($id)
    {
		$status = false;
        $msg = '';
        $car_favorite = array();
        if (Session::has('member')) {
            $member = Session::get('member');
			$member_id = $member['id'];
            // $member = Member::find($member['id']);
			
			$bookmark = Bookmark::where('member_id',$member_id)->where('post_id',$id);
			// dd($bookmark->id);
			if($bookmark->count()) {
				// $bookmark->delete();
                $bookmark = $bookmark->first();
				Bookmark::destroy($bookmark->id);
				$status = true;
				$msg = 'Remove Favourite success';
			}else {
				Bookmark::create(array(
					'created_at' => new DateTime,
					'updated_at' => new DateTime,
					'member_id' => $member_id,
					'post_id' => $id
				));
				
				$status = true;
				$msg = 'Add Favourite success';
			}
			
            // if (isset($member->car_favorite) && $member->car_favorite != null && $member->car_favorite != '') {
//                 $car_favorite = explode(',', $member->car_favorite);
//                 if (false !== $key = array_search($id, $car_favorite)) {
//                     unset($car_favorite[$key]);
//                 } else {
//                     $car_favorite[] = $id;
//                 }
//                 $member->car_favorite = implode(',', $car_favorite);
//
//             } else {
//                 $member->car_favorite = $id;
//             }
//             $member->update();
        }

        return Response::json(array(
            'error' => false,
            'status' => $status,
            'msg' => $msg,
            'result' => ''),
            200
        );
    }
	
	public function shareEmail() {
		
		$messages = '';
		$status = false;
		$input = Input::all();
		$id = $input['id'];
		$friend_name = $input['share_friend_name'];
		$friend_email = $input['share_friend_email'];
		$name = $input['share_name'];
		$email = $input['share_email'];
		$msg = $input['share_message'];
		
		// $rules = array(
	// 	        'recaptcha_response_field' => 'required|recaptcha',
	// 	    );
	// 	$validator = Validator::make(
	// 	    $rules
	// 	);
	// 	if(!$validator->fails()) {

			$detail = parent::getDetail($id);
			$detail['price'] = ($detail['price']!='' || $detail['price']!=null) ? $detail['price'] : 0;  
		
			$mail = Mail::send('email.share', array('name'=>$name,'msg'=>$msg,'friend_name'=>$friend_name,'friend_email'=>$friend_email,'detail'=>$detail), function($message) use ($friend_email,$email)
			{
				$message->subject("Car share");
			    $message->from($email);
			    $message->to($friend_email);
			
			});

			$messages = 'share sucessfully!';

        return Response::json(array(
            'error' =>  false,
            'msg' => $messages,
            'result' => ''),
            200
        );
	}

}