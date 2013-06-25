<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_model extends CI_Model {

	
	private $post_type = 1;
	
	function __construct(){
		parent::__construct();
	}
	
	function get_types($get_all = true){
		
		$exclude_top5 = '';
		if(!$get_all){
			$top5 = $this->get_top_5_biz_types();
			foreach($top5 as $t){
				$tp[] = $t->id;
			}
			$exclude_top5 = " WHERE id NOT IN (".implode(',', $tp).") ";
		}
			
		$sql = "SELECT * FROM biz_type $exclude_top5 ORDER BY name";
			
			
		$types = $this->db->query($sql)->result();

		if(count($types))
			return $types;
		
		return null;
	}
	function get_type_by_id($id){
		$sql = "SELECT * FROM biz_type WHERE id=$id";
		$types = $this->db->query($sql)->result();

		if(count($types))
			return $types[0];
		
		return null;		
	}
	
	function create($data){
		
		//Create the post
		$bz = array(
			'post_type_id' => $this->post_type,
			'user_id' => $data['user_id'],
			'name' => $data['name'],
			'content' => $data['description'],
			'creation' => date('Y-m-d'),
			'last_update' => date('Y-m-d'),
			'tags' => $data['bz_type_name'],
			'state' => 'I'
		);
		
		if(!$this->db->insert('post', $bz)){
			return false;
		}
		
		$bz_id = $this->db->insert_id();
		
		//Add metafields
		$metas = array(
			'address' => $data['address'],
			'lat' => $data['lat'],
			'lng' => $data['lng'],
			'phones' => $data['phones'],
			'CEO_name' => $data['CEO_name'],
			'CEO_email' => $data['CEO_email'],
		);
		
		foreach($metas as $index => $value){
			$this->db->insert('postmeta', array('post_id' => $bz_id, 'meta_key' => $index,'meta_value' => $value));
		}
		
		//Create the bz_type relationship
		$bz_type_rel = array(
			'post_id' => $bz_id,
			'biz_type_id' => $data['bz_type_id']
		);
		if(!$this->db->insert('post_biz_types', $bz_type_rel)){
			return false;
		}
		
		return $bz_id;
	}
	
	function get_top_5_biz_types(){
		$sql = "SELECT * FROM biz_type ORDER BY hits LIMIT 5";
		$types = $this->db->query($sql)->result();

		if(count($types))
			return $types;
		
		return null;			
	}
	
	function update_search_engine(){
		
	}
	
}