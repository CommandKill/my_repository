<?php

class NewsletterSubscriptionController extends SiteController 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function subscribe()
    {
        $inputs = Input::all();
        $data = array();
        
        $status = false;
        $msg = '';
        $p = Subscriber::create(array(
            'email' => $inputs['email']
        ));
        $lastinsert_id = $p->id;

        if($p) {
            $msg = "Subscription Completed";
            $status = true;
        }else {
            $msg = "Subscription Failed";
        }

        return Response::json(array(
            'error' => false,
            'status' => $status,
            'msg' => $msg,
            'result' => ''),
            200
        );
    }
}