<?php
class ViewDaysWorked extends CI_Controller {
	function index(){
		$this->load->view('headerStaff');
		$this->load->view('ViewDaysWorked');
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
		 	$userId = $this->session->userdata('userId');
		 	$results = $this->jobSessions->getJobsBetweenDatesForUserId($userId,$from,$to);
		 	foreach ($results as $r) {
		 		$dateA = explode("-",$r->date);
		 		$date = "$dateA[2]/$dateA[1]/$dateA[0]";
		 		echo "$date | $r->jobcode | $r->jobname | $r->location | $r->timeIn - $r->timeOut ";
		 		if($r->comments){echo "| $r->comments<br>";}else{"<br><br>";}
		 		echo "<br>";
		 	}
	}

	function exportToExcel($from,$to){
		//convert dates back to slashes
			$fromA = explode("_",$from);
			$from = $fromA[2]."-".$fromA[0]."-".$fromA[1];
			$toA = explode("_",$to);
			$to = $toA[2]."-".$toA[0]."-".$toA[1];
			//echo "from: g$from\g - h$to\h";
		//query the database to find jobsessions from between these dates
		$this->load->model("jobSessions");
		$userId = $this->session->userdata('userId');
		$results = $this->jobSessions->getJobsBetweenDatesForUserId($userId,$from,$to);
		$this->load->library('excel');
		$this->load->helper('date');
		$daysInMonth = date_range($from,$to);
		$letters = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		//populate dates in the spreadsheet
		$i=0;
		foreach ($daysInMonth as $d) {
			$dA = explode("-",$d);
			$d = $dA[2]."-".$dA[1]."-".substr($dA[0],2);
			$this->excel->getActiveSheet()->setCellValue("A$i","$d");
			$i++;
		}
		//populate job sessions in the spreadsheet
		//get all dates from results and put them into a special array
		$datesInResults = array();
		foreach ($results as $r) {
			array_push($datesInResults, (string)$r->date);
		}
		//count the number of times each date appears
		$dateDuplicates = array_count_values ( $datesInResults );

		foreach ($results as $r) {
				$date = $r->date;
				if($r->halfDay){$hf = "h";}else{$hf = "f";}
				if($dateDuplicates[(string)$r->date]>1){
					$hf="f";
				}
				$index = array_search ( $date ,$daysInMonth);
				$this->excel->getActiveSheet()->setCellValue("B$index","$hf");
			}
			$nIndex = $i+2;
			$nIndex2 = $i+3;
			$this->excel->getActiveSheet()->setCellValue("A$nIndex","h = half day");
			$this->excel->getActiveSheet()->setCellValue("A$nIndex2","f = full day");

		//$this->excel->getActiveSheet()->setCellValue($letters[$namesCount+2].$countDaysInMonth,"=sum(".$letters[$namesCount+2]."3:".$letters[$namesCount+2].count($daysInMonth).")");

		//convert dates back to slashes
			$fromA = explode("-",$from);
			$from = $fromA[2]."-".$fromA[1]."-".$fromA[0];
			$toA = explode("-",$to);
			$to = $toA[2]."-".$toA[1]."-".$toA[0];
			$filename=$from."_".$to.".xls"; //save our workbook as this file name
		//$filename="test.xls"; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		           
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//ob_end_clean();
		$objWriter->save('php://output');
	}
}