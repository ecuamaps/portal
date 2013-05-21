<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	var $title = 'Dashboard';
	var $dasboard_params = array();
		
	function __construct(){
		parent::__construct();
				
		$this->enterprise = $this->session->userdata('enterprise');

		// the language file is autoloaded
		
	}
	
	function index(){
		//Get the dashboard data and reports
		$this->dasboard_params['available_rooms'] = $this->get_available_rooms();
		$this->dasboard_params['occupied_rooms'] = $this->get_ocuppied_rooms();
		$this->dasboard_params['load_factor'] = (float) $this->dasboard_params['occupied_rooms'] / $this->dasboard_params['available_rooms'];
		
		$this->render();
	}
	
	private function render(){
		
		$this->template->write('title', $this->title);
		
		$this->template->add_js('https://www.google.com/jsapi', 'import', FALSE, FALSE);

		$this->template->write_view('content', 'templates/dashboard', $this->dasboard_params, TRUE);
		
		$this->template->render();		
	}
	
	private function get_available_rooms(){
		return 31;
	}
	private function get_ocuppied_rooms(){
		return 9;
	}
}