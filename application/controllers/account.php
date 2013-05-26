<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	var $reposnse = array();
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('account_model');
		$this->lang->load('account');
		$this->load->library('recaptcha');
	}
	
	function signin(){
		
		$name = $this->input->post('name', TRUE); 
		$email = $this->input->post('email', TRUE); 
		$passwd = $this->input->post('passwd', TRUE);
				
		$this->recaptcha->recaptcha_check_answer(
                    $_SERVER['REMOTE_ADDR'],
                    $this->input->post('recaptcha_challenge_field', TRUE),
                    $this->input->post('recaptcha_response_field', TRUE));
       
     	if(!$this->recaptcha->getIsValid()){
     		if($this->recaptcha->getError() == 'incorrect-captcha-sol'){
     			die(json_encode(array('status' => 'error', 'msg' => lang('signin.error.captcha'))));
     		}else{
     			die(json_encode(array('status' => 'error', 'msg' => $this->recaptcha->getError())));
     		}
     	}
     	
     	//TODO: Send email account confirmation

     	if($this->account_model->signin($name, $email, $passwd)){
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
		
		//Create the session
		$user->passwd = NULL;
		$this->session->set_userdata('user', $user);
		
		$session_data = $this->session->all_userdata();
		
		$this->response['status'] = 'ok';
		$this->response['session_id'] = $session_data['session_id'];
		die(json_encode($this->response));
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('/'); 
	}
}