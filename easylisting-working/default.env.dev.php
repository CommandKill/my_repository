<?php

return array(

  /*
  |--------------------------------------------------------------------------
  | !!! note: rename this file to
  |--------------------------------------------------------------------------
  |
  | 'dev'       => .env.dev.php
  | 'production'    => .env.php
  | 'staging'     => .env.staging.php
  |
  */

    'DB_HOST'               => '127.0.0.1',
    'DB_NAME'               => 'easylisting2',
    'DB_USER'               => 'root',
    'DB_PASSWORD'           => '',
    'EMAIL_USER'            => 'nichapon@easylisting.com', // use with send email via gmail account for test
    'EMAIL_PWD'             => 'nugt2526', // use with send email via gmail account for test
    'GOOGLE_ANALYTIC_PROFILE' => '58813755', // for sample satanyfashion
    'ADMIN_NAME'            => 'Tian',
    'ADMIN_EMAIL'           => 'nichapon@easylisting.co.th',
    'FB_CLIENT_ID'          => '',
    'FB_CLIENT_SECRET'      => '',
    'REMOTE_HOST'           => '',
    'REMOTE_USERNAME'       => '',
    'REMOTE_PASSWORD'       => '',
    'REMOTE_KEY'            => '',
    'REMOTE_KEYPHRASE'      => '',
    'REMOTE_ROOT'           => '',
    'DOMAIN'                => 'www.easylisting2.com',
    'PREFIX_MOBILE'         => 'mobile',
    'MOBILE_DOMAIN'         => 'mobile.easylisting2.com',
    'PREFIX_DESKTOP_CLASS'  => 'Desktop',
    'PREFIX_MOBILE_CLASS'   => 'Mobile',
    'IS_PRODUCTION'         => false // if set to 'true' is access via domain, if 'false' is access via ip
);