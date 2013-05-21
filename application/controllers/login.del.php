<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	var $title = 'Login';
	var $error = NULL;
	var $enterprise = NULL;
	
	function __construct(){
		parent::__construct();
		
		if($user = $this->session->userdata('user')){
			$this->lang->switch_uri($user->lang);		
			redirect($user->lang.'/dashboard'); 
		}
		
		$this->load->model('enterprise_model');
		$domain = get_domain();
		
		// load language file
		$this->lang->load('login');
		
		//Get the enterprice
		$enterprise = $this->enterprise_model->get_by_domain($domain);
		if(!count($enterprise)){
			$this->error = lang('login.error.enterprise');
		}else{
			//Load the enterpise data into the session
			$enterprise = $enterprise[0];
			$this->session->set_userdata('enterprise', $enterprise);
			$this->enterprise = $enterprise;			
		}

		
	}
	
	public function index(){
		$this->load_view();
	}
	
	function do_login(){
		
		$username = $this->input->post('username', TRUE); 
		$password = $this->input->post('password', TRUE);
		 
		$this->load->model('account_model');
		
		if(!$user = $this->account_model->auth($this->enterprise->id, $username, $password)){
			$this->error = lang('login.error.noauth');
			$this->index();
			return false;
		}
		
		//Create the session
		$user->password = NULL;
		$this->session->set_userdata('user', $user);
		
		//load the features
		$config = ($user->config) ? unserialize($user->config) : array();
		$this->session->set_userdata('user_config', $config);
		
		$this->lang->switch_uri($user->lang);		
		redirect($user->lang.'/dashboard'); 
	}
	
	private function load_view(){
		
		$this->load->view('login', array(
					'title' => $this->title,
					'error' => $this->error,
					'enterprise' => $this->enterprise
					));
	}
	
	
} 
 
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */