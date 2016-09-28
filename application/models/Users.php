<?php
	class Users extends CI_model {

		function Create($fname,$lname,$bAdmin,$dailyRate,$password){
			$fname = ucfirst($fname);
			$lname = ucfirst($lname);
			$sql="INSERT INTO users (`fname`,`lname`,`admin`,`dailyRate`,`hashedPword`) VALUES (?,?,?,?,?)";
			$this->db->query($sql,array($fname,$lname,$bAdmin,$dailyRate,$password));
		}

		function Read(){
			$sql = "SELECT * FROM users where `deleted` = '0'";
			$results = $this->db->query($sql)->result();
			return $results;
		}
		//We don't actually want to delete the whole user, just to change `deleted` to true, that way old jobs that reference this user will still be able to show details like user's name
		function DeleteById($uid){
			$sql = "UPDATE `users` SET `deleted` = ? WHERE `users`.`id` = ?";
			$this->db->query($sql,array('1',$uid));
		}

		function findUser($fname,$lname){
			$sql = "SELECT * FROM users WHERE fname=? AND lname=? AND deleted='0'";
			$results = $this->db->query($sql, array($fname,$lname))->result();
			return $results;
		}

		function findUserById($uid){
			$sql = "SELECT * FROM users WHERE id=?";
			$results = $this->db->query($sql, array($uid))->result();
			return $results;
		}

		function ChangeUserPassword($pword,$uid){
			$sql = "UPDATE `users` SET `hashedPword` = ? WHERE `users`.`id` = ?";
			$this->db->query($sql, array($pword,$uid));
		}

		function ChangeUserDailyRate($dailyRate,$uid){
			$sql = "UPDATE `users` SET `dailyRate` = ? WHERE `users`.`id` = ?;";
			$this->db->query($sql, array($dailyRate,$uid));
		}


		
	}
