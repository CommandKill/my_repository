<?php
class SubscriberController extends AdminController 
{
	var $item_per_page = 100;

	public function __construct()
	{
		parent::__construct();
	}

    public function getIndex()
    {
        $this->data['title'] = 'Site subscribers';
        $this->data['description'] = '';

        $email = Input::get('email','');
        $subscribers = Subscriber::select('*')->where('status', '<>', $this->status['deleted']);
        if($email!='') {
            $subscribers = $subscribers->where('email', 'LIKE', "%$email%");
        }
		$subscribers = $subscribers->orderBy('created_at', 'desc')->paginate($this->item_per_page);


        if($subscribers->count() > 0) {
            $this->data['subscribers'] = $subscribers;
            $this->data['pagination'] = $subscribers->appends(array('email' => $email))->links();
        } else {
            $this->data['subscribers'] = false;
        }


		return View::make('admin.subscriber.index');
    }

    public function postStore()
    {
        $inputs = Input::all();
        $rules = array();
        $rules['email'] = 'required';

        $validator = Validator::make($inputs, $rules);

        if ( ! $validator->fails())
        {
            $p = Subscriber::create(array(
                'email' => $inputs['email']
            ));
            $lastinsert_id = $p->id;

            Notification::success('The subscribers was saved.');
            return Redirect::to('admin/subscriber');
        } else {
            foreach ($validator->messages()->toArray() as $key => $value) {
                Notification::warning($value);
            }
        }

        return Redirect::back()->withInput()->withErrors($validator);
    }

    public function getRemove($s_id)
    {
        $s = Subscriber::find($s_id);
        $s->delete();

        Notification::success('The subscribers was deleted.');

        return Redirect::to('admin/subscriber');
    }
}	
?>