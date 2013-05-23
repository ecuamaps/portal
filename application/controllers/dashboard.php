<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	var $title = 'Dashboard';
	var $dasboard_params = array();
		
	function __construct(){
		parent::__construct();		
	}
	
	function index(){
		
		//Get the top five of business types
		$this->dasboard_params['bztop5types'] = $this->get_top5_bztypes();
		$this->render();
	}
	
	private function render(){
		
		$this->template->write('title', $this->title);
		
		//$this->template->add_js('https://www.google.com/jsapi', 'import', FALSE, FALSE);

		$this->template->write_view('content', 'templates/map', $this->dasboard_params, TRUE);
		
		$this->template->render();		
	}
	
	/*Load the top five of the business types*/
	private function get_top5_bztypes(){
		//TODO: hardoded by now, get from DB
		return array(
			array('id' => 1, 'name' => 'Salud'),
			array('id' => 2, 'name' => 'Comida'),
			array('id' => 3, 'name' => 'Hospedajes'),
			array('id' => 4, 'name' => 'Tecnología'),
			array('id' => 5, 'name' => 'Autos'),
		);
	}
	

}