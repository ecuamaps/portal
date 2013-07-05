<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logo extends CI_Controller {
	
	var $params = array();
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('post');
		$this->lang->load('products/logo');
	}
	
	function index(){
		$post_id = $this->input->get('post_id');
		
		//Load the current logo
		$this->params['post'] = $this->post->get_by_id($post_id);
		
		$this->load->view('products/logo/index', $this->params);
		
	}
}