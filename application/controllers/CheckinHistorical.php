<?php

class CheckinHistorical extends CI_Controller {

	function index(){
		$this->load->view('headerStaff');
		//get monday
		$monday = $this->getWeekDates(date("Y"),date("W"),true);
		//get today
		$today = date("Y-m-d");
		//get days inbetween
		$dates = $this->createDateRangeArray($monday,$today);
		//add them to an array
		$params = array('monday'=>$monday,'today'=>$today,'dates'=>$dates,'userId'=>$this->session->userdata('userId'), 'fname'=>$this->session->userdata('fname'));
		$this->load->view('checkinHistorical',$params);
	}

	function getWeekDates($year, $week, $start=true)
	{
			$from = date("Y-m-d", strtotime("{$year}-W{$week}-1")); //Returns the date of monday in week
		$to = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week

		if($start) {
    		return $from;
		} else {
    		return $to;
		}
//return "Week {$week} in {$year} is from {$from} to {$to}.";
	}

	function createDateRangeArray($strDateFrom,$strDateTo)
	{
	    // takes two dates formatted as YYYY-MM-DD and creates an
	    // inclusive array of the dates between the from and to dates.

	    // could test validity of dates here but I'm already doing
	    // that in the main script

	    $aryRange=array();

	    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

	    if ($iDateTo>=$iDateFrom)
	    {
	        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	        while ($iDateFrom<$iDateTo)
	        {
	            $iDateFrom+=86400; // add 24 hours
	            array_push($aryRange,date('Y-m-d',$iDateFrom));
	        }
	    }
	    //remove today from the list of dates
	    array_pop($aryRange);
	    return $aryRange;
	}

}