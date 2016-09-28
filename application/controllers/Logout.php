<?php

	class Logout extends CI_Controller {
		function index(){
			$this->session->sess_destroy();
			echo "<script>window.location.href='".base_url()."';</script>";
		}
	}


