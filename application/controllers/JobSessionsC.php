<?php
	class JobSessionsC extends CI_Controller {

		function index(){
			if(!$this->session->userdata('userId')){
				redirect('welcome');
			}
		}

		function page($uid,$date=NULL,$picker=NULL){
			$data['uid']=intval($uid);
			$this->load->model('Users');
			$result = $this->Users->findUserById(intval($uid));
			if(count($result)==1){
				foreach ($result as $r) {
					$fname = $r->fname;
					$lname = $r->lname;
				}
			}else{
				echo("not found em");
			}
			$data['fname']=$fname;
			$data['lname']=$lname;
			$data['date']=$date;
			if($picker){
				$data['picker']=$picker;
			}
			$this->load->view('header');
			$this->load->view('adminViewJobsSessionsUser',$data);		
		}

		function apage($uid,$date=NULL,$picker=NULL){
			$data['uid']=intval($uid);
			$this->load->model('Users');
			$result = $this->Users->findUserById(intval($uid));
			if(count($result)==1){
				foreach ($result as $r) {
					$fname = $r->fname;
					$lname = $r->lname;
				}
			
			}else{
				echo("not found em");
			}
			$data['fname']=$fname;
			$data['lname']=$lname;
			$data['date']=$date;
			if($picker){
				$data['picker']=$picker;
			}
			$this->load->view('header');
			$this->load->view('adminViewJobSessions2',$data);		
		}

		//view all jobs for user between from and to dates
		function forUser(){
			$p = $this->input->post();
			$from = $p['from'];
			$fromA = explode("_",$from);
			$from = $fromA[2]."-".$fromA[0]."-".$fromA[1];
			$to = $p['to'];
			$toA = explode("_",$to);
			$to = $toA[2]."-".$toA[0]."-".$toA[1];
			$userId = $p['uid'];
			$date = $this->input->post('date');
			$this->load->model('jobSessions');
			$results = $this->jobSessions->getJobsBetweenDatesForUserId($userId,$from,$to);
			foreach ($results as $r) {
				if($r->dailyRate){
					$dailyRate=$r->dailyRate;
				}else{
					$dailyRate = "";
				}
				//if($r->dailyRate){$dailyRate=$r->dailyRate;}else{$dailyRate="";}
				echo "<a href='../apage/".$userId."/".$r->date."'>".$r->date." - ".$r->jobcode." - ".$r->jobname." - ".$r->location." - ".$r->description." - ".$dailyRate."</a> <br>";
			}
			if(count($results)>0){
				echo '<a class = "numbers" href="'.base_url("index.php/JobSessionsC/exportToExcel/$userId/$from/$to").'">Export to excel</a>';
			}else{
				echo "No results found";
			}

		}
		//taken from checkin controller
		function getJobsForUserId(){
			$uid = $this->input->post('uid');
			$this->load->model("jobSessions");
			$this->load->model('joblist');
			$this->load->helper('date');
			$datestring = "%Y%m%d";
			$date = mdate($datestring);
			$results = $this->jobSessions->getJobsForUser($uid);
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
				$color = $colorPart1.",".$colorPart2.",".$colorPart3.","."0.5";
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
				$locationResult = $this->joblist->findJobByCode($r->jobcode);
				$location = $locationResult[0]->location;
				$description = $locationResult[0]->description;
				echo("<a href='#' class='aJobs'><li class='jobSession' style='width:".$perc."% ; left:".$left."% ; background-color:rgba(".$color.")'><span class='darker'>".$r->jobcode."</span> <br>".$r->date." <br>".$location."<br>".$description."<br>".$timeIn." - ".$timeOut."<br><span class='".$visibility."'>Comment: ".$comments.$hours." hours</span><br><span class='invisible'>**".$r->id."</span></li></a>");
			}

		}

		//view jobs by date
		function User(){
			$uid = $this->input->post('uid');
			$this->load->model('jobSessions');
			$this->load->model('joblist');
			$date = $this->input->post('date');
			$datea = explode('/',$date);
			$datem = $datea[0];
			$dated = $datea[1];
			$datey = $datea[2];
			$mdate = $datey."-".$datem."-".$dated;
			$result = $this->jobSessions->getJobsForUserId($uid,$mdate);
			if(count($result)>0){
				foreach ($result as $r) {
					$locationResult = $this->joblist->findJobByCode($r->jobcode);
					$location = $locationResult[0]->location;
					//echo $r->jobcode." - ".$location." - ".$r->timeIn." - ".$r->timeOut." - ".$r->comments."<br>";
					$perc98 = 80;
					$this->createColoredBlock($perc98,$r->jobcode,$location,$r->timeIn,$r->timeOut,$r->comments,$r->id,"false","","");
				}
			}else{
				echo("No records were found");
			}

		}

		function findJobSessionsByCode(){
			$p = $this->input->post();
			$code = explode(" ",$p['text'])[0];
			$this->load->model('jobSessions');
			$this->load->model('Users');
			$this->load->model('joblist');
			$result = $this->jobSessions->findJobSessionsByCode($code);
			if(count($result)>0){
				foreach ($result as $r) {
					$nameResult = $this->Users->findUserById($r->userId);
					$fname = $nameResult[0]->fname;
					$lname = $nameResult[0]->lname;
					$name = $fname." ".$lname;
					$timeInA = explode(":",$r->timeIn);
					$timeIn = $timeInA[0].":".$timeInA[1];
					$timeOutA = explode(":", $r->timeOut);
					$timeOut = $timeOutA[0].":".$timeOutA[1];
					$hoursWorked = $r->timeOut - $r->timeIn;
					$perc98 = 90;
					echo $this->createColoredBlock($perc98,$r->jobcode,"",$r->timeIn,$r->timeOut,$r->comments,$r->id,"false",$r->date,$name);
				
}			}else{
				echo("No records were found");
			}

		}

		function viewByProject(){
			$dates = array();
			$p = $this->input->post();
			$code = explode(" ",$p['text'])[0];
			$this->load->model('jobSessions');
			$this->load->model('Users');
			$result = $this->jobSessions->findJobSessionsByCode($code);
			if(count($result)>0){
				foreach ($result as $r) {
					if(!in_array($r->date, $dates)){
						array_push($dates, $r->date);
					}
				}
			}else{
				//redirect('adminViewReports');
				echo "No results found";
			}
			foreach ($dates as $d) {
				$result = $this->jobSessions->findJobSessionsByCodeByDate($code,$d);
				$users = array();
				foreach ($result as $r) {
					$u = $this->Users->findUserById($r->userId);
					$fname = $u[0]->fname;
					$lname = $u[0]->lname;
					$name = $fname." ".$lname;
					$timeInA = explode(":",$r->timeIn);
					$timeIn = $timeInA[0].":".$timeInA[1];
					$timeOutA = explode(":",$r->timeOut);
					$timeOut = $timeOutA[0].":".$timeOutA[1];
					$usersArray = array('fname'=>$fname,'lname'=>$lname,'comments'=>$r->comments,'timeIn'=>$timeIn,'timeOut'=>$timeOut);
					//$usersArray = array('comments'=>$r->comments);
					array_push($users, $usersArray);
					//echo($r->comments);
				}
				//echo ("<h1>".$d."</h1><br></p>".count($result)."</p>");
				$dA = explode("-",$d);
				$d = $dA[2]."-".$dA[1]."-".$dA[0];
				$params = array('Title'=>$d,'user'=>$users);
				$this->load->view('projectViewByDate',$params);	
			}
			

		}

		function createColoredBlock($perc98,$jobcode,$location,$timeIn,$timeOut,$comments,$id,$showDate,$date,$name){
			$this->load->library('ColoredBlocks');
			echo $this->coloredblocks->shoot($perc98,$jobcode,$location,$timeIn,$timeOut,$comments,$id,$showDate,$date,$name);
			
			
		}

		function exportToExcel($userId,$from,$to){
			//query the database to find jobsessions from between these dates
			$this->load->model("jobSessions");
			$results = $this->jobSessions->getJobsBetweenDatesForUserId($userId,$from,$to);
			$this->load->library('excel');
			$this->load->helper('date');
			$daysInMonth = date_range($from,$to);
			$letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			//populate name
			$this->load->model("Users");
			$user = $this->Users->findUserById($userId);
			$this->excel->getActiveSheet()->setCellValue("A1",$user[0]->fname." ".$user[0]->lname);
			$fromA = explode("-",$from);
			$toA = explode("-",$to);
			$from = $fromA[2]."/".$fromA[1]."/".$fromA[0];
			$to = $toA[2]."/".$toA[1]."/".$toA[0];
			$this->excel->getActiveSheet()->setCellValue("B1","From: ".$from);
			$this->excel->getActiveSheet()->setCellValue("C1","To: ".$to);
			$this->excel->getActiveSheet()->setCellValue("A3","Date");
			$this->excel->getActiveSheet()->setCellValue("B3","Job Code");
			$this->excel->getActiveSheet()->setCellValue("C3","Job Name");
			$this->excel->getActiveSheet()->setCellValue("D3","Location");
			$this->excel->getActiveSheet()->setCellValue("E3","Comments");
			$this->excel->getActiveSheet()->setCellValue("F3","Daily Rate");
			$this->excel->getActiveSheet()->getStyle('A3:F3')->getFont()->setBold(true);
			$i=4;
			//populate job session for user
			foreach ($results as $r) {
				$dateA = explode("-",$r->date);
				$date = $dateA[2]."/".$dateA[1]."/".$dateA[0];
				$this->excel->getActiveSheet()->setCellValue("A$i","$date");
				$this->excel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
				$this->excel->getActiveSheet()->setCellValue("B$i","$r->jobcode");
				$this->excel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
				$this->excel->getActiveSheet()->setCellValue("C$i","$r->jobname");
				$this->excel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
				$this->excel->getActiveSheet()->setCellValue("D$i","$r->location");
				$this->excel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
				$this->excel->getActiveSheet()->setCellValue("E$i","$r->description");
				$this->excel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
				$this->excel->getActiveSheet()->setCellValue("F$i","$r->dailyRate");
				$this->excel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
				$i++;
				//echo "$r->date - $r->dailyRate <br>";
			}
			//populate totals
			$num_results = count($results);
			$num_results+=4;
			$this->excel->getActiveSheet()->setCellValue("E".$num_results,"Totals:");
			$this->excel->getActiveSheet()->setCellValue("F".$num_results,"=sum(F3:F$num_results)");
			
			$filename=$userId."_".$from."_".$to.".xls"; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			           
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//ob_end_clean();
			$objWriter->save('php://output');
	
		}


	}
