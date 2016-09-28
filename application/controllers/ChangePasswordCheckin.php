<?php 

class ChangePasswordCheckin extends CI_Controller {
	function index($uid){
		$this->load->model('Users');
		$password = $this->input->post('pword');
		if($password){$hash = sha1($password);}
		if($hash){
			$this->Users->ChangeUserPassword($hash,$uid);
		}
		
	}
}