<?php
class UserGroupController extends AdminController 
{
	var $item_per_page = 100;

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'User';
	}

    public function getIndex()
    {
    	$this->data['title'] .= '  Groups';
        $list = Sentry::findAllGroups();
        return View::make('admin.user.group-index')
        		->with('list', $list);
    }

    public function postStore()
    {
        $inputs = Input::all();
        $rules['group_name'] = 'required';
        $validator = Validator::make($inputs, $rules);
        if ( ! $validator->fails())
        {
            $group = Sentry::createGroup(array(
                'name'  => $inputs['group_name']
            ));

            return Redirect::to('admin/usergroup/edit/'.$group->id);
        }
        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function getEdit($id)
    {
        $user_group = Sentry::findGroupById($id);
        $permissions = Config::get('permission.keys');
        foreach ($permissions as $key => $value) {
            if (isset($user_group->permissions[$key])) {
                $permissions[$key] = 1;
            } else {
                $permissions[$key] = 0;
            }
        }

        return View::make('admin.user.group-edit')
                ->with('user_group', $user_group)
                ->with('permissions', $permissions);
    }

    public function postUpdate()
    {
        $inputs = Input::all();
        $rules['group_name'] = 'required';
        $validator = Validator::make($inputs, $rules);
        if ( ! $validator->fails())
        {
            $permissions = Config::get('permission.keys');
            $input_permission = $inputs['permission'];
            foreach ($permissions as $key => $value) {
                if (isset($input_permission[$key])) {
                    $permissions[$key] = 1;
                } else {
                    $permissions[$key] = 0;
                }
            }

            $id = $inputs['id'];
            $group = Sentry::findGroupById($id);
            $group->name = $inputs['group_name'];
            $group->permissions = $permissions;
            $success = $group->save();
            if ($success) {
                Notification::success('The user group was saved.');
            }
            return Redirect::to('admin/usergroup/edit/'.$id);
        }
        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function getDestroy($id)
    {
        // TODO:: update all user in this group to empty group id
        UserGroup::destroy($id);
        
        return Redirect::to('admin/usergroup');
        
    }
}	
?>