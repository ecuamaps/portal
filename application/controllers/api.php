<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->lang->load('api');
		$this->load->model('business_model');
	}
	
	function search(){
		
		//Get the search params
		$text = $this->input->post('text', TRUE);
		
		$distance = $this->input->post('distance', TRUE);
		$start = $this->input->post('start', TRUE);
		$start = $start ? $start : 0;
		$rows = $this->input->post('rows', TRUE);
		$post_type = $this->input->post('post_type', TRUE);
		$post_type = ($post_type != 'all') ? $post_type : NULL;
		$lat = $this->input->post('lat', TRUE);
		$lng = $this->input->post('lng', TRUE);

		$options = ci_config('solr_options');
		extract($options);
		
		$q = search_query($text, $post_type);
		$query = array(
			'q' => $q,
			'sort' => 'score desc,score_avg desc,geodist() asc', 
			'start' => $start, 
			'rows' => $rows, 
			'fl' => '*,score,_dist_:geodist()', 
			'df' => 'tags',
			'wt' => 'json', 
			'indent' => 'true', 
			'spatial' => 'true', 
			'pt' => $lat.','.$lng, 
			'sfield' => 'location', 
			'd' => $distance, 
		);
		
		$url = $protocol.'://'.$hostname.':'.$port.'/'.$path.'/select?'.http_build_query($query);
		$json = $this->curl->simple_get($url);

		$results = json_decode($json);
		//echo '<pre>',print_r($json),'</pre>';
		$docs = $results->response->docs;
		
		header('Content-Type: text/html');
		?>
		<h4><small><?= sprintf(lang('search.resultstitle'), $results->response->numFound) ?>:</small></h4>

		<div class="pagination-centered">
		  <ul class="pagination">
		    <li class="arrow unavailable"><a href="">&laquo;</a></li>
		    <li class="current"><a href="">1</a></li>
		    <li><a href="">2</a></li>
		    <li><a href="">3</a></li>
		    <li><a href="">4</a></li>
		    <li><a href="">5</a></li>
		    <li class="unavailable"><a href="">&hellip;</a></li>
		    <li class="arrow"><a href="">&raquo;</a></li>
		  </ul>
		</div>
		
		<div class="row full-width" id="results-wrapper">
			<? foreach($docs as $d): ?>
			<?
				$distance = (float) $d->_dist_;
				$unit = 'Km';
				if($distance < 1){
					$distance = $distance * 1000;
					$unit = 'Mts';
				}
				
				$distance = number_format($distance, 2).$unit;								
				
				$score_avg = number_format($d->score_avg, 2);
				
				//Load the types
				$types = $this->business_model->get_biz_types($d->id);
				$main_type = isset($types[0]) ? $types[0] : NULL;
				
				foreach($types as $t){
					$tmp[] = $t->name;
				}
				
				$str_types = implode(', ', $tmp);
				$tmp = array();
				
				//var_dump($types);
			?>
			
			<div class="panel" id="<?= $d->id ?>">
			  	<input type="hidden" name="<?= $d->id ?>-lat"  value="<?= $d->location_0_coordinate ?>" />
			  	<input type="hidden" name="<?= $d->id ?>-lng"  value="<?= $d->location_1_coordinate ?>" />
			  	<input type="hidden" name="<?= $d->id ?>-inmap"  value="0" />

			  	<div class="row">
					<div class="large-9 columns">
						<div class="row">
							<div class="large-3 columns"><h5 class="clear-margin"><small><?= $distance ?></small></h5></div>
							<div class="large-9 columns">
								<h6 class="clear-margin"><?= ucfirst($d->name) ?></h6>
								<h6 class="clear-margin"><small><?= $str_types ?></small></h6>
							</div>
						</div>
						<div class="row">
							<div class="large-3 columns"><h5 class="clear-margin"><small><?= lang('search.score') ?>: <?= $score_avg ?></small></h5></div>
							<div class="large-9 columns">
								<h6 class="clear-margin"><small><?= ucfirst($d->content) ?></small></h6>
								<h6 class="clear-margin"><small><?= ucfirst($d->address) ?></small></h6>
								<h6 class="clear-margin"><small><?= lang('search.phone') ?>: <?= $d->phones ?></small></h6>
							</div>						
						</div>
					</div>
					<div class="large-3 columns">
						<div class="row"><a href="#" class="">Ver Mas</a></div>
						<div class="row"><a href="#" class="qualify-post">Calificar</a></div>
						<div class="row"><a href="javascript:set_directions('<?= $d->location_0_coordinate ?>', '<?= $d->location_1_coordinate ?>', <?= $d->_dist_ ?>)" class=""><?= lang('search.howtoget') ?></a></div>
					</div>
				</div>			  	
			</div>
			<? endforeach; ?>
		</div>

		<div class="pagination-centered">
		  <ul class="pagination">
		    <li class="arrow unavailable"><a href="">&laquo;</a></li>
		    <li class="current"><a href="">1</a></li>
		    <li><a href="">2</a></li>
		    <li><a href="">3</a></li>
		    <li><a href="">4</a></li>
		    <li><a href="">5</a></li>
		    <li class="unavailable"><a href="">&hellip;</a></li>
		    <li class="arrow"><a href="">&raquo;</a></li>
		  </ul>
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
		return $this->business_model->get_types(false);
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
	
	function test($id){
		$this->business_model->syncronize($id);
	}
}