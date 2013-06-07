<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->lang->load('api');		
	}
	
	function search(){
		
		$rslt_amnt = 2;
		
		header('Content-Type: text/html');
		?>
		<h4><small><?=str_replace('[X]', $rslt_amnt, lang('search.resultstitle'))?>:</small></h4>
		<div class="row full-width" id="results-wrapper">
			<div class="search-results-panel" id="123">
			  	<input type="hidden" name="123-lat"  value="-0.17286542654272" />
			  	<input type="hidden" name="123-lng"  value="-78.4804487228393" />
			  	<input type="hidden" name="123-inmap"  value="0" />
			  	
			  	<div class="row">
			  		<div class="small-1 columns"></div> 
			  		<div class="small-6 columns"><h6 class="clear-margin">El Rincón del sabor</h6></div>
			  		<div class="small-4 columns"><h5 class="clear-margin"><small>3.5</small></h5></div>
			  	</div>

			  	<div class="row">
			  		<div class="small-12 columns"><h6 class="clear-margin"><small>E845, Quito</small></h6></div>
			  	</div>

			  	<div class="row">
			  		<div class="small-12 columns"><h6 class="clear-margin"><small>Tels: 2264124 -2246453</small></h6></div>
			  	</div>

			  	<div class="row">
			  		<div class="small-2 columns"><a href="#" class="tiny button">Ver Mas</a></div>
			  		<div class="small-2 columns"><a href="#" class="tiny button">Insertar en el mapa</a></div>
			  		<div class="small-2 columns"><a href="#" class="tiny button">Como llegar</a></div>
			  	</div>
			  	
			</div>

		  	<div class="search-results-panel" id="124">
		  		<input type="hidden" name="124-lat"  value="-0.17273936329235" />
		  		<input type="hidden" name="124-lng"  value="-78.4803253412246" />
		  		<input type="hidden" name="124-inmap"  value="0" />
			  		
		  		<div class="row">
		  			<div class="small-1 columns"></div> 
		  			<div class="small-6 columns"><h6 class="clear-margin">Papeletek</h6></div>
		  			<div class="small-4 columns"><h5 class="clear-margin"><small>N/A</small></h5></div>
		  		</div>
		  		<div class="row">
		  			<div class="small-12 columns"><h6 class="clear-margin"><small>N3909</small></h6></div>
		  		</div>
		  		<div class="row">
		  			<div class="small-12 columns"><h6 class="clear-margin"><small>Tels: no</small></h6></div>
		  		</div>

			  	<div class="row">
			  		<div class="large-4 columns">Ver Mas</div>
			  		<div class="large-4 columns">Insertar al mapa</div>
			  		<div class="large-4 columns">Como llegar?</div>
			  	</div>

		  	</div>		
		</div>
		<a class="close-reveal-modal">&#215;</a>
		<?php
		die();	
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