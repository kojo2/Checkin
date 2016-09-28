<?php
	class Checkin extends CI_Controller {
		function index(){
			if(!$this->session->userdata('userId')){
				redirect('welcome');
			}
			$this->load->view('headerStaff');
			$this->load->view("checkin",$this->session->userdata);
		}

		function getJobsForUserId(){
			$this->load->model("jobSessions");
			$this->load->helper('date');
			$datestring = "%Y%m%d";
			//commented out the automatic date select for testing purposes
			$date = mdate($datestring);
			//$date = "2016-03-01";
			$results = $this->jobSessions->getJobsForUserId($this->session->userdata('userId'),$date);
			$earliestTime ="24:00";
			$latestTime = "";
			//find the time limits
			foreach ($results as $r) {
				if($r->timeIn<$earliestTime){
					$earliestTime=$r->timeIn;
				}
				if($r->timeIn>$latestTime){
					$latestTime = $r->timeIn;
				}
				if($r->timeOut<$earliestTime){
					$earliestTime=$r->timeOut;
				}
				if($r->timeOut>$latestTime){
					$latestTime = $r->timeOut;
				}
			}
			//echo("earliest time: ".$earliestTime);
			//echo("latest time: ".$latestTime);
			//find the time between the limits (so we can use that as our timeline;
			$timeBetween = ($latestTime-$earliestTime);
			//echo("time between: ".$timeBetween." ");
			foreach ($results as $r) {
				$visibility = "";
				$hours = $r->timeOut-$r->timeIn;
				$timeInA = explode(":",$r->timeIn);
				$timeIn = $timeInA[0].":".$timeInA[1];
				$timeOutA = explode(":",$r->timeOut);
				$timeOut = $timeOutA[0].":".$timeOutA[1];
				//$perc=  (($hours/$timeBetween)*96);
				//$perc = ((92/$timeBetween)*$hours);
				$perc = ((98/12)*($hours));
				//$left = (((12+6)/$r->timeIn)*92);
				$colorPart1 = mt_rand( 0, 255 );
				$colorPart2 = mt_rand( 0, 255 );
				$colorPart3 = mt_rand( 0, 255 );
				$color = $colorPart1.",".$colorPart2.",".$colorPart3.","."0.2";
				$left = ((98/12)*($r->timeIn-6));
				//$left = (((92/$timeBetween)*($timeIn-6))+1)."%";
				//$right = ((($r->timeOut-6)/$timeBetween)*100)."%";
				//$left=($earliestTime-$timeIn*100)."%";
				if($left<=1){$left=2;}
				//$left = 1;
				//echo $left;
				//echo $timeIn.": ".$left;
				if($perc<1){$perc=(98/12);}
				if(strlen($r->comments)){
					if($perc<strlen($r->comments)){
						$comments=mb_substr($r->comments,0,$perc)."...<br>";
					}else{
						$comments = $r->comments."<br>";
					}
				}else{
					$comments="";
				}
				if($perc<5){
					$visibility = "invisible";
				}
				echo("<a href='#' class='aJobs'><li class='jobSession' style='width:".$perc."% ; left:".$left."% ; background-color:rgba(".$color.")'><span class='darker'>".$r->jobcode."</span> <br>".$timeIn." - ".$timeOut."<br><span class='".$visibility."'>".$comments.$hours." hours</span><br><span class='invisible'>**".$r->id."</span></li></a>");
			}

		}

		function deleteJob($jobcode){
			$this->load->model('jobSessions');
			$this->jobSessions->deleteById($jobcode);
			//if a job is deleted then we must set the other job back to full day
			redirect('CheckinSubmit/resetJobs');
		}

		

	}


