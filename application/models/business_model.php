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
		
		//Syncronize in solr
		$this->syncronize($bz_id);
		
		return $bz_id;
	}
	
	function get_top_5_biz_types(){
		$sql = "SELECT * FROM biz_type ORDER BY hits LIMIT 5";
		$types = $this->db->query($sql)->result();

		if(count($types))
			return $types;
		
		return null;			
	}
	
	/*Sync the biz to solr*/
	function syncronize($id){
		//Get the post
		$post = $this->db->get_where('post', array('id' => $id))->result();
		if(!count($post))
			return false;
		
		$post = $post[0];
		
		//Get the metas
		$metas_obj = $this->db->get_where('postmeta', array('post_id' => $id))->result();
		if(!count($metas_obj))
			return false;
		
		foreach($metas_obj as $m){
			$metas[$m->meta_key] = $m->meta_value;
		}
		
		//Set the text fields
		$phones = isset($metas['phones']) ? ' '.$metas['phones'] : '';
		$address = isset($metas['address']) ? ' '.$metas['address'] : '';
		$CEO = isset($metas['CEO_name']) ? ' '.$metas['CEO_name'] : '';
		$email = isset($metas['CEO_email']) ? ' '.$metas['CEO_email'] : '';

		//Get the post type name
		$post_type = $this->db->get_where('post_type', array('id' => $post->post_type_id))->result();
		
		//Solr data
		$data = array(
			'id' => $id,
			'name' => $post->name,
			'tags' => $post->tags,
			'content' => $post->content,
			'post_type_es' => $post_type[0]->name_es,
			'post_type_en' => $post_type[0]->name_en,
			'location' => "{$metas['lat']},{$metas['lng']}",
			'phones' => $phones,
			'address' => $address,
			'ceo' => $CEO,
			'email' => $email,
			'score_avg' => $post->score_avg
		);
		
		solr_syncronize($data);
		return true;	
	}
	
	function get_biz_types($id){
		$sql = "SELECT bt.* FROM post_biz_types pbt, biz_type bt WHERE pbt.post_id=$id AND pbt.biz_type_id=bt.id ORDER BY name";
		return $this->db->query($sql)->result();
	}
	
}