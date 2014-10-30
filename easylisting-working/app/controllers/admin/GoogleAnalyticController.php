<?php

use Gapi\Gapi;

class GoogleAnalyticController extends AdminController {

	var $ga;
	var $profile_id;

    public function __construct()
    {
        parent::__construct();

        $this->ga = new Gapi(getenv('EMAIL_USER'), getenv('EMAIL_PWD'));
        $this->profile_id = getenv('GOOGLE_ANALYTIC_PROFILE');
    }

    public function getIndex()
    {
        return View::make('admin.google-analytic.index');
    }

    public function getReport()
    {
		
        $this->ga->requestReportData(
            $this->profile_id,
            array('browser','browserVersion'),
            array('pageviews','visits'
        ));

        return View::make('admin.google-analytic.report')
                ->with('ga', $this->ga);
    }

    public function getFilter()
    {
		/**
         * Note: OR || operators are calculated first, before AND &&.
         * There are no brackets () for precedence and no quotes are
         * required around parameters.
         *
         * Do not use brackets () for precedence, these are only valid for
         * use in regular expressions operators!
         *
         * The below filter represented in normal PHP logic would be:
         * country == 'United States' && ( browser == 'Firefox || browser == 'Chrome')
         */

        $filter = 'country == United States && browser == Firefox || browser == Chrome';

        $this->ga->requestReportData($this->profile_id, 
            array('browser','browserVersion'),
            array('pageviews','visits'), '-visits', $filter);


        return View::make('admin.google-analytic.report')
                ->with('ga', $this->ga);
    }

    public function getAccount()
    {
        $this->ga->requestAccountData();

        foreach($this->ga->getResults() as $result){
            echo "<br />";
            echo $result . ' (' . $result->getProfileId() . ") \r\n";
        }
        echo "\r\n";
    }

    public function getTokenStorage()
    {
		$this->ga = new Gapi(getenv('EMAIL_USER'), getenv('EMAIL_PWD'), isset($_SESSION['ga_auth_token'])?$_SESSION['ga_auth_token']:null);

        $_SESSION['ga_auth_token'] = $this->ga->getAuthToken();

        echo 'Token: ' . $_SESSION['ga_auth_token'];
    }
    
}