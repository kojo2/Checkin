<?php
	class Projects extends CI_Controller {
		function index(){
			if(!$this->session->userdata('userId')){
				redirect('welcome');
			}
		}

		function getProjects(){
			$this->load->model('joblist');
			$result = $this->joblist->Read();	
			foreach ($result as $r) {
				echo "<option>".$r->jobcode." - ".$r->location." - ".$r->description."</option>";
			}
		}
	}
