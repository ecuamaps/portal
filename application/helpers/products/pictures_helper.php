<?php if (!defined('BASEPATH'))exit ('No direct script access allowed');

function pictures_show($post_id){
	$CI = & get_instance();
	$CI->load->model('media');
	$pics = $CI->media->select(array('post_id' => $post_id));
	
	if(!count($pics))
		return NULL;
	
	$html[] = '<script src="'.base_url().'assets/galleria/galleria-1.2.9.min.js"></script>';
	$html[] = '<style>#galleria{height:320px}</style>';
	
	$html[] = '<div id="galleria">';
	foreach($pics as $p){
		$url = ci_config('media_server_show_url').'/'.$p->hash;
		$html[] = '<a href="'.$url.'"><img src="'.$url.'"></a>';
	}
	$html[] = '</div>';
	
	$html[] = '<script>' .
			'$(document).ready(function(){' .
				'Galleria.loadTheme("'.base_url().'assets/galleria/themes/classic/galleria.classic.min.js");' .
				'Galleria.run("#galleria");}' .
			');' .
			'</script>';
	return implode("\n", $html);	
}
