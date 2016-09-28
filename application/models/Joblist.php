<?php
	class Joblist extends CI_model {

		function Create($jobname, $jobcode,$location,$description){
			$sql="INSERT INTO joblist (`jobname`,`jobcode`,`location`,`description`) VALUES (?,?,?,?)";
			$this->db->query($sql,array($jobname,$jobcode,$location,$description));
		}

		function Read(){
			$sql = "SELECT * FROM joblist where deleted='0'";
			$results = $this->db->query($sql)->result();
			return $results;
		}

		function findJobByCode($code){
			$sql = "SELECT * FROM joblist WHERE jobcode=?";
			$results = $this->db->query($sql,array($code))->result();
			return $results;
		}

		function findJobById($id){
			$sql = "SELECT * FROM joblist WHERE id=?";
			$results = $this->db->query($sql,array($id))->result();
			return $results;
		}
		function customSql($sql,$params){
			$this->db->query($sql,$params);
		}
		function deleteJob($id){
			$sql = "UPDATE `joblist` SET `deleted` = '1' WHERE `joblist`.`id` = ?;";
			$this->db->query($sql,$id);
		}

	}
