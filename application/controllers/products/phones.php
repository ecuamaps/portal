<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Phones extends CI_Controller {
	
	var $params = array();
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('post');
		$this->load->model('business_model');
		$this->lang->load('products/logo');
	}
	
	
	function index(){
		$post_id = $this->input->get('post_id');
		$post_product_id = $this->input->get('post_product_id');
		
		//Load the current post
		$this->params['post'] = $this->post->get_by_id($post_id);

		//Load the product specs
		$prodcts = $this->business_model->get_products($post_id);
		$product = null;
		foreach($prodcts  as $p){
			if($post_product_id == $p->id){
				$product = $p;
				break;
			}
		}
		$this->params['product'] = $product;
		
		$implementation_data = unserialize($product->implementation_data);
		
		var_dump($implementation_data);
		
		$this->params['user'] = $this->session->userdata('user');
		
		//$this->load->view('products/phones/index', $this->params);
	}
	
	function save(){

		$post_id = $this->input->post('post_id', TRUE); 
		$user_id = $this->input->post('user_id', TRUE);
		$bz_product_id = $this->input->post('bz_product_id', TRUE);
		
	   
	   	die( json_encode(array('status' => 'success', 'msg' => lang('logo.upload.success'), 'media_id' => $id, 'url' => $url)));
	}
}