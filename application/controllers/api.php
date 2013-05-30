<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct(){
		parent::__construct();		
	}
	
	function search(){
		die( json_encode(array('status' => 'ok')) );	
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
			array('id' => 23, 'name' => 'Supermercados'),
		);
	}
	
	function add_location(){
		
		$lat = $this->input->post('lat', TRUE); 
		$lng = $this->input->post('lng', TRUE);
		$name = $this->input->post('name', TRUE);
		$def = $this->input->post('def', TRUE);
				
		if(!$lat || !$lng || !$name || $def === null){ 
			$result = array('status' => 'error', 'msg' => 'Missing input params lat, lng, name or def');
			die(json_encode($result));
		}
		
		$this->load->model('account_model');
		$user = $this->session->userdata('user');

		if($this->account_model->add_location($user->id, $name, $lat, $lng, $def)){
			die(json_encode(array('status' => 'ok')));
		}

		$result = array('status' => 'error', 'msg' => 'Something went wrong');
		die(json_encode($result));
	}
	
	function set_default_location(){
		$name = $this->input->post('name', TRUE);		

		if(!$name){ 
			$result = array('status' => 'error', 'msg' => 'Missing input params name');
			die(json_encode($result));
		}
		
		$this->load->model('account_model');
		$user = $this->session->userdata('user');

		if($this->account_model->set_default_location($user->id, $name)){
			die(json_encode(array('status' => 'ok')));
		}

		$result = array('status' => 'error', 'msg' => 'Something went wrong');
		die(json_encode($result));
	}
	
	function delete_location(){
		$name = $this->input->post('name', TRUE);

		if(!$name){ 
			$result = array('status' => 'error', 'msg' => 'Missing input params name');
			die(json_encode($result));
		}

		$this->load->model('account_model');
		$user = $this->session->userdata('user');
		
		if($this->account_model->delete_location($user->id, $name)){
			die(json_encode(array('status' => 'ok')));
		}
		
		$result = array('status' => 'error', 'msg' => 'Something went wrong');
		die(json_encode($result));
		
	}
}