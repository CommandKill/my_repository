<?php

use Gapi\Gapi;

class AdminHomepageController extends AdminController {

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {
        View::share('html_page', array(
            'title'         => 'Dashboard',
            'description'   => ''
        ));

        return View::make('admin.index')
                ->with('ga', false)
                ->with('sysinfo', array());
    }

    public function getTest()
    {
        dd('test');
    }

    public function getData()
    {
        View::share('html_page', array(
            'title'			=> 'Dashboard',
            'description'	=> ''
        ));

        // get sample google analytic data
        $profile_id = getenv('GOOGLE_ANALYTIC_PROFILE');
        $user = getenv('EMAIL_USER');
        $password = getenv('EMAIL_PWD');

        $ga = new Gapi($user, $password, Session::has('ga_auth_token')?Session::get('ga_auth_token'):null);
        Session::put('ga_auth_token', $ga->getAuthToken());
        $ga->requestReportData(
            $profile_id,
            array('browser','browserVersion'),
            array('pageviews','visits'
        ));

        // get sys information
        include app_path().'/libraries/linfo/func.php';
        include app_path().'/libraries/linfo/config.inc.php';

        $sysinfo = array();

        // Determine our OS
        $os = determineOS();

        // Cannot?
        if ($os == false)
            exit("Unknown/unsupported operating system\n");

        // Get info
        $getter = parseSystem($os, $settings);
        $sysinfo['info'] = $getter->getAll();

        $sysinfo['cpu_load ']= (int)ceil($sysinfo['info']['Load']['now']);
        $sysinfo['ram'] = (int)$sysinfo['ram'] = 100 - (100 / ($sysinfo['info']['RAM']['total'] / $sysinfo['info']['RAM']['free']));

        // list($time, $boot) = explode(';', $info['UpTime']);
        // list($hours, $minutes, $seconds) = explode(', ', $time);
        // $uptime = "$hours hours, $minutes minutes, $seconds seconds";

        $sysinfo['uptime'] = $sysinfo['boot'] = 0;

        Debugbar::info($sysinfo);

        return View::make('admin.index')
                ->with('ga', $ga)
                ->with('sysinfo', $sysinfo);
    }

}