<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	var $reposnse = array();
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('account_model');
		$this->lang->load('account');
		//$this->load->library('recaptcha');
		$this->load->library('email');
	}
	
	function signup(){
		
		$name = $this->input->post('name', TRUE); 
		$email = $this->input->post('email', TRUE); 
		$passwd = $this->input->post('passwd', TRUE);
		
		//Avoid duplicated emails
		if($this->account_model->get_user($email)){
			die(json_encode(array('status' => 'error', 'msg' => lang('signup.error.duplicatedmail'))));
		}
				
		//Generate the activation hash
		$hash = get_hash();
		$date = date('Y-m-d');
     	if($this->account_model->signup($name, $email, $passwd, $date, $hash)){
     		$this->email->send_activation($name, $email, $passwd, $hash);
     		$this->login($email, $passwd);
     	}else{
     		die(json_encode(array('status' => 'error', 'msg' => 'Error Creating User')));
     	}
     	
     	
	}
	
	
	function login($email = null, $passwd = null){

		$email = $email ? $email: $this->input->post('email', TRUE); 
		$passwd = $passwd ? $passwd : $this->input->post('passwd', TRUE);
		
		if(!$user = $this->account_model->auth($email, $passwd)){
			$this->response['status'] = 'error';
			$this->response['msg'] = lang('login.error.noauth');
			die(json_encode($this->response));
		}
		
		if(in_array($user->status, array('I', 'C'))){
			$this->response['status'] = 'error';
			$this->response['msg'] = lang('login.error.inactiveac');
			die(json_encode($this->response));			
		}
		
		//Create the session
		$user->passwd = NULL;
		$this->session->set_userdata('user', $user);
		
		$session_data = $this->session->all_userdata();
		
		$this->response['status'] = 'ok';
		$this->response['session_id'] = $session_data['session_id'];
		die(json_encode($this->response));
	}
	
        function change_password(){

            //Aca se supone que descargamos las tres claves desde el POST
            $oldpass = $this->input->post('oldpass', TRUE);
            $newpasswd = $this->input->post('newpasswd', TRUE);
            $email = $this->input->post('email', TRUE);
                    
            
           //Validamos en email desde $user->passwd ojo que esta en md5
            $user = $this->account_model->get_user($email);      
           if(!$user){            
               die(json_encode(array('status' => 'error', 'msg' => lang('chpwd.account_noexist'))));
           }
           
           if(md5($oldpass) != $user->passwd){            
               die(json_encode(array('status' => 'error', 'msg' => lang('chpwd.passwordwrong'))));
           }
                       
            //Modificar la clave
           if(!$this->account_model->update_account($user->id, array('passwd' => md5($newpasswd)))){
                die(json_encode(array('status' => 'error', 'msg' => lang('chpwd.errorchanging'))));
            }
            
            die(json_encode(array('status' => 'ok', 'msg' => lang('chpwd.successfully'))));
        }
        
	function logout(){
		$this->session->sess_destroy();
		redirect('/'); 
	}
	
	function verify($hash){
		
		$user = $this->account_model->get_user_by_hash($hash);

		if(!$user){
			$this->session->set_flashdata('flash_msg', array('status' => 'error', 'msg' => lang('activation.wornglink')));
			redirect('/');			
		}
		
		if(in_array($user->status, array('I', 'C'))){
			$this->session->set_flashdata('flash_msg', array('status' => 'error', 'msg' => lang('activation.error')));
			redirect('/');		
		}
		
		if($user->status == 'A'){
			$this->session->set_flashdata('flash_msg', array('status' => 'error', 'msg' => lang('activation.alreadyactivated')));
			redirect('/');		
		}
		
		if($this->account_model->activate_account($user->id)){
			$this->session->set_flashdata('flash_msg', array('status' => 'ok', 'msg' => lang('activation.successfully')));
			redirect('/');			
		}
		
	}
}