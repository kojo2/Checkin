<?php 
	class User extends CI_Controller {
		function index(){
			if(!$this->session->userdata('userId')){
				redirect('welcome');
			}
		}

		function getUsers(){
			$this->load->model('Users');
			$results = $this->Users->Read();
			foreach ($results as $r) {
				if(!$r->admin){
					echo "<li><a href='../jobSessionsC/page/".$r->id."'>".$r->fname." - ".$r->lname." </a></li>";
				}
			}
		}

	}