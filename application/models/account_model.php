<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {


	function __construct(){
		parent::__construct();
	}
	
	function auth($enterprise_id, $username, $password){

		
				
		if(!$enterprise_id || !$username || !$password)
			return false;
		
		$password = md5($password);
		
		$sql = "SELECT * FROM user WHERE enterprise_id = $enterprise_id AND username='$username' AND password='$password'";
		$user = $this->db->query($sql)->result();
		if(count($user))
			return $user[0];
			
		return false; 
	}	
}