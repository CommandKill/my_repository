<?php
class EmailTemplateController extends AdminController 
{
	var $item_per_page = 100;

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Email Templates';
	}

   public function getIndex()
    {
        $languages = Language::all();
        $list = EmailTemplate::paginate(15);
        return View::make('admin.email-template.index',array(
                'list'      => $list,
                'languages' => $languages
            )
        );
    }
	
	public function postStore()
    {
        $inputs = Input::all();
        //echo '<pre>';dd($inputs);
        $rules = array();

        $languages = Language::all();
        foreach($languages as $lang) {
            $rules['key'] = 'required';
        }

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $email_template = EmailTemplate::create(array(
                'status'        => 1,
                'key'           => $inputs['key'],
                'created_by'    => Sentry::getUser()->id
            ));

            $lastinsert_id = $email_template->id;

            foreach($languages as $lang) {
                EmailTemplateLanguage::create(array(
                    'email_template_id'     => $lastinsert_id,
                    'subject'               => '',
                    'language_id'           => $lang->id
                ));
            }

            Notification::success('The email template was saved.');

            return Redirect::to('admin/email-template/edit/'.$lastinsert_id);
        }

        return Redirect::back()->withInput()->withErrors($validator);
	}
	
	public function getEdit($id)
    {
        $language = Language::all();
        $em = EmailTemplate::where('id',$id)->with('created_by')->with('updated_by')->first();

		return View::make('admin.email-template.edit', array(
                'em'        => $em,
                'languages' => $language
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
            $em = EmailTemplate::find($inputs['id']);
            $em->updated_by = Sentry::getUser()->id;
            $em->key = $inputs['key'];
            $success = $em->update();

            if($success) {
                foreach($languages as $lang){
                    if (Input::has('title_'.$lang->short_code))
                    {
                        $email_template_content = array(
                            'subject'       => $inputs['title_'.$lang->short_code],
                            'template'      => $inputs['template_'.$lang->short_code]
                        );
                        $success = EmailTemplateLanguage::where('email_template_id','=',$inputs['id'])
                            ->where('language_id','=',$lang->id)
                            ->update($email_template_content);
                        if ($success) {
                            $arr['status'] = 'Update Completed!';
                        }
                    }
                }
            }
        } else {

        }

        return Redirect::to('admin/email-template/edit/'.$inputs['id']);
	}
	
	public function getDestroy($id){
		$lang = EmailTemplate::destroy($id);
		
		return Redirect::to('admin/email-template');
		
	}
}	
?>