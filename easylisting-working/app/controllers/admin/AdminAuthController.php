<?php

class AdmAuthController extends BaseController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getSignin()
    {
        View::share('html_page', array(
            'title'			=> 'Dashboard',
            'description'	=> ''
        ));

        return View::make('admin.auth.login');
    }

    public function postSignin()
    {
        //dd(Input::all());


        $input = Input::all();

        $credentials = array(
            'email'    => $input['email'],
            'password' => $input['password']
        );

        $validator = Validator::make(
            $credentials,
            array(
                'email'     => 'required|min:4|max:32|email',
                'password'  => 'required|min:3'
            )
        );

        if ($validator->fails())
        {
            return Redirect::to('admin/auth/signin')
                ->withInput()
                ->withErrors($validator);
        } else {
            try
            {
                $remember_me = isset($input['remember_me']) ? true : false;
                $user = Sentry::authenticate($credentials, $remember_me);
                if ($user)
                {
                    Event::fire('auth.login', $user);

                    return Redirect::to('admin');
                }
            }
            catch(\Exception $e)
            {
                return Redirect::to('admin/auth/signin')
                ->withInput()
                ->withErrors(array('login' => $e->getMessage()));
            }
        }
    }

	public function getSignout()
	{
		Sentry::logout();

		Event::fire('auth.logout');

		return Redirect::to('admin/auth/signin');
	}

    public function getForgotPassword()
    {
        return View::make('admin.auth.forgotpwd');
    }

    public function postForgotPassword()
    {
        $input = Input::all();

        //dd($input);

        $validator = Validator::make(
            array('email'=> $input['email']),
            array('email' => 'required|min:4|max:32|email|Exists:users,email')
        );

        if ($validator->fails())
        {
            return Redirect::to('admin/auth/forgotpassword')
                ->withInput()
                ->withErrors($validator);
        } else {
            //send link for reset new password to this email
            Mail::send('emails.auth.reminder', array(), function($message) use ($input)
            {
                $message->to($input['email'], $input['email'])
                    ->subject(Lang::get('admin.email_forgotpwd_subject'))
                    ->from(getenv('ADMIN_EMAIL'), getenv('ADMIN_NAME'));
            });

            return Redirect::to('admin/auth/forgotpassword')
                ->withInput()
                ->with('message', Lang::get('admin.message_sent_email_success', array('email'=>$input['email'])));
        }
    }
}