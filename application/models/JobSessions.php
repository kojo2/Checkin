<?php
	class JobSessions extends CI_model {
		function Create($userId,$jobId,$date,$from,$to,$comments,$dailyRate,$halfDay){
			if($halfDay){
				$dailyRate = $dailyRate/2;
			}
			$sql = "INSERT INTO jobsessions(`jobcode`,`userId`,`date`,`timein`,`timeout`,`comments`,`dailyRate`,`halfDay`) VALUES (?,?,?,?,?,?,?,?)";
			$this->db->query($sql,array($jobId,$userId,$date,$from,$to,$comments,$dailyRate,$halfDay));
		}

		function UpdateHalfDay($jobId,$halfDay){
			$sql = "SELECT * FROM jobsessions WHERE jobsessions.id = ?";
			$record = $this->db->query($sql,array($jobId))->result()[0];
			$dailyRate = $record->dailyRate;
			if($halfDay){
				//if there is already a half day then we don't want to half it again
				if(!$record->halfDay){
					$dailyRate = $dailyRate/2;
				}
			}else{
				$dailyRate = $dailyRate*2;
			}
			$sql = "UPDATE jobsessions SET halfDay = ?, dailyRate = ? WHERE jobsessions.id = ?";
			$this->db->query($sql,array($halfDay,$dailyRate,$jobId));
		}
		function findJobById($id){
			$sql = "SELECT * FROM jobsessions where id=?";
			$results = $this->db->query($sql,array($id))->result();
			return $results;
		}

		function getJobsForUserId($userId,$date){
			$sql = "SELECT * FROM jobsessions where userId=? AND date=? order by timeIn asc";
			$results = $this->db->query($sql,array($userId,$date))->result();
			return $results;
		}

		function getJobsForUser($userId){
			$sql = "SELECT * FROM jobsessions where userId=? ORDER BY date DESC ";
			$results = $this->db->query($sql,array($userId))->result();
			return $results;
		}

		function getJobsBetweenDates($from,$to){
			$sql = "SELECT * FROM jobsessions where date BETWEEN ? and ? ORDER BY date DESC ";
			$results = $this->db->query($sql,array($from,$to))->result();
			return $results;
		}

		function getJobsBetweenDatesForUserId($userId,$from,$to){
			$sql = "SELECT * FROM jobsessions INNER JOIN joblist ON jobsessions.jobcode = joblist.jobcode where userId = ? and date BETWEEN ? and ? ORDER BY date ASC ";
			$results = $this->db->query($sql,array($userId,$from,$to))->result();
			return $results;
		}

		function getJobsBetweenDatesUnique($from,$to){
			$sql = "SELECT * from jobsessions INNER JOIN joblist ON jobsessions.jobcode=joblist.jobcode WHERE date BETWEEN ? and ? GROUP BY jobsessions.jobcode"; 
			$results = $this->db->query($sql,array($from,$to))->result();
			return $results;
		}

		function findJobSessionsByCode($code){
			$sql = "SELECT * FROM jobsessions where jobcode = ? ORDER BY date DESC";
			$results = $this->db->query($sql,array($code))->result();
			return $results;
		}

		function findJobSessionsByCodeByDate($code,$date){
			$sql = "SELECT * FROM jobsessions where jobcode = ? AND date=?";
			$results = $this->db->query($sql,array($code,$date))->result();
			return $results;
		}
		
		function deleteById($id){
			$sql = "DELETE FROM jobsessions where id = ?";
			$this->db->query($sql,array($id));
		}

		function findUsersByJobcodeByDate($jobcode,$date1,$date2){
			//$sql = "SELECT * FROM jobsessions where jobcode = ? and date BETWEEN ? and ? GROUP by userId";
			$sql = "SELECT * FROM jobsessions JOIN users on jobsessions.userId=users.id where jobcode = ? and date BETWEEN ? and ? GROUP by jobsessions.userId"; 
				$results = $this->db->query($sql,array($jobcode,$date1,$date2))->result();
				return $results;	
		}
		function findUsersByJobcodeByDateGroupByDate($jobcode,$date1,$date2){
			//$sql = "SELECT * FROM jobsessions where jobcode = ? and date BETWEEN ? and ? GROUP by userId";
			$sql = "SELECT * FROM jobsessions JOIN users ON jobsessions.userId=users.id WHERE jobcode = ? and date BETWEEN ? and ? GROUP BY jobsessions.date,jobsessions.userId"; 
				$results = $this->db->query($sql,array($jobcode,$date1,$date2))->result();
				return $results;	
			}
		function findDatesForUserForJobCodeBetweenDates($userId,$jobcode,$from,$to){
			$sql = "SELECT * FROM `jobsessions` WHERE `userId` = ? and `jobcode` = ? and date BETWEEN ? and ? GROUP BY date";
			$results = $this->db->query($sql,array($userId,$jobcode,$from,$to))->result();
			return $results;
		}

		function getJobsBetweenDatesGroupByDateUseridJobcode($from,$to){
			$sql = "SELECT * FROM `jobsessions` JOIN joblist ON jobsessions.jobcode=joblist.jobcode JOIN users on jobsessions.userId=users.id WHERE date BETWEEN ? and ? GROUP BY date, userId, jobsessions.jobcode ORDER BY date ASC";
			$results = $this->db->query($sql,array($from,$to))->result();
			return $results;
		}
		function viewParticularDaysForUser($jobcode,$userId,$from,$to){
			//$results = "$jobcode - $userId - $from - $to";
			$sql = "SELECT * FROM `jobsessions` join users on jobsessions.userId = users.id join joblist on jobsessions.jobcode=joblist.jobcode WHERE date BETWEEN ? and ? and jobsessions.jobcode = ? and jobsessions.userId=? GROUP BY date ORDER BY `jobsessions`.`date` DESC";
			//$sql = "SELECT * from `jobsessions` where userId=? and jobcode=? and date between ? and ?";
			$results = $this->db->query($sql,array($from,$to,$jobcode,$userId))->result();
			//$results = $this->db->query($sql,array($userId,$jobcode,$from,$to))->result();
			return $results;
		}

		function findDailyRateForDateAndUserId($date,$userId){
			$sql = "SELECT * from jobsessions where date = ? and userId = ?";
			$results = $this->db->query($sql,array($date,$userId))->result();
			return $results;
		}
		function findByJobcodeUserIdDate($jobcode,$userId,$date){
			$sql = "SELECT * FROM jobsessions where jobcode = ? and userId = ? and date = ?";
			$results = $this->db->query($sql,array($jobcode,$userId,$date))->result();
			return $results;
		}
		
	}
