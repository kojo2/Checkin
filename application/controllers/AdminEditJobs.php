<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class AdminEditJobs extends CI_Controller {
		function index(){
			if(!$this->session->userdata('userId')){
				redirect('welcome');
			}
			$this->load->view("header");
			$this->load->view('adminEditJobs');
		}

		function submit(){
			$this->load->model('joblist');
			$p = $this->input->post();
			$jobname = $p['jobname'];
			$jobcode = $p['jobcode'];
			$location = $p['location'];
			$description = $p['description'];
			$this->joblist->Create($jobname,$jobcode,$location,$description);
			redirect('adminEditJobs');
		}

		function viewAll(){
			$this->load->model('joblist');
			$result = $this->joblist->Read();
			foreach($result as $r) {
				if(!$r->jobname){
					$jobname="";
				}else{
					$jobname=ucfirst($r->jobname)." - ";
				}
				echo("<a href='adminEditJobs/editJob/".$r->id."'>".ucfirst($r->jobcode)." - ".$jobname.ucfirst($r->location)." - ".ucfirst($r->description)."</a><br>");
			}

		}

		function editJob($id){
			$this->load->model('joblist');
			$job = $this->joblist->findJobById($id)[0];
			$params = array('id'=>$id,'jobcode'=>$job->jobcode,'jobname'=>$job->jobname,'location'=>$job->location,'description'=>$job->description);
			$this->load->view('header');
			$this->load->view('adminEditJob',$params);
		}

		function editJobSubmit($id){
			$this->load->model('joblist');
			$p = $this->input->post();
			$jobcode = $p['jobcode'];
			$jobname = $p['jobname'];
			$location = $p['location'];
			//echo "changing job id: ".$id;
			if($jobcode){
				$sql = "UPDATE `joblist` SET `jobcode` = ? WHERE `joblist`.`id` = ?";
				$params = array('jobcode'=>$jobcode,'id'=>$id);
				$this->joblist->customSql($sql,$params);
			}
			if($jobname){
				$sql = "UPDATE `joblist` SET `jobname` = ? WHERE `joblist`.`id` = ?";
				$params = array('jobname'=>$jobname,'id'=>$id);
				$this->joblist->customSql($sql,$params);	
			}
			if($location){
				$sql = "UPDATE `joblist` SET `location` = ? WHERE `joblist`.`id` = ?";
				$params = array('location'=>$location,'id'=>$id);
				$this->joblist->customSql($sql,$params);
			}
			//redirect(base_url("index.php/adminEditJobs/editJob/".$id));
			echo("<script>window.location.href='".base_url('index.php/adminEditJobs')."';</script>");

		}

		function deleteJob($id){
			$this->load->model('joblist');
			$this->joblist->deleteJob($id);
			redirect(base_url("index.php/adminEditJobs"));
		}
	}
