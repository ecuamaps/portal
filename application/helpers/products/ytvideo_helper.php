<?php if (!defined('BASEPATH'))exit ('No direct script access allowed');

function ytvideo_show($post_id){
	$CI = & get_instance();
	$CI->load->model('business_model');	
	
	$ytvideo_prod_id = ci_config('ytvideo_product_id');

	//Load the product specs
	$prodcts = $CI->business_model->get_products($post_id);

	$ytvideos = array();
	foreach($prodcts  as $p){
		if(in_array($p->product_id, $ytvideo_prod_id)){
			$i_data = unserialize($p->implementation_data);
			if(isset($i_data['ytvideo']) && $i_data['ytvideo'])
				$ytvideos[] = $i_data['ytvideo'] ;
		}
	}
	
		
	ob_start();
	
	?>
	
	<script>
		
		//var galleria_<?=$post_id?> = null;
		
		Galleria.ready(function(options) {

		});
		
		$(document).ready(function(){
			//galleria_<?=$post_id?> = Galleria.run("#galleria-<?=$post_id?>", {});
			console.log(Galleria.get());
		});
	</script>
	
	<?php
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
}
