<?php
return array(
 
    'driver' => 'smtp',
 
    'host' => 'smtp.gmail.com',
 
    'port' => 587,
 
    'from' => array('address' => getenv('ADMIN_EMAIL'), 'name' => getenv('ADMIN_NAME')),
 
    'encryption' => 'tls',
 
    'username' => getenv('EMAIL_USER'),
 
    'password' => getenv('EMAIL_PWD'),
 
    'sendmail' => '/usr/sbin/sendmail -bs',
 
    'pretend' => false,
 
);