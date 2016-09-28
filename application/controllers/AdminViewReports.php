<?php
	class AdminViewReports extends CI_Controller {
		function index(){
			if(!$this->session->userdata('userId')){
				redirect('welcome');
			}
			$this->load->view('header');
			$this->load->view('adminViewReports');
		}
		function viewDate(){
			$this->load->view('header');
			$this->load->view('adminViewDate');
		}

		function viewProject(){
			$this->load->view('header');
			$this->load->view('adminViewProject');
		}

		function viewUser(){
			$this->load->view('header');
			$this->load->view('adminViewUser');
		}

		function createColoredBlock($perc98,$jobcode,$location,$timeIn,$timeOut,$comments,$id,$showDate,$date,$name){
			$this->load->library('coloredblocks');
			echo $this->coloredblocks->shoot($perc98,$jobcode,$location,$timeIn,$timeOut,$comments,$id,$showDate,$date,$name);
		}

		function viewDateSubmit(){
			$p = $this->input->post();
			$this->load->model('joblist');
			$this->load->model('jobSessions');
			$this->load->model('Users');
			$froma = explode("_",$p['from']);
			$from = $froma[2]."/".$froma[0]."/".$froma[1];
		 	$toa = explode("_",$p['to']);
		 	$to = $toa[2]."/".$toa[0]."/".$toa[1];
		 	$result = $this->jobSessions->getJobsBetweenDatesUnique($from,$to);
			if(count($result)){
		 		foreach ($result as $r) {
		 			$dates = $this->jobSessions->findUsersByJobcodeByDateGroupByDate($r->jobcode,$from,$to);
		 			$staff = $this->jobSessions->findUsersByJobcodeByDate($r->jobcode,$from,$to);
		 			$staffArr = array();
		 			$dailyRateA=array();
		 			foreach ($staff as $s) {
		 				$daysr = $this->jobSessions->findDatesForUserForJobCodeBetweenDates($s->userId,$r->jobcode,$from,$to);
		 				$days = count($daysr);
		 				$arr = array($s->userId=>$days);
		 				array_push($staffArr,$arr);
		 			}
		 			$fromA = explode("/",$from);
		 			$fromS = $fromA[0]."_".$fromA[1]."_".$fromA[2];
		 			$toA = explode("/",$to);
		 			$toS = $toA[0]."_".$toA[1]."_".$toA[2];
		 			$params = array('jobcode'=>$r->jobcode,'jobname'=>$r->jobname,'location'=>$r->location,'description'=>$r->description,'staff'=>$staff,'dates'=>$dates,'arr'=>$staffArr,'from'=>$fromS,'to'=>$toS,'dailyRate'=>$dailyRateA);
		 			$this->load->view('parts/listProjects',$params);
				}
			}else{
	 			echo("no results found");
	 		}
		}

		function exportToExcel($jobcode,$from,$to){
			//convert dates back to slashes
			$fromA = explode("_",$from);
			$from = $fromA[0]."-".$fromA[1]."-".$fromA[2];
			$toA = explode("_",$to);
			$to = $toA[0]."-".$toA[1]."-".$toA[2];
			//echo("from: $from to: $to");
			//query the database to find jobsessions from between these dates
			$this->load->model("jobSessions");
			$results = $this->jobSessions->findUsersByJobcodeByDateGroupByDate($jobcode,$from,$to);
			$this->load->library('excel');
			$this->load->helper('date');
			$daysInMonth = date_range($from,$to);
			$letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			$i=3;
			//populate dates in the spreadsheet
			foreach ($daysInMonth as $d) {
				$dA = explode("-",$d);
				$d = $dA[2]."-".$dA[1]."-".substr($dA[0],2);
				$this->excel->getActiveSheet()->setCellValue("A$i","$d");
				$i++;
			}
			$names = $this->jobSessions->findUsersByJobcodeByDate($jobcode,$from,$to);
			$namesCount = count($names);
			$nameIndexes = array();
			$i = 2;
			//populate staff names in the spreadsheet
			foreach ($names as $n) {
				$this->excel->getActiveSheet()->setCellValue("$letters[$i]2",ucfirst("$n->fname"));
				$nameIndexes[$i] = $n->fname;
				$i++;
			}
			$results = $this->jobSessions->findUsersByJobcodeByDateGroupByDate($jobcode,$from,$to);
			//populate job sessions in the spreadsheet
			foreach ($results as $r) {
				$date = $r->date;
				$index = array_search ( $date ,$daysInMonth);
				$nIndex = array_search($r->fname, $nameIndexes);
				//$jobId = $r->id;
				//find dailyRate for this jobsession
				$dailyRate = $this->jobSessions->findDailyRateForDateAndUserId($date,$r->userId)[0]->dailyRate;
				//if job is a half day then half the price
				//if($r->halfDay){
			//		$dailyRate = ($dailyRate/2);
		//		}
				//echo count($dailyRate);
				//$nIndex+=2;
				if(!$dailyRate){$dailyRate="0.00";}
				$index+=3;
				$this->excel->getActiveSheet()->setCellValue("$letters[$nIndex]$index","$dailyRate");
			}
			//find Jobname and Location from the database using the jobcode
			$this->load->model('joblist');
			$j = $this->joblist->findJobByCode($jobcode)[0];
			$this->excel->getActiveSheet()->setCellValue("A1","$jobcode - $j->jobname - $j->location");
			$countDaysInMonth = count($daysInMonth)+4;
			for($i = 3 ; $i<count($daysInMonth)+3 ; $i++){
				$this->excel->getActiveSheet()->setCellValue($letters[$namesCount+2].$i,"=sum(A$i:".$letters[$namesCount+1]."$i)");
				$this->excel->getActiveSheet()->setCellValue($letters[$namesCount+2]."2","Total");
				$this->excel->getActiveSheet()
   					->getStyle("B".$i.":".$letters[$namesCount+2].$i)
    				->getNumberFormat()
					->setFormatCode(
        				 '[$£-809]#,##0.00'
    			);
					$this->excel->getActiveSheet()
   					->getStyle($letters[$namesCount+2].$countDaysInMonth)
    				->getNumberFormat()
					->setFormatCode(
        				 '[$£-809]#,##0.00'
    			);
			}
			
			$this->excel->getActiveSheet()->setCellValue($letters[$namesCount+2].$countDaysInMonth,"=sum(".$letters[$namesCount+2]."3:".$letters[$namesCount+2].count($daysInMonth).")");
			$filename=$jobcode."_".$j->location."_".$from."_".$to.".xls"; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			           
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//ob_end_clean();
			$objWriter->save('php://output');

		}

	// 	function getWeekDates($year, $week, $start=true)
	// 			{
 //  					$from = date("Y-m-d", strtotime("{$year}-W{$week}-1")); //Returns the date of monday in week
 //    				$to = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week
 
 //    				if($start) {
 //        				return $from;
 //    				} else {
 //        				return $to;
 //    				}
 //    				//return "Week {$week} in {$year} is from {$from} to {$to}.";
	// 			}

		function viewParticularDaysForUser($jobcode,$userId,$from,$to) {
			//convert dates back to slashes
			
			$fromA = explode("_",$from);
			$from = $fromA[0]."-".$fromA[1]."-".$fromA[2];
			$toA = explode("_",$to);
			$to = $toA[0]."-".$toA[1]."-".$toA[2];
			//find these results
			$this->load->model('jobSessions');
			$this->load->model('users');
			$user = $this->users->findUserById($userId);
			$results = $this->jobSessions->viewParticularDaysForUser($jobcode,$userId,$from,$to);
			 foreach ($results as $r) {
			 	//echo "<h1>$r->fname $r->lname <br>$r->jobcode - $r->location</h1><h2>$from - $to</h2>";
			 	//echo "<br><a href=''>$r->date - $r->comments</a>";
			 }
			 $params = array('results'=>$results,'fname'=>$user[0]->fname,'lname'=>$user[0]->lname);
			 $this->load->view('header');
			 $this->load->view('viewParticularDaysForUser',$params);

		}

	}



