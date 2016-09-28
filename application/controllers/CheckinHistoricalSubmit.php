<?php
	class CheckinHistoricalSubmit extends CI_Controller {
		function index(){
			//check the data to see if the dates are within the limits
					
			//old code
			if(!$this->session->userdata('userId')){
				redirect('welcome');
			}
			$this->load->model('jobSessions');
			$this->load->model('joblist');
			$this->load->model("Users");
			$p = $this->input->post();
			if(!$p){
				echo "<script>
					alert('You have already registered this job for today!');
					window.location.href='".base_url('index.php/checkin')."';
				</script>";
			}
			$userId=$this->session->userdata('userId');
			//find the current daily rate for this staff member
			$user = $this->Users->findUserById($userId);
			$dailyRate = $user[0]->dailyRate;
			$this->load->helper('date');
			$datestring = "%Y%m%d";
			//YYYY-MM-DD
			//$time = time();
			//this is where the date is set automatically - this is temporarily commented out so we can test with fake dates
			//$date = mdate($datestring);
			$date = $p['date'];
			//explode the date and reformat it in a mysql friendly way
			$dateA = explode("-",$date);
			$date = $dateA[2]."-".$dateA[1]."-".$dateA[0];
			//remove the annoying space generated by previous split
			$dateA = explode(" ",$date);
			$date = $dateA[0].$dateA[1];
			//$date = "2016-03-01";
			$job = $p['job'];
			$explodedJob = explode(" ",$job);
			$jobId = $explodedJob[0];
			$from = $p['fromhours'].":".$p['fromminutes'];
			$to = $p['tohours'].":".$p['tominutes'];
			if(strlen($p['comments'])>1000){
				$comments = "Comment was too long";
			}else{
				$comments = $p['comments'];
			}
			//check if jobcode already exists for this day, if it does then do not create new one and send back error message
			$prevSessions = $this->jobSessions->findByJobcodeUserIdDate($jobId,$userId,$date);
			if(count($prevSessions)>0){
				//$this->load->view("header");
				//$this->load->view("message",array("message"=>"You have already registered this job for today","source"=>base_url("index.php/checkin")));
				echo "<script>
					alert('You have already registered this job for today!');
					window.location.href='".base_url('index.php/checkin')."';
				</script>";

			}else{
				//check if half day
				$timeBetween = $to-$from;
				
				if($timeBetween>=5){
					$halfDay = "0";
				}else{
					$halfDay = "1";
				}
				//check if more than 2 jobs already exist for this day and this user - if so then user cannot register new job today
				$js = $this->jobSessions->findDailyRateForDateAndUserId($date,$userId);
				if(count($js)>=2){
					echo("<script>
						alert('You can\'t register more than 2 jobs a day (they will be recorded as half days)');
						window.location.href='".base_url('index.php/checkin')."';
						</script>
					");
					
				}else if(count($js)==1){
					//update the previous job to be a half day
					$this->jobSessions->UpdateHalfDay($js[0]->id,"1");
					$this->jobSessions->Create($userId,$jobId,$date,$from,$to,$comments,$dailyRate,"1");	
					redirect('checkin');
				}else{
					$this->jobSessions->Create($userId,$jobId,$date,$from,$to,$comments,$dailyRate,$halfDay);	
					echo("<script>
						alert('Successfully added job for ".$date."');
						window.location.href='".base_url('index.php/checkin')."';
						</script>
					");
					//redirect('checkin');
				}
			}

		}
	}
?>