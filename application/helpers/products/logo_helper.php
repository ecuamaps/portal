<?php
if (!defined('BASEPATH'))exit ('No direct script access allowed');

function show_logo($post_id){
	$CI = & get_instance();
	$CI->load->model('media');
	
	if($logo = $CI->media->select(array('post_id' => $post_id, 'type' => 'logo', 'state' => 1))){
		$logo = $logo[0];
		$logo_url = ci_config('media_server_show_url').'/'.$logo->hash;
		?>
		<img src="<?= $logo_url ?>"  width="80" height="80">
		<?php
	}else{
		no_logo_icon(80, 80);
	}
}