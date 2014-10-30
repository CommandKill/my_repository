<?php

use Artdarek\OAuth\Facade\OAuth as Social;

class DesktopMemberController extends SiteController
{
    public function __construct()
    {
        parent::__construct();

        $this->imagesize = array('300x300','150x150','50x50');
        $this->destination_url = asset('/uploaded').'/member/';
        $this->destination_path = public_path().'/uploaded/member/';
        $this->avatar_prefix = 'member_';
        $this->avatar_thumb_size = '150x150';
        $this->pattern_thumb = '%s-%s';

        $this->key_email_template_for_signup = 'site_email_template_for_signup';
        $this->key_email_template_for_resetpwd_confirm_request = 'site_email_template_for_resetpwd_confirm_request';
        $this->key_email_template_for_resetpwd_sendpwd = 'site_email_template_for_resetpwd_sendpwd';

        $this->text_template_new_customer_msg = 'new_customer_msg';
        $this->text_template_sent_new_pwd_msg = 'sent_new_pwd_msg';
        $this->text_template_finished_signup = 'finished_signup';
        $this->text_template_finished_forgotpwd = 'finished_forgotpwd';
        $this->text_template_finished_verify = 'finished_verify';
        $this->text_template_account_is_exist = 'account_is_exist';
        $this->text_template_verification_code_expired = 'verification_code_expired';
    }

    public function index()
    {
        //return View::make('site.page');
    }

    public function unlinkFacebook()
    {

        $id = Session::get('member.id');
        $member = Member::find($id);
        $data['facebook_id'] = "";
        $data['facebook_link'] = "";

        $member->update($data);
        Notification::success('Facebook unlinked');

        return Redirect::to($this->current_lang.'/profile');
    }

    public function emailVerify()
    {
        // check session is exist and not expire (create_at)
        if (Input::has('code')) {
            $verified_code = Input::get('code');
            $member = Member::where('verified_code', '=', $verified_code)
                ->where('verified', '!=', 1)
                ->where('status', '=', 1)
                ->where('verified_expire', '>=', new DateTime('today'))
                ->first();
            if ($member) {
                $member->verified = 1;
                $member->save();

                // get template message
                $text_template = TextLanguage::where('language_id', $this->languages[$this->current_lang]['id'])
                                ->where('key', $this->text_template_finished_verify)
                                ->first();
                $email_data = str_replace('[email]', $member->email, $text_template['value'] );

                Session::forget('member');
                Session::put('member.id', $member->id);
                Session::put('member.email', $member->email);
                Session::put('member.facebook_id', $member->facebook_id);
                Session::put('member.first_name', $member->first_name);
                Session::put('member.last_name', $member->last_name);
                Session::put('member.avatar', $member->avatar);

                // redirect to homepage or back URL param?
                // return Redirect::to(App::getLocale().'/profile');

                return View::make('site.desktop.member.finished_verify')
                    ->with('email_template', $email_data )
                    ->with('email', $member->email);

            } else {
                // get template message
                $email_template = TextLanguage::where('language_id', $this->languages[$this->current_lang]['id'])
                                ->where('key', $this->text_template_verification_code_expired)
                                ->first();
                return View::make('site.desktop.member.finished_verify_error')
                            ->with('email_template', $email_template['value']);
            }

            // activate account


            // return to sign in page

        }
        // if nothing to do redirect to home
        return Redirect::to(App::getLocale().'/');
    }

    public function resentVerifyEmail()
    {
        if(Session::has('resent-verify-email-member-id')) {
            $member_id = Session::get('resent-verify-email-member-id');

            $member = Member::where('id', '=', $member_id)->first();
            if(isset($member)) {
                // send email to activate account
                // get email template at key 'signup'
                $email_template_setting = Setting::where('key', '=', $this->key_email_template_for_signup)->get();
                $email_template = EmailTemplate::where('id', $email_template_setting[0]->value)->with('template')->first();

                if ($email_template ) 
                {
                    $link  = URL::to('email-verify?code='.$member->verified_code);
                    $link = '<a href="'.$link.'">[clicking here]</a>';

                    // replace {{ $link }} to variabe
                    $email_data = str_replace('[name]', $member->first_name.' '.$member->last_name, $email_template->template[1]['template']);
                    $email_data = str_replace('[link]', $link, $email_data );

                    $email_subject = $email_template->template[1]['subject'];
                    $email_from = $this->data['setting']['site_support_email'];
                    $email_from_name = $this->data['text']['site'];
                    $email_to = $member->email;
                    $email_to_name = $member->email;
                  
                    //Mail::send('emails.member_verify', array('link'=>$link), function($message) use ($inputs)
                    Mail::send('emails.email_empty', array('email_template'=>$email_data), 
                        function($message) use ($email_to, $email_to_name, $email_from, $email_from_name, $email_subject)
                        {
                            $message->to($email_to, $email_to_name)
                                //->subject(Lang::get('site.email_verify_subject'))
                                ->subject($email_subject)
                                //->from(getenv('ADMIN_EMAIL'), getenv('ADMIN_NAME'));
                                ->from($email_from, $email_from_name);
                        });

                    // get template message
                    $text_template = TextLanguage::where('language_id', $this->languages[$this->current_lang]['id'])
                                    ->where('key', $this->text_template_finished_signup)
                                    ->first();
                    $email_data = str_replace('[email]', $member->email, $text_template['value'] );

                    // reset
                    Session::forget('resent-verify-email-member-id');

                    // result page for notice member go to mail box for activate email
                    return View::make('site.desktop.member.finished_signup')
                        ->with('email_template', $email_data )
                        ->with('email',$member->email);
                }
            }

        }
        // if nothing to do redirect to home
        return Redirect::to(App::getLocale().'/');

    }

    public function signupWithFacebook()
    {
        // get data from input
        $code = Input::get( 'code' );

        // get fb service
        // $fb = OAuth::consumer( 'Facebook' );
		$fb = Social::consumer( 'Facebook' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            try {
                // This was a callback request from facebook, get the token
                $token = $fb->requestAccessToken( $code );

            } catch (Exception $e) {
                // get fb authorization !!! re-call in case expire code from Facebook !!!
                $url = $fb->getAuthorizationUri();

                // return to facebook login url
                return Redirect::to( (string)$url );
            }

            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );

            // check facebook account is exist?
            $member = Member::where('facebook_id', '=', $result['id'])->where('status', '=', 1)->first();
            if ($member) {
                // if verified? then signin
                if ($member['verified'] == 0) {
                    $member_in_time = Member::where('facebook_id', '=', $result['id'])
                            ->where('verified_expire', '>=', new DateTime('today'))
                            ->first();
                    // if not verified then tell client for verify email again or send email again or contact support?
                    if ($member_in_time) {

                        // get template message
                        $text_template = TextLanguage::where('language_id', $this->languages[$this->current_lang]['id'])
                                        ->where('key', $this->text_template_account_is_exist)
                                        ->first();
                        $email_template = str_replace('[email]', $member->email, $text_template['value'] );

                        $link = '<a href="'.URL::to(App::getLocale().'/resent-verify-email').'" >send it again</a>';

                        $email_template = str_replace('[link]', $link, $email_template );

                        Session::put('resent-verify-email-member-id', $member->id);

                        return View::make('site.desktop.member.finished_verify_again')
                            ->with('email_template', $email_template)
                            ->with('email',$member_in_time['email']);
                    } else {
                        // remove this reccord first for new register
                        // die($member_in_time['id']);
                        Member::destroy($member['id']);
                        return View::make('site.desktop.member.finished_verify_error');
                    }
                }

                Session::forget('member');
                Session::put('member.id', $member->id);
                Session::put('member.email', $member->email);
                Session::put('member.facebook_id', $member->facebook_id);
                Session::put('member.first_name', $member->first_name);
                Session::put('member.last_name', $member->last_name);
                Session::put('member.avatar', $member->avatar);
                
                // redirect to homepage or back URL param?
                return Redirect::to(App::getLocale().'/profile');
            } else {
                Debugbar::info($result);

                $data = array(
                    'facebook_id'   => $result['id'],
                    'email'         => $result['email'],
                    'username'      => $result['id'],
                    'first_name'    => $result['first_name'],
                    'last_name'     => $result['last_name'],
                    'name'          => $result['name'],
                    'timezone'      => $result['timezone'],
                    'locale'        => $result['locale'],
                    'gender'        => $result['gender'],
                    'facebook_link' => $result['link'],
                    'member_type'   => Config::get('site.member_type')
                );

                // check facebook id is used and activated and then automate signin?
                Redirect::to(App::getLocale().'/signin-with-facebook?code='.$code);

                // if used redirect to signin and show facebook avatar

                return View::make('site.desktop.member.signup')
                    ->with('data_form',$data);
            }
        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }
    }
    public function linkWithFacebook()
    {
        // get data from input
        $code = Input::get( 'code' );

        // get fb service
        // $fb = OAuth::consumer( 'Facebook' );
		$fb = Social::consumer( 'Facebook' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            try {
                // This was a callback request from facebook, get the token
                $token = $fb->requestAccessToken( $code );

            } catch (Exception $e) {
                // get fb authorization !!! re-call in case expire code from Facebook !!!
                $url = $fb->getAuthorizationUri();

                // return to facebook login url
                return Redirect::to( (string)$url );
            }

            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );

            Debugbar::info($result);

            $data = array(
                'facebook_id'   => $result['id'],
                // 'first_name'    => $result['first_name'],
                // 'last_name'     => $result['last_name'],
                'timezone'      => $result['timezone'],
                'locale'        => $result['locale'],
                'gender'        => $result['gender'],
                'facebook_link' => $result['link']
            );

            $id = Session::get('member.id');
            $member = Member::find($id);
            $member->update($data);

            Notification::success('Facebook linked');
			
			return Redirect::to(App::getLocale().'/profile');
        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }
    }
    public function signinWithFacebook()
    {
		if(Input::has('url')) {
			Session::put('urlReturn',Input::get('url'));
		}
        // get data from input
        $code = Input::get( 'code' );
        // die($code);
        // get fb service
        // $fb = OAuth::consumer( 'Facebook' );
		$fb = Social::consumer( 'Facebook' );
        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            try {
                // This was a callback request from facebook, get the token
                $token = $fb->requestAccessToken( $code );

            } catch (Exception $e) {
                // get fb authorization !!! re-call in case expire code from Facebook !!!
                $url = $fb->getAuthorizationUri();

                // return to facebook login url
                return Redirect::to( (string)$url );
            }

            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );

            Debugbar::info($result);

            // check facebook account is exist?
            $member = Member::where('facebook_id', '=', $result['id'])->where('status', '=', 1)->first();

            Debugbar::info($member);

            if ($member) {

                // if verified? then signin
                if ($member['verified'] == 0) {
                    $member_in_time = Member::where('facebook_id', '=', $result['id'])
                            ->where('verified_expire', '>', new DateTime('today'))
                            ->first();
                    // if not verified then tell client for verify email again or send email again or contact support?
                    if ($member_in_time) {
                        return View::make('site.desktop.member.finished_verify_again')
                            ->with('email',$member_in_time['email']);
                    } else {
                        // remove this reccord first for new register
                        // die($member_in_time['id']);
                        Member::destroy($member['id']);

                        return View::make('site.desktop.member.finished_verify_error');
                    }
                }

                Session::forget('member');
                Session::put('member.id', $member->id);
                Session::put('member.email', $member->email);
                Session::put('member.facebook_id', $member->facebook_id);
                Session::put('member.first_name', $member->first_name);
                Session::put('member.last_name', $member->last_name);
				Session::put('member.avatar', $member->avatar);
				
                // redirect to homepage or back URL param?
                // return Redirect::to(App::getLocale().'/profile');
				$reurl = Session::get('urlReturn', 'default');
				// die($reurl);
				Session::forget('urlReturn');
				return Redirect::to((string)$reurl);

            } else {
                $link = '<a href="'.App::getLocale().'/signup">Sign up</a>';
                Notification::warning('We not found your account please '.$link.'!');
                return Redirect::to('signin');

                // // redirect to create new user
                // $data = array(
                //     'facebook_id'   => $result['id'],
                //     'username'      => $result['id'],
                //     'email'         => $result['email'],
                //     'first_name'    => $result['first_name'],
                //     'last_name'     => $result['last_name'],
                //     'timezone'      => $result['timezone'],
                //     'locale'        => $result['locale'],
                //     'gender'        => $result['gender'],
                //     'facebook_link' => $result['link'],
                //     'member_type'   => Config::get('site.member_type')
                // );
                // // echo '<pre>';
                // // dd($data);

                // return View::make('site.desktop.member.signup')
                //     ->with('data_form',$data);
            }
        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }
    }

    public function signin()
    {
        $previous = App::getLocale().'/';
		if(Input::has('url')) {
			$previous = App::getLocale().'/'.Input::get('url');
		}
        return View::make('site.desktop.member.signin',['previous'=>$previous]);
    }

    public function takeSignin()
    {
        $inputs = Input::all();
        $validator = Validator::make(
            $inputs,
            array(
                'email' 	=> 'required|min:4|max:32|email|Exists:members,email',
                'password' 	=> 'required|min:3'
            )
        );

        if ($validator->fails())
        {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
            return Redirect::to('signin')
                ->withInput()
                ->withErrors($validator);
        } else {

            // check email is exist and password is correct
            $member = Member::where('email', '=', $inputs['email'])
                ->where('password', '=', md5($inputs['password']))
                ->where('status', '=', 1)
                ->where('verified', '=', 1)
                ->first();

            // DebugBar::info($member);

            if ($member) {

                Session::forget('member');
                Session::put('member.id', $member->id);
                Session::put('member.email', $member->email);
                Session::put('member.facebook_id', $member->facebook_id);
                Session::put('member.first_name', $member->first_name);
                Session::put('member.last_name', $member->last_name);
				Session::put('member.avatar', $member->avatar);

                // redirect to homepage or back URL param?
                return Redirect::to(App::getLocale().'/profile');

            } else {
                $link = '<a href="'.App::getLocale().'/signup">Sign up</a>';
                Notification::warning('We not found your account please '.$link.'!');
                return Redirect::to('signin')
                    ->withInput();
            }

        }
    }

    public function signout()
    {
        Session::forget('member');
        return Redirect::to(App::getLocale().'/');
    }

    public function signup()
    {
        $data = array(
            'username'      => '',
            'facebook_id'   => '',
            'first_name'    => '',
            'last_name'     => '',
            'timezone'      => '',
            'locale'        => '',
            'gender'        => '',
            'facebook_link' => '',
            'email'         => '',
            'member_type'   => Config::get('site.member_type')
        );

        return View::make('site.desktop.member.signup')
            ->with('data_form',$data);
    }

    public function takeSignup()
    {
		// dd("take sign up");
        $inputs = Input::all();
        $validator = Validator::make(
            $inputs,
            array(
                'email' 	=> 'required|min:4|max:32|email|unique:members,email',
				'facebook_id' => 'unique:members,facebook_id',
                'password' 	=> 'required|min:3|confirmed',
				'password_confirmation' => 'required'
                // 'accept'    => 'required'
            )
        );
		
		$messages = $validator->messages();
		
        if ($validator->fails())
        {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }

            return Redirect::to('signup')
                ->withInput()
                ->with('data',$inputs)
                ->withErrors($validator);
        } else {
            $verified_code = str_random(32);

            //dd($verified_code);

            // if facebook_id is set 
            // then save facebook avatar to disk and db for default user avatar
            // Your file
            if ($inputs['facebook_id'] != '') {
                
            }


            $member = Member::create(array(
                'facebook_id'           => $inputs['facebook_id'],
                'username'              => '',
                'first_name'            => $inputs['first_name'],
                'last_name'             => $inputs['last_name'],
                'timezone'              => $inputs['timezone'],
                'locale'                => $inputs['locale'],
                'gender'                => $inputs['gender'],
                'facebook_link'         => $inputs['facebook_link'],
                'email'                 => $inputs['email'],
				'email_secondary'		=> '',
                'password'              => md5($inputs['password']),
                'receive_newsletter'    => isset($inputs['receive_newsletter']) ? 1 : 0,
				'type'			        => 'individual', //$inputs['account-type'],
                'status'                => $this->status['active'],
				'verified'				=> 0,
                'verified_code'         => $verified_code ,
                'verified_expire'       => new \DateTime('tomorrow'),
				'public_email'			=> 0,
				'latitude'				=>0,
				'longitude'				=>0,
				'view'					=>0,
				'province_id'			=>0,
				'amphur_id'				=>0,
				'district_id'			=>0,
				'zipcode_id'			=>0
            ));

            $lastinsert_id = $member->id;

            if ($member->facebook_id != '') {
                 $this->saveAvatarFromFacebook($member);
            }

            // send email to activate account
            // get email template at key 'signup'
            $email_template_setting = Setting::where('key', '=', $this->key_email_template_for_signup)->get();
            $email_template = EmailTemplate::where('id', $email_template_setting[0]->value)->with('template')->first();

            if ($email_template ) 
            {
                $link  = URL::to('email-verify?code='.$verified_code);
                $link = '<a href="'.$link.'">[clicking here]</a>';

                // replace {{ $link }} to variabe
                $email_data = str_replace('[name]', $inputs['first_name'].' '.$inputs['last_name'], $email_template->template[1]['template']);
                $email_data = str_replace('[link]', $link, $email_data );

                $email_subject = $email_template->template[1]['subject'];
                $email_from = $this->data['setting']['site_support_email'];
                $email_from_name = $this->data['text']['site'];
                $email_to = $inputs['email'];
                $email_to_name = $inputs['email'];
              
                //Mail::send('emails.member_verify', array('link'=>$link), function($message) use ($inputs)
                Mail::send('emails.email_empty', array('email_template'=>$email_data), 
                    function($message) use ($email_to, $email_to_name, $email_from, $email_from_name, $email_subject)
                    {
                        $message->to($email_to, $email_to_name)
                            //->subject(Lang::get('site.email_verify_subject'))
                            ->subject($email_subject)
                            //->from(getenv('ADMIN_EMAIL'), getenv('ADMIN_NAME'));
                            ->from($email_from, $email_from_name);
                    });
            }

            // get template message
            $text_template = TextLanguage::where('language_id', $this->languages[$this->current_lang]['id'])
                            ->where('key', $this->text_template_finished_signup)
                            ->first();
            $email_data = str_replace('[email]', $inputs['email'], $text_template['value'] );

            // result page for notice member go to mail box for activate email
            return View::make('site.desktop.member.finished_signup')
                ->with('email_template', $email_data )
                ->with('email',$inputs['email']);
        }
    }

    public function saveAvatarFromFacebook($member)
    {
        if(!File::exists($this->destination_path.$member->id)) {
            File::makeDirectory($this->destination_path.$member->id, 0775, true, true);
            //File::makeDirectory($destination_path, $mode = 0777, true, true);
        }

        $file = 'http://graph.facebook.com/'.$member->facebook_id.'/picture?width=300&height=300';
        $content = file_get_contents($file);
        $data['avatar'] = $member->facebook_id.'.png';
        $new = $this->destination_path.$member->id.'/'.$data['avatar'];
        file_put_contents($new, $content);

        foreach($this->imagesize as $size) {
            $filename = $size.'-'.$member->facebook_id.'.png';
            list($w,$h) = explode('x', $size);

            Image::make($new)
                ->resize($w,$h,function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($this->destination_path.$member->id.'/'.$filename);
        }

        $member->update($data);
    }

    public function forgotpwd()
    {
        return View::make('site.desktop.member.forgotpwd');
    }

    public function takeForgotpwd()
    {
        $inputs = Input::all();
        $validator = Validator::make(
            $inputs,
            array(
                'email' => 'required|min:4|max:32|email|Exists:members,email'
            )
        );

        if ($validator->fails())
        {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
            return Redirect::to(App::getLocale().'/forgotpwd');
        } else {

            // create reset page URL
            $resetpwd_code = str_random(32);
            // store to db
            $member = Member::where('email', $inputs['email'])
                        ->where('status', $this->status['active'])
                        ->first();
            if($member) {
                // update code to db
                $member->req_resetpwd = 1;
                $member->req_resetpwd_code = $resetpwd_code;
                $member->req_resetpwd_expire = new \DateTime('tomorrow');
                $member->save();

            } else {
                Notification::warning('Not found your email!');
                return Redirect::to(App::getLocale().'/forgotpwd');
            }

            $email_template_setting = Setting::where('key', $this->key_email_template_for_resetpwd_confirm_request)->get();
            $email_template = EmailTemplate::where('id', $email_template_setting[0]->value)->with('template')->first();

            if ($email_template ) 
            {
                $link  = URL::to('resetpwd-verify?code='.$resetpwd_code);
                $link = '<a href="'.$link.'">[clicking here]</a>';

                // replace {{ $link }} to variabe
                $email_data = str_replace('[name]', $member->first_name.' '.$member->last_name, $email_template->template[1]['template']);
                $email_data = str_replace('[link]', $link, $email_data );

                $email_subject = $email_template->template[1]['subject'];
                $email_from = $this->data['setting']['site_support_email'];
                $email_from_name = $this->data['text']['site'];
                $email_to = $inputs['email'];
                $email_to_name = $inputs['email'];
              
                //Mail::send('emails.member_verify', array('link'=>$link), function($message) use ($inputs)
                Mail::send('emails.email_empty', array('email_template'=>$email_data), 
                    function($message) use ($email_to, $email_to_name, $email_from, $email_from_name, $email_subject)
                    {
                        $message->to($email_to, $email_to_name)
                            //->subject(Lang::get('site.email_verify_subject'))
                            ->subject($email_subject)
                            //->from(getenv('ADMIN_EMAIL'), getenv('ADMIN_NAME'));
                            ->from($email_from, $email_from_name);
                    });
            }

            // get template message
            $text_template = TextLanguage::where('language_id', $this->languages[$this->current_lang]['id'])
                            ->where('key', $this->text_template_finished_forgotpwd)
                            ->first();
            $email_data = str_replace('[email]', $inputs['email'], $text_template['value'] );

            return View::make('site.desktop.member.finished_forgotpwd')
                ->with('email_template', $email_data )
                ->with('email',$inputs['email']);
        }
    }

    public function resetPasswordVerify()
    {
        // check session is exist and not expire (create_at)
        if (Input::has('code')) {
            $verified_code = Input::get('code');
            $member = Member::where('req_resetpwd_code', '=', $verified_code)
                ->where('req_resetpwd_expire', '>', new DateTime())
                ->first();
            if ($member) {

                // generate new password
                $new_password = str_random(6);
                $member->password = MD5($new_password);
                $member->req_resetpwd = 0;
                $member->save();

                $email_template_setting = Setting::where('key', $this->key_email_template_for_resetpwd_sendpwd)->get();
                $email_template = EmailTemplate::where('id', $email_template_setting[0]->value)->with('template')->first();

                if ($email_template ) 
                {
                    $link  = URL::to('signin');
                    $link = '<a href="'.$link.'">[sing in with new password here]</a>';

                    // replace {{ $link }} to variabe
                    $email_data = str_replace('[name]', $member->first_name.' '.$member->last_name, $email_template->template[1]['template']);
                    $email_data = str_replace('[password]', $new_password, $email_data);
                    $email_data = str_replace('[email]', $member->email, $email_data );
                    $email_data = str_replace('[link]', $link, $email_data );

                    $email_subject = $email_template->template[1]['subject'];
                    $email_from = $this->data['setting']['site_support_email'];
                    $email_from_name = $this->data['text']['site'];
                    $email_to = $member->email;
                    $email_to_name = $member->email;
                  
                    //Mail::send('emails.member_verify', array('link'=>$link), function($message) use ($inputs)
                    Mail::send('emails.email_empty', array('email_template'=>$email_data), 
                        function($message) use ($email_to, $email_to_name, $email_from, $email_from_name, $email_subject)
                        {
                            $message->to($email_to, $email_to_name)
                                //->subject(Lang::get('site.email_verify_subject'))
                                ->subject($email_subject)
                                //->from(getenv('ADMIN_EMAIL'), getenv('ADMIN_NAME'));
                                ->from($email_from, $email_from_name);
                        });
                }

            } else {
                return View::make('site.desktop.member.finished_verify_error');
            }

            // return to sign in page
            return Redirect::to(App::getLocale().'/signin');

        }
        // if nothing to do redirect to home
        return Redirect::to(App::getLocale().'/');
    }

	public function profile() {
        $province = Province::all();
		$member = Member::find(Session::get('member.id'));
		// dd($member);
		if(!$member) {
			return Redirect::to(App::getLocale().'/');
		}

        $destination_url = Config::get('site.uploaded_url').Config::get('site.member_avatar_folder_name');

		return View::make('site.desktop.member.profile')
                ->with('member',$member)
                ->with('destination_url',$this->destination_url);
        // return View::make('site.desktop.member.profile');
	}
	
	public function takeProfile(){
		$id = Session::get('member.id');
		$member = Member::find($id);
		
        $inputs = Input::all();
        $validator = Validator::make(
            $inputs,
            array(
                'username'     => 'required|min:3|max:32|unique:members,username,'.$member->username.',username',
                'email'     => 'required|min:4|max:32|email'
            )
        );

        if ($validator->fails())
        {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
            return Redirect::to('profile')
                ->withInput()
                ->withErrors($validator);
        } else {
			$data['first_name'] = $inputs['first_name'];
            $data['last_name'] = $inputs['last_name'];
			$data['email'] = $inputs['email'];
            $data['username'] = $inputs['username'];

            $data['receive_newsletter'] = (Input::has('receive_newsletter')) ? 1 : 0;
            
            // $data['about_me'] = $inputs['about_me'];
            // $data['facebook_account'] = $inputs['facebook_account'];
            // $data['twitter_account'] = $inputs['twitter_account'];

            $data['phone'] = $inputs['phone'];
			$data['line_id'] = (Input::has('line_id')) ? $inputs['line_id'] : '';
			
			// if(isset($inputs['public_email'])) {
			// 	$data['public_email'] = 1;
			// }else {
			// 	$data['public_email'] = 0;
			// }
			$member->update($data);
            Notification::success('Profile updated');
            return Redirect::to('profile');
        }
		
	}

    public function address() {
        $province = Province::all();
        $member = Member::find(Session::get('member.id'));
        if(!$member) {
            return Redirect::to(App::getLocale().'/');
        }
        return View::make('site.desktop.member.address')
                ->with('member',$member)
                ->with('province_dropdown',$province);
    }
    
    public function takeAddress(){
        $id = Session::get('member.id');
        $member = Member::find($id);
        
        $inputs = Input::all();

        $validator = Validator::make(
            $inputs,
            array(
                //'email'   => 'required|min:4|max:32|email|unique:members,email,'.$id
                // 'email'     => 'required|min:4|max:32|email'
            )
        );

        if ($validator->fails())
        {
            Notification::warning('Something wrong, please contact admin');
            return Redirect::to('profile')
                ->withInput()
                ->withErrors($validator);
        } else {      


            // check if select use current location
            if(isset($inputs['use_current_location'])) {
                $lat = $inputs['lat'];
                $lon = $inputs['lng'];
                $geo = $this->geoFromLatLon($lat, $lon);
                $data['province_id'] = 0;
                $data['amphur_id'] = 0;
                $data['district_id'] = 0;
                // $data['zipcode_id'] = 0;
            } else {
                $address = $inputs['address'];
                $geo = $this->geoFromAddress($address);
                $data['province_id'] = $inputs['province'];
                $data['amphur_id'] = $inputs['amphur'];
                $data['district_id'] = $inputs['district'];
                // $data['zipcode_id'] = $inputs['zipcode'];
            }

            // Here is the mapping:
            // Street Number: %n
            // Street Name: %S
            // City: %L
            // City District: %D
            // Zipcode: %z
            // County: %P
            // County Code: %p
            // Region: %R
            // Region Code: %r
            // Country: %C
            // Country Code: %c
            // Timezone: %T

            // $formatter = new \Geocoder\Formatter\Formatter($geo);
            // dd($formatter->format('%S %n %z %L'));

            $data['latitude'] = $geo->getLatitude();
            $data['longitude'] = $geo->getLongitude();

            $data['address'] = '';

            if ($geo->getCityDistrict()) {
                $data['address'] .= ' '.$geo->getCityDistrict();
            }
            if ($geo->getCity()) {
                $data['address'] .= ' '.$geo->getCity();
            }
            if ($geo->getZipcode() ) {
                $data['address'] .= ' '.$geo->getZipcode() ;
            }
            if ($geo->getCountry()) {
                $data['address'] .= ' '.$geo->getCountry();
            }

            $member->update($data);
            Notification::success('Profile address updated');

            return Redirect::to('address');
        }
        
    }


	public function resetPassword() {
        $province = Province::all();
		$member = Member::find(Session::get('member.id'));
		// dd($member);
		if(!$member) {
			return Redirect::to(App::getLocale().'/');
		}
		
		return View::make('site.desktop.member.resetpassword');
	}
	
	public function password(){
		// dd('');
		$member = Member::find(Session::get('member.id'));
		
        $inputs = Input::all();
		$inputs['password_current'] = md5($inputs['password_current']);

        //dd($inputs);


        $validator = Validator::make(
            $inputs,
            array(
				'password_current' => 'required|min:3|exists:members,password',
                'password' 	=> 'required|min:3|confirmed',
				'password_confirmation' => 'required'
            )
        );

        if ($validator->fails())
        {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
            return Redirect::to(App::getLocale().'/password')
                ->withInput()
                ->withErrors($validator);
        } else {
			
			$data['password'] = md5($inputs['password']);
			
			$success = $member->update($data);
			Notification::success('New password saved');
            return View::make('site.desktop.member.resetpassword')
                ->with('data',$member);

        }
		
	}
	
    public function fileThumbnail()
    {
        $file_input_name = 'thumbnail';
        $id = Input::get('id');
        $file = Input::file($file_input_name);

        $img_folder_url = $this->destination_url.$id.'/';
        $img_folder_path = $this->destination_path.$id.'/';
        
        // Prepare folder for store all images
        $this->makeDirectory($img_folder_path);

        if (Input::hasFile($file_input_name))
        {
            $filesize = $file->getSize();
            $filename = Carbon::now()->timestamp . '.' . Input::file($file_input_name)->guessExtension();

            // Save original file
            $file->move($img_folder_path, $filename);

            // resize image process
            $img_size = $this->imagesize;
            if(is_array($img_size) && !empty($img_size))
            foreach ($img_size as $key => $value) {
                $size = $value;
                $this->resizeImage($img_folder_path.$filename, $img_folder_path.$size.'-'.$filename, $size);
            }

            // Save thumbnail to db
            $member = Member::find($id);
            $member->update(array(
                'avatar' => $filename
            ));

            // update session
            Session::put('member.avatar', $member->avatar);

            $thumbnail_url = $img_folder_url . sprintf($this->pattern_thumb, $this->avatar_thumb_size, $filename);
            $original_url = $img_folder_url . $filename;
            $results = array(
                'name'          => $filename,
                'thumbnailUrl'  => $thumbnail_url,
                'url'           => $original_url,
                'size'          => $filesize,
                'deleteType'    =>'get',
                'deleteUrl'     => URL::to('profile/delete-thumbnail/'.$id)
            );
            $res[] = $results;
            return array('files'=>$res);
        }else {
            $res[] = ['error'=>true];
            return array('files'=>$res);
        }
    }

	public function mysearch()
    {
		$id = Session::get('member.id');

        if (!isset($id) || !($id > 0)) {
            return Redirect::to(App::getLocale().'/signin');
        }

		$member = Member::find($id);
		if(!$member) {
			return Redirect::to(App::getLocale().'/');
		}
		
		$search = SaveSearch::where('member_id','=',$id)->paginate(8);
		
		
		
		foreach($search as $s) {
			// $ids = explode(',',$s->result_ids);
// 			$post = Post::find($ids[0]);
			// $s->post = $post;
			$make = CarbaseMake::find($s->car_make);
			$s->strMake = $make->make;
			
			// echo ($s->car_model);
			if($s->car_model !='') {
				$model = CarbaseModel::find($s->car_model);
				$s->strModel = $model->model;
			}else {
				$s->strModel = '';
			}
		}
		// // echo "<pre>";
		// dd($data->count());
		// Debugbar::info('mysearch',$data);
        return View::make('site.desktop.member.mysearch',array('search'=>$search));


        // $order = 'desc';
       //  $posts = Post::select('posts.*','posts_languages.title as title', 'posts_languages.description as description')
       //          ->join('posts_languages', 'posts_languages.post_id', '=', 'posts.id')
       //          ->where('status', '!=', $this->status['deleted'])
       //          ->groupby('posts_languages.post_id')
       //          ->with('post_by')
       //          ->orderBy('posts.created_at', 'desc')
       //          ->paginate(6);
       //  $this->data['posts'] = $posts;
       //
       //  Debugbar::info($this->data['posts']);

        return View::make('site.desktop.member.mysearch');
	}
	public function removesearch($id){
		$search = SaveSearch::find($id);
		$search->delete();
		
		return Redirect::to(App::getLocale().'/mysearch');
		
	}
}
