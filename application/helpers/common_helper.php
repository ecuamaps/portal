<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_domain(){
	$CI =& get_instance();
	$bar_url_pieces = explode('.', $CI->config->item('base_url'));
	$domanin = str_replace(array('http://', 'https://'), '', strtolower($bar_url_pieces[0]));
	return $domanin;
}

function get_user_config(){
	$CI =& get_instance();
	return $CI->session->userdata('user_config');	
}

function check_feature($feature){
	
	$user_config = get_user_config();
	
	return in_array($feature, $user_config['features']);
}