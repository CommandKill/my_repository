<?php

class StatsController extends AdminController
{
    var $item_per_page = 1;
    var $params;

	public function __construct()
	{
		parent::__construct();

		$this->data['title'] = 'Stats';
	}

    public function getUnapprovedListing()
    {
        $this->data['title'] = 'Unapproved listing';



        return View::make('admin.stats.unapproved-listing');
    }

    public function getAverageTimeWaitingApproved()
    {
        $this->data['title'] = 'Average time waiting approved';




        return View::make('admin.stats.average-time-waiting');
    }

    public function getLatestVisits()
    {
        $this->data['title'] = 'Latest visits';



        return View::make('admin.stats.latest-search');
    }

    public function getLatestSearchKeywords()
    {
        $this->data['title'] = '10 latest search keywords or string';


        
        return View::make('admin.stats.latest-search');
    }
}	
?>