<?php

class AdminMemberController extends AdminController {

    var $item_per_page = 10;

    public function __construct()
    {
        parent::__construct();

        $this->data['title'] = 'Members';
    }

    public function getIndex()
    {
        // $this->data['title'] = 'Members';
        $this->data['description'] = '';

        $email = Input::get('email','');
        $member = Member::select('*')->where('status', '<>', $this->status['deleted']);
        if($email!='') {
            $subscribers = $member->where('email', 'LIKE', "%$email%");
        }
        $member = $member->orderBy('created_at', 'desc')->paginate($this->item_per_page);

        if($member->count() > 0) {
            $this->data['member'] = $member;
            $this->data['pagination'] = $member->appends(array('email' => $email))->links();
        } else {
            $this->data['subscribers'] = false;
        }

//        $list = Member::all();
        
        return View::make('admin.member.index');
    }


    public function getEdit($id)
    {
        $member = Member::where('id',$id)->first();
        $province = Province::all();

        $destination_url = Config::get('site.uploaded_url').Config::get('site.member_avatar_folder_name');
        $avatar_sizes = Config::get('site.member_avatar_images_size');
        $avatar_image_size = $avatar_sizes[Config::get('site.index_member_avatar_large_size')];
        $avatar_prefix = Config::get('site.member_avatar_prefix');

        return View::make('admin.member.edit')
            ->with('member', $member)
            ->with('province_dropdown', $province)
            ->with('destination_url', $destination_url)
            ->with('avatar_image_size', $avatar_image_size);
    }

    public function postUpdate()
    {
        $inputs = Input::all();
        $id = $inputs['id'];
        $validator = Validator::make(
            $inputs,
            array(
                'first_name'=> 'alpha',
                'last_name' => 'alpha'
            )
        );

        if ($validator->fails())
        {
            return Redirect::to('admin/member/edit/'.$id)
                ->withInput()
                ->withErrors($validator);
        } else {

            $member = Member::find($id);
            $member->first_name = $inputs['first_name'];
            $member->last_name = $inputs['last_name'];
            $member->phone = $inputs['phone'];
            $member->latitude = $inputs['lat'];
            $member->status = $inputs['status'];
            $member->longitude = $inputs['lng'];
            $member->address = $inputs['address'];
            $member->province_id = $inputs['province'];
            $member->amphur_id = $inputs['amphur'];
            $member->district_id = $inputs['district'];
            $member->zipcode_id = $inputs['zipcode'];

            $status =  ($member->update()) ? "Update success" : "Update failed";
        
            return json_encode( array('status'=> $status));

            // Session::flash('success', 'Member updated.');
            // return Redirect::to('admin/member/edit/'.$id);
        }
    }

    public function postFileThumbnail()
    {
        $id = Input::get('id');
        $file = Input::file('thumbnail');

        $imagesize = Config::get('site.user_avatar_images_size');
        $index_size = Config::get('site.index_member_avatar_large_size');
        $destination_url = Config::get('site.uploaded_url').Config::get('site.member_avatar_folder_name');
        $destination_path = Config::get('site.uploaded_path').Config::get('site.member_avatar_folder_name');
        $avatar_prefix = Config::get('site.member_avatar_prefix');

        $member = Member::find($id);

        if(!File::exists($destination_path.$id)) {
            File::makeDirectory($destination_path.$id, 0775, true, true);
            //File::makeDirectory($destination_path, $mode = 0777, true, true);
        }

        $data['avatar'] = $file->getClientOriginalName();

        if (Input::hasFile('thumbnail'))
        {
            foreach($imagesize as $size) {
                $filename = $size.'_'.$file->getClientOriginalName();
                $oldfile = $size.'_'.$member->avatar;

                File::delete($destination_path.$id.'/'.$oldfile);

                list($w,$h) = explode('x', $size);

                Image::make($file->getRealPath())
                    ->resize($w,$h,function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->save($destination_path.$id.'/'.$filename);
            }
            
            File::delete($destination_path.$id.'/'.$member->avatar);
            Input::file('thumbnail')->move($destination_path.$id.'/', $data['avatar']);

            $member->update($data);



            $results = array(
                'name'          => $file->getClientOriginalName(),
                'thumbnailUrl'  => $destination_url.$id.'/'.$imagesize[$index_size].'_'.$file->getClientOriginalName(),
                'url'           => $destination_url.$file->getClientOriginalName(),
                'size'          => $imagesize,
                'deleteType'    =>'get',
                'deleteUrl'     => URL::to('admin/member/delete-thumbnail').'/'.$id
            );
            $res[] = $results;
            return array('files'=>$res);
        }else {
            $res[] = ['error'=>true];
            return array('files'=>$res);
        }
    }

}