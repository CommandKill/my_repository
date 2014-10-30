<?php

class SettingsTableSeeder extends Seeder {

	public function run()
	{
        // input type for now supported 'editor' | 'text' | option

        Setting::truncate();

        //DB::table('settings')->delete();

        Setting::create(array(
            'key'       => 'site_config_questionaire_id_for_wizard',
            'value'     => '1',
            'autoload'  => 0,
            'module'    => 'wizard',
            'input_type'=> 'option',
            'input_custom'=> 'questionaireListing', // this will call emailTemplate function
            'alias'     => 'Questionaire for wizard',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_email_template_for_signup',
            'value'     => '1',
            'autoload'  => 0,
            'module'    => 'email',
            'input_type'=> 'option',
            'input_custom'=> 'emailTemplate', // this will call emailTemplate function
            'alias'     => 'Email tempalte for signup',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_email_template_for_signin',
            'value'     => '1',
            'autoload'  => 0,
            'module'    => 'email',
            'input_type'=> 'option',
            'input_custom'=> 'emailTemplate', // this will call emailTemplate function
            'alias'     => 'Email tempalte for signin',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_facebook_page',
            'value'     => 'http://www.facebook.com',
            'autoload'  => 1,
            'module'    => 'global',
            'input_type'=> 'text',
            'alias'     => 'Facebook page',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_twitter_page',
            'value'     => 'http://www.twiiter.com',
            'autoload'  => 1,
            'module'    => 'global',
            'input_type'=> 'text',
            'alias'     => 'Twitter account',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_address',
            'value'     => '*fill adreess*',
            'autoload'  => 1,
            'module'    => 'contact',
            'input_type'=> 'editor',
            'alias'     => 'Contact',
            'short_desc'=> '*fill company address this place'
        ));

        Setting::create(array(
            'key'       => 'site_config_youtube_channel',
            'value'     => 'http://youtube.com',
            'autoload'  => 1,
            'module'    => 'global',
            'input_type'=> 'text',
            'alias'     => 'Youtube channel',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_google_plus',
            'value'     => 'http://plus.google.com/',
            'autoload'  => 1,
            'module'    => 'global',
            'input_type'=> 'text',
            'alias'     => 'Google plus',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_support_email',
            'value'     => 'nattapong.kongmun@gmail.com',
            'autoload'  => 1,
            'module'    => 'global',
            'input_type'=> 'text',
            'alias'     => 'Support email',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_site_name',
            'value'     => 'Easycar',
            'autoload'  => 1,
            'module'    => 'global',
            'input_type'=> 'text',
            'alias'     => 'Site name',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_copyright',
            'value'     => '© Company Limited 2014',
            'autoload'  => 1,
            'module'    => 'global',
            'input_type'=> 'text',
            'alias'     => 'Copyright',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_hotline',
            'value'     => '+66 8 6301 9559',
            'autoload'  => 1,
            'module'    => 'global',
            'input_type'=> 'text',
            'alias'     => 'Hotline',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_aboutus',
            'value'     => '+66 8 6301 9559',
            'autoload'  => 1,
            'module'    => 'global',
            'input_type'=> 'editor',
            'alias'     => 'About us',
            'short_desc'=> ''
        ));

        Setting::create(array(
            'key'       => 'site_config_questionaire_for_wizard',
            'value'     => '+66 8 6301 9559',
            'autoload'  => 1,
            'module'    => 'global',
            'input_type'=> 'text',
            'alias'     => 'Hotline',
            'short_desc'=> ''
        ));
        // Setting::create(array(
        //     'key'       => 'site_config_questionaire_for_wizard',
        //     'value'     => '',
        //     'autoload'  => 0,
        //     'module'    => 'wizard',
        //     'input_type'=> 'option',
        //     'input_custom'=> 'questionaire', // this will call emailTemplate function
        //     'alias'     => 'Questionaire for signin',
        //     'short_desc'=> ''
        // ));
	}

}