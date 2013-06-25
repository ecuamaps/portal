<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Model {


	function __construct(){
		parent::__construct();
	}
	
	function get_posts_types(){
		$this->db->order_by('id');
		return $this->db->get('post_type')->result();
	}
	
}