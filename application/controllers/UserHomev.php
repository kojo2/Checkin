<?php
	class UserHomev extends Ci_Controller{
		function index(){
			if(!$this->session->userdata('userId')){
				redirect('welcome');
			}
			$params = $this->session->userdata();
			$this->load->view('userHome',$params);
		}

		function readJobs(){
			$this->load->model('joblist');
			$results = $this->joblist->Read();
			foreach ($results as $r) {
				echo("<option>".ucfirst($r->jobcode)." - ".ucfirst($r->jobname)." - ".ucfirst($r->location)." - ".ucfirst($r->description)."</option>");
			}
		}
	}
