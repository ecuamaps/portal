<?php if (!defined('BASEPATH'))exit ('No direct script access allowed');

function pictures_show($post_id){
	$CI = & get_instance();
	$CI->load->model('media');
	$pics = $CI->media->select(array('post_id' => $post_id));
	
	if(!count($pics))
		return NULL;
	
	$html[] = '<div id="galleria-'.$post_id.'" style="height:320px">';
	foreach($pics as $p){
		$url = ci_config('media_server_show_url').'/'.$p->hash;
		$html[] = '<a href="'.$url.'"><img src="'.$url.'"></a>';
	}
	$html[] = '</div>';
	
	$html[] = '<script>' .
			'$(document).ready(function(){' .
				'Galleria.run("#galleria-'.$post_id.'");}' .
			');' .
			'</script>';
	return implode("\n", $html);	
}
