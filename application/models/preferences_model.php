
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preferences_model extends CI_Model {


	function __construct(){
		parent::__construct();
	}
	
function get_all_preferences (){
 $sql = "SELECT * FROM preference order by name asc" ;
 $allpreferences = $this->db->query($sql)->result();
 
}

function get_user_preferences($email){
    $sql = "SELECT * FROM user_preference WHERE email='$email' ";
    $preferences = $this->db->query($sql)->result();
    if (count($preferences))
        return $preferences[0];
    return null;
  }

  
}
