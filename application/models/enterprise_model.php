<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enterprise_model extends CI_Model {


	function __construct(){
		parent::__construct();
	}
	
	function get_by_domain($domain){
		
		if(!$domain)
			return null;
		
		$sql = "SELECT e.* FROM domain d, enterprise e WHERE d.domain='$domain' AND d.enterprise_id=e.id;";
		$enterprise = $this->db->query($sql)->result();
		return $enterprise; 
	}	
}