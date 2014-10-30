<?php
class PackageController extends ContentController 
{
	var $item_per_page = 100;

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Listing Packages';
	}

   public function getIndex()
    {
        $languages = Language::all();
        $list = Package::with('lang')->paginate(15);

        $status = Config::get('site.status');

        return View::make('admin.package.index',array(
                'list'      => $list,
                'languages' => $languages,
                'status'    => $status
            )
        );
    }

    public function postStore()
    {
        $inputs = Input::all();
        $rules = array();

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['title_'.$lang->short_code] = 'required';
        }

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $now = new DateTime;
            $package = Package::create(array(
                'status'        => $this->status['inactive'],
                'created_by'    => Sentry::getUser()->id,
                'available_from'=> $now,
                'available_to'  => $now
            ));
            $lastinsert_id = $package->id;

            foreach($languages as $lang) {
                PackageLanguage::create(array(
                    'package_id' => $lastinsert_id,
                    'name'             => $inputs['title_'.$lang->short_code],
                    'language_id'       => $lang->id
                ));
            }

            Notification::success('The package was saved.');

            return Redirect::to('admin/package/edit/'.$lastinsert_id);
        }

        return Redirect::back()->withInput()->withErrors($validator);
	}

    public function postOptionStore()
    {
        $inputs = Input::all();
        $rules = array();

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['option_'.$lang->short_code] = 'required';
            $rules['value_'.$lang->short_code] = 'required';
        }

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $package_id = $inputs['package_id'];
            foreach($languages as $lang) {
                PackageDetail::create(array(
                    'package_id'    => $package_id,
                    'name'          => $inputs['option_'.$lang->short_code],
                    'value'         => $inputs['value_'.$lang->short_code],
                    'language_id'   => $lang->id
                ));
            }

            Notification::success('The package option was saved.');

            return Redirect::to('admin/package/edit/'.$package_id);
        }

        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function getEdit($id)
    {
        $language = Language::all();
        $package = Package::where('id',$id)
                    ->with('lang')
                    ->with('created_by')
                    ->with('updated_by')->first();

        //Debugbar::info($package->detail);

        return View::make('admin.package.edit', array(
                'package'       => $package,
                'languages'     => $language
            )
        );
    }

    public function postUpdate()
    {
        $inputs = Input::all();
        $rules = array();
        $arr['status'] = 'Update Failed';

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['title_'.$lang->short_code] = 'required';
        }

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $package_id = $inputs['id'];
            $package = Package::where('id', '=', $package_id)->with('detail')->with('data')->first();
            $package->updated_by = Sentry::getUser()->id;
            $package->price = $inputs['price'];

            $available  = explode(" - ",$inputs['available_period']);
            $package->available_from = trim($available[0]);
            $package->available_to = trim($available[1]);

            $package->maximum_administer = $inputs['maximum_administer'];
            $package->member_type = $inputs['member_type'];
            $package->status = $inputs['status'];
            $success = $package->save();

            if($success) {

                foreach($languages as $lang){

                    // Data
                    if (Input::has('title_'.$lang->short_code))
                    {
                        $package_data = array(
                            'name' => $inputs['title_'.$lang->short_code]
                        );

                        PackageLanguage::where('package_id','=',$package_id)
                            ->where('language_id','=',$lang->id)
                            ->update($package_data);
                    }

                    // Detail
                    foreach ($package->detail as $key => $value) {
                        if (Input::has('option_'.$lang->short_code.'_'.$value->id) 
                            && Input::has('value_'.$lang->short_code.'_'.$value->id) )
                        {
                            $package_detail = array(
                                'name' => $inputs['option_'.$lang->short_code.'_'.$value->id],
                                'value' => $inputs['value_'.$lang->short_code.'_'.$value->id]
                            );

                            PackageDetail::where('id','=',$value->id)
                                ->where('language_id','=',$lang->id)
                                ->update($package_detail);
                        }                        
                    }

                    if ($success) {
                        $arr['status'] = 'Update Completed!';
                    }
                }
            }

            Notification::success('The package was saved.');

            return Redirect::to('admin/package/edit/'.$package_id);
        }

        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function getDestroy($package_id)
    {
        $package = Package::find($package_id);

        PackageLanguage::where('package_id', '=', $package->id)->delete();
        PackageDetail::where('package_id', '=', $package->id)->delete();

        Package::destroy($package_id);
        
        return Redirect::to('admin/package');
        
    }
}	
?>