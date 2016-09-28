<?php
	class Login extends CI_Controller {
		function index() {
			$creds = $this->input->post('creds');
			$pword = $this->input->post('password');
			if(!$creds && !$pword){
				redirect('welcome');
			}
			$credsA = explode(" ",$creds);
			if(count($credsA)=="2"){
				$fname = ucfirst($credsA[0]);
				$lname = ucfirst($credsA[1]);
				$this->load->model('Users');
				$results = $this->Users->findUser($fname,$lname);
				if(count($results)==1){
					foreach ($results as $r) {
						if($r->hashedPword===sha1($pword)){
								$newdata = array(
								'userId' => $r->id,
	                   			'fname'  => $fname,
	                   			'lname'     => $lname
	               			);
							$this->session->set_userdata($newdata);
							if($r->admin==='1'){
								redirect('adminHome');
							}else{
								redirect('checkin'); 
							}
						}else{
							$message = "You have entered an incorrect password";
							$this->load->view("headerStaff");
							$this->load->view("message",array('message'=>$message,'source'=>base_url()));
						}
					}
				}else{
					$message = "This user does not exist";
					$this->load->view("headerStaff");
					$this->load->view("message",array('message'=>$message,'source'=>base_url()));
				}
			}else{
				$message = "Please ensure you enter a firstname and lastname";
				$this->load->view("headerStaff");
				$this->load->view("message",array('message'=>$message,'source'=>base_url()));
			}
		}
	}

