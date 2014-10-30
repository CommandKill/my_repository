<?php
class UserController extends AdminController 
{
	var $item_per_page = 100;

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Users';
	}

	public function index()
	{
        $users = Sentry::findAllUsers();
        foreach ($users as $user) {

            if ($user->isActivated()) $user->status = "Active";
            else $user->status = "Not Active";

            //Pull Suspension & Ban info for this user
            $throttle = Sentry::getThrottleProvider()->findByUserId($user->id);

            if($throttle->isSuspended()) $user->status = "Suspended";

            if($throttle->isBanned()) $user->status = "Banned";
        }

        $destination_url = Config::get('site.uploaded_url').Config::get('site.user_avatar_folder_name');
        $avatar_sizes = Config::get('site.user_avatar_images_size');
        $avatar_image_size = $avatar_sizes[Config::get('site.index_user_avatar_small_size')];
        $avatar_prefix = Config::get('site.user_avatar_prefix');

        return View::make('admin.user.index')
                ->with('users', $users)
                ->with('avatar_url', $destination_url.$avatar_prefix.$avatar_image_size.'_');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $inputs = Input::all();
        try
        {
            $user = Sentry::register(array(
                'email'       => $inputs['email'],
                'password'    => $inputs['password'],
                'activated'   => $this->status['inactive']
            ));

            return Redirect::to('admin/users/'.$user->id.'/edit');
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            Session::flash('error', 'Login field is required.');
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            Session::flash('error', 'Password field is required.');
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            Session::flash('error', 'User with this login already exists.');
        }
        return Redirect::back()->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $user = Sentry::findUserById($id);
//        if($user == null || !is_numeric($id))
//        {
//            return \App::abort(404);
//        }

        return View::make('admin.user.show')->with('user', $user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $user = Sentry::findUserById($id);

        $permissions = Config::get('permission.keys');
        foreach ($permissions as $key => $value) {
            if (isset($user->permissions[$key])) {
                $permissions[$key] = 1;
            } else {
                $permissions[$key] = 0;
            }
        }

//        if($user == null || !is_numeric($id))
//        {
//            return \App::abort(404);
//        }

//        $user_group = Sentry::findAllGroups();


        $currentGroups = $user->getGroups()->toArray();

        $userGroups = array();
        foreach ($currentGroups as $group) {
            array_push($userGroups, $group['name']);
        }
        $allGroups = Sentry::findAllGroups();

        $destination_url = Config::get('site.uploaded_url').Config::get('site.user_avatar_folder_name');
        $avatar_sizes = Config::get('site.user_avatar_images_size');
        $avatar_image_size = $avatar_sizes[Config::get('site.index_user_avatar_large_size')];
        $avatar_prefix = Config::get('site.user_avatar_prefix');
        

        return View::make('admin.user.edit')
            ->with('user', $user)
            ->with('userGroups', $userGroups)
            ->with('allGroups', $allGroups)
            ->with('permissions', $permissions)
            ->with('avatar_url', $destination_url.$avatar_prefix.$avatar_image_size.'_');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
    {
//        if(!is_numeric($id))
//        {
//            return \App::abort(404);
//        }

        $inputs = Input::all();
        $validator = Validator::make(
            $inputs,
            array(
                'firstName'=> 'alpha',
                'lastName' => 'alpha'
            )
        );

        if ($validator->fails())
        {
            return Redirect::action('UserController@edit', array($id))
                ->withInput()
                ->withErrors($validator);
        } else {
            // save to db
            $result = array();

            // Find the user using the user id
            $user = Sentry::findUserById($id);

            // Update the user details
            $user->first_name = e($inputs['firstName']);
            $user->last_name = e($inputs['lastName']);

            $user->activated = $inputs['activated'];

            // TODO Only Admins should be able to change group memberships.
            // $operator = Sentry::getUser();
            // if ($operator->hasAccess('user'))
            // {
                // Update group memberships
                $allGroups = Sentry::getGroupProvider()->findAll();
                foreach ($allGroups as $group)
                {
                    if (isset($inputs['groups'][$group->id]))
                    {
                        //The user should be added to this group
                        $user->addGroup($group);
                    } else {
                        // The user should be removed from this group
                        $user->removeGroup($group);
                    }
                }
            // }

            $permissions = Config::get('permission.keys');
            $input_permission = isset($inputs['permission'])?$inputs['permission']:array();
            foreach ($permissions as $key => $value) {
                if (isset($input_permission[$key])) {
                    $permissions[$key] = 1;
                } else {
                    $permissions[$key] = 0;
                }
            }

            $user->permissions = $permissions;

            // Update the user
            if ($user->save())
            {
                $result['success'] = true;
                $result['message'] = trans('users.updated');
            }
            else
            {
                $result['success'] = false;
                $result['message'] = trans('users.notupdated');
            }

            Session::flash('success', $result['message']);
            return Redirect::action('UserController@index');
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
//        if(!is_numeric($id))
//        {
//            return \App::abort(404);
//        }

        // Find the user using the user id
        $user = Sentry::findUserById($id);
        if ($user->delete())
        {
            Session::flash('success', 'User Deleted');
            return Redirect::to('admin/users');
        }
        else
        {
            Session::flash('error', 'Unable to Delete User');
            return Redirect::to('admin/users');
        }
	}


    public function ban($id)
    {
//        if(!is_numeric($id))
//        {
//            return \App::abort(404);
//        }

        $result = array();
        $throttle = Sentry::findThrottlerByUserId($id);
        Debugbar::info($throttle);
        $throttle->ban();
        try
        {
            $result['success'] = true;
            $result['message'] = trans('users.banned');
            Session::flash('success', $result['message']);
        }
        catch (Exception $e)
        {
            $result['success'] = false;
            $result['message'] = trans('users.notfound');
            Session::flash('error', $result['message']);
        }

        return Redirect::to('admin/users');
    }

    public function unban($id)
    {
//        if(!is_numeric($id))
//        {
//            return \App::abort(404);
//        }

        $throttle = Sentry::findThrottlerByUserId($id);
        $throttle->unBan();
        try
        {
            $result['success'] = true;
            $result['message'] = trans('users.unbanned');
            Session::flash('success', $result['message']);
        }
        catch (Exception $e)
        {
            $result['success'] = false;
            $result['message'] = trans('users.notfound');
            Session::flash('error', $result['message']);
        }

        return Redirect::to('admin/users');
    }

    public function suspend($id)
    {
//        if(!is_numeric($id))
//        {
//            return \App::abort(404);
//        }
        $minutes = 2000;

        $result = array();
        $throttle = Sentry::findThrottlerByUserId($id);
        $throttle->setSuspensionTime($minutes);//$minutes
        $throttle->suspend();
        try
        {
            $result['success'] = true;
            $result['message'] = trans('users.suspended', array('minutes' => $minutes));
            Session::flash('success', $result['message']);
        }
        catch (Exception $e)
        {
            $result['success'] = false;
            $result['message'] = trans('users.notfound');
            Session::flash('error', $result['message']);
        }

        return Redirect::to('admin/users');
    }

    public function unsuspend($id)
    {
//        if(!is_numeric($id))
//        {
//            return \App::abort(404);
//        }

        $throttle = Sentry::findThrottlerByUserId($id);
        $throttle->unsuspend();
        try
        {
            $result['success'] = true;
            $result['message'] = trans('users.unsuspended');
            Session::flash('success', $result['message']);
        }
        catch (Exception $e)
        {
            $result['success'] = false;
            $result['message'] = trans('users.notfound');
            Session::flash('error', $result['message']);
        }

        return Redirect::to('admin/users');
    }

    public function fileThumbnail()
    {
        $id = Input::get('id');
        $file = Input::file('thumbnail');

        $imagesize = Config::get('site.user_avatar_images_size');
        $destination_url = Config::get('site.uploaded_url').Config::get('site.user_avatar_folder_name');
        $destination_path = Config::get('site.uploaded_path').Config::get('site.user_avatar_folder_name');
        $avatar_prefix = Config::get('site.user_avatar_prefix');

        $user = Sentry::findUserById($id);

        if(!File::exists($destination_path)) {
            File::makeDirectory($destination_path);
            //File::makeDirectory($destination_path, $mode = 0777, true, true);
        }

        $data['avatar'] = $file->getClientOriginalName();

        if (Input::hasFile('thumbnail'))
        {
            foreach($imagesize as $size) {
                $filename = $avatar_prefix.$size.'_'.$file->getClientOriginalName();
                $oldfile = $avatar_prefix.$size.'_'.$user->avatar;

                File::delete($destination_path.$oldfile);

                list($w,$h) = explode('x', $size);

                Image::make($file->getRealPath())
                    ->resize($w,$h,function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->save($destination_path.$filename);
            }
            
            File::delete($destination_path.$user->avatar);
            Input::file('thumbnail')->move($destination_path, $data['avatar']);

            $user->update($data);



            $results = array(
                'name'          => $file->getClientOriginalName(),
                'thumbnailUrl'  => $destination_url.$avatar_prefix.$imagesize[0].'_'.$file->getClientOriginalName(),
                'url'           => $destination_url.$file->getClientOriginalName(),
                'size'          => $imagesize,
                'deleteType'    =>'get',
                'deleteUrl'     => URL::to('admin/users/delete-thumbnail').'/'.$id
            );
            $res[] = $results;
            return array('files'=>$res);
        }else {
            $res[] = ['error'=>true];
            return array('files'=>$res);
        }
    }
}	
?>