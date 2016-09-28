<?php
	class AdminEditUsers extends CI_Controller {
		function index(){
			if(!$this->session->userdata('userId')){
				redirect('welcome');
			}
			$this->load->view("header");
			$this->load->view('adminEditUsers');
		}
		function getAllUsers(){
			$this->load->model('Users');
			$result = $this->Users->Read();
			$this->load->view("getAllUsers",array('result'=>$result));
		}
		function editUser($id){
			$this->load->model('Users');
			$result = $this->Users->findUserById($id);
			if(count($result)<1){
				redirect('adminEditUsers');
			}
			$fname = $result[0]->fname;
			$lname = $result[0]->lname;
			$data = array(
				"fname"=>$fname,
				"lname"=>$lname,
				"id"=>$id
			);
			$this->load->view("header");
			$this->load->view('adminEditUser',$data);
		}

		function addUser(){
			$this->load->view("header");
			$this->load->view("adminAddUser");
		}

		function addUserSubmit(){
			$this->load->model('Users');
			$fname = $this->input->post('fname');
			$lname = $this->input->post('lname');
			$password = $this->input->post('password');
			$cPassword = $this->input->post('cPassword');
			$dailyRate = $this->input->post('dailyRate');
			$bSAdmin = $this->input->post('bAdmin');
			if($bSAdmin==="on"){
				$bAdmin = "1";
			}else{
				$bAdmin = "0";
			}
			if($fname && $lname){
				if($password && $password==$cPassword){
					//hash the password
					$hash = sha1($password);
					$this->Users->Create($fname,$lname,$bAdmin,$dailyRate,$hash);
					redirect(base_url("index.php/adminEditUsers"));
				}else{
					$this->load->view("header");
					$this->load->view('message',array("message"=>"Please ensure you have entered a password and that the confirmation password matches","source"=>base_url("index.php/adminEditUsers/addUser")));
				}
			}else{
				$this->load->view("header");
				$this->load->view('message',array("message"=>"Please ensure you enter a firstname and a lastname","source"=>base_url("index.php/adminEditUsers/addUser")));
			}
		}

		function editUserSubmit($uid){
			$this->load->model('Users');
			$password = $this->input->post('password');
			$cPassword = $this->input->post('cPassword');
			$dailyRate = $this->input->post('dailyRate');
			$bSAdmin = $this->input->post('bAdmin');
			if($bSAdmin==="on"){
				$bAdmin = "1";
			}else{
				$bAdmin = "0";
			}
			if($password){
				if($cPassword===$password){
					//hash the password
					$hash = sha1($password);
					$this->Users->ChangeUserPassword($hash,$uid);
					echo("<script>alert('password successfully changed');</script>");
				}else{
					echo("<script>alert('Confirmation password did not match');</script>");
				}
			}
			if($dailyRate){
				$this->Users->ChangeUserDailyRate($dailyRate,$uid);
				echo("<script>alert('Daily rate successfully changed');</script>");

			}
			echo("<script>window.location.href='".base_url('index.php/adminEditUsers')."';</script>");
		}

		function deleteUserConfirm($uid)
		{
			echo('
					<script>
							var r = confirm("Are you sure you want to delete this user?");
							if(r){
								window.location.href="'.base_url("index.php/adminEditUsers/deleteUser/$uid").'";
							}else{
								window.location.href="'.base_url("index.php/adminEditUsers").'";
							}
					</script>
				');
		}

		function deleteUser($uid){

			$this->load->model('Users');
			$this->Users->DeleteById($uid);
			redirect('adminEditUsers');
		}
	}
