<?php

class ChangePasswordCheckinSubmit extends Ci_Controller {

	function index($id){
		$pword = $this->input->post('pword');
		$this->load->model("Users");
		//hash the password
		$hash = sha1($pword);
		$this->Users->ChangeUserPassword($hash,$id);
	}

}