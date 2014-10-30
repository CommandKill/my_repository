<?php

setlocale(LC_MONETARY, 'en_GB');

return array(
    'cache_enable'  => false,
    'answer_type'   => array('text', 'radio', 'checkbox'), // <- this variable for answer in question in questionaire
    'member_type'       => array('dealer', 'individual'),
    'status'    =>  array(
        'inactive'  => 0,
        'active'    => 1,
        'lock'      => 2,
        'deleted'   => 3,
        'waiting'   => 4,
        'draft'     => 5
    ),
    'car_prefix_id' => 'CS',
    'car_img_root'  => public_path().'/uploaded/car',
    'member_root_path'  => public_path().'/uploaded/member',
    'member_root_url'  => URL::asset('/uploaded').'/member'

);