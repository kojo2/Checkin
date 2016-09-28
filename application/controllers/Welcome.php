<?php
class Welcome extends CI_Controller {
	function index(){
		date_default_timezone_set('Europe/London');
		ini_alter('date.timezone','Europe/London');
		if($this->session->userdata('userId')){
			$this->load->model('Users');
			$user = $this->Users->findUserById($this->session->userdata('userId'));
			if($user[0]->admin){
				$this->load->view('header');
				$this->load->view('adminHome');
			}else{
				$this->load->view('headerStaff');
				$this->load->view('checkin');
			}
		}else{
			$this->load->view('headerStaff');
			$this->load->view('welcome2');
		} 
	}
}
