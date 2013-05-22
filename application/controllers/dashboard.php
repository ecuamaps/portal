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
		
		$this->template->add_js('https://www.google.com/jsapi', 'import', FALSE, FALSE);

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
	
	function ajax_get_all_types(){
		die(json_encode($this->get_all_types()));
	}
	
	/* get all primary types (without parent) exucluding the top five*/
	private function get_all_types(){
		//TODO: hardoded by now, get from DB and exclude the top five		
		return array(
			array('id' => 6, 'name' => 'Mascotas'),
			array('id' => 7, 'name' => 'Belleza'),
			array('id' => 8, 'name' => 'Viveres'),
			array('id' => 9, 'name' => 'Serv. Financieros'),
			array('id' => 10, 'name' => 'Serv. Públicos'),
			array('id' => 11, 'name' => 'Internet'),
			array('id' => 12, 'name' => 'Muebles'),
			array('id' => 13, 'name' => 'Finca Raíz'),
			array('id' => 14, 'name' => 'Ropa'),
			array('id' => 15, 'name' => 'Viajes'),
			array('id' => 16, 'name' => 'Gimnasio'),
			array('id' => 17, 'name' => 'C. Comerciales'),
			array('id' => 18, 'name' => 'Cines'),
			array('id' => 19, 'name' => 'Teatros'),
			array('id' => 20, 'name' => 'Diversión'),
			array('id' => 21, 'name' => 'Música'),
			array('id' => 22, 'name' => 'Sitios de interes'),
			array('id' => 23, 'name' => 'Transportes'),
		);
	}
}