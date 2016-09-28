<?php
	class AdminHome extends CI_Controller {
		function index(){
			if(!$this->session->userdata('userId')){
				redirect('welcome');
			}
			$this->load->view('header');
			$this->load->view('adminHome');
		}
	}
