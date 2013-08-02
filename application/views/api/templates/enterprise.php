<?
	$distance = (float) $d->_dist_;
	$unit = 'Km';
	if($distance < 1){
		$distance = $distance * 1000;
		$unit = 'Mts';
	}
		
	$distance = number_format($distance, 2).$unit;								
	
	$score_avg = number_format($d->score_avg, 2);
		
	//Load the types
	$types = $this->business_model->get_biz_types($d->id);
	$main_type = isset($types[0]) ? $types[0] : NULL;
	
	$tmp = array();
	foreach($types as $t){
		$tmp[] = $t->name;
	}
			
	$str_types = implode(', ', $tmp);
	$tmp = array();

	$post = $this->business_model->get_by_id($d->id);
	$post->last_update = isset($post->last_update) ? $post->last_update : '';
?>

			<h4 class="subheader clear-margin"><?= $index.'. '.ucwords($d->name) ?></h4>
			<h6 class="clear-margin font-weight-normal line-height-08"><small><?= $str_types ?></small></h6>
			<h5 class="clear-margin font-weight-normal line-height-08 margin-bottom-5px"><small><?= lang('search.distance') ?>: <?= $distance ?>, <?= lang('search.score') ?>: <?= $score_avg ?>, ID: <?= $d->id ?>, <?= lang('search.lastupdate').': '.$post->last_update ?></small></h5>
			<div class="section-container auto" data-section>
				<section>
    				<p class="title" data-section-title><a href="#panel1"><?= lang('search.start') ?></a></p>
    				<div class="content" data-section-content>
						<div class="row">
							<div class="large-4 columns">
								<nav class="breadcrumbs">
								  <a href="javascript:void(0)" post-id="<?= $d->id ?>" class="qualify-post"><?= lang('search.review') ?></a>
								  <a href="javascript:void(0)" lat="<?= $d->location_0_coordinate ?>" lng="<?= $d->location_1_coordinate ?>" dist="<?= $d->_dist_ ?>" class="set-directions"><?= lang('search.howtoget') ?></a>
								</nav>
							</div>
						</div>
						<div class="row">&nbsp;</div>	  	
					  	<div class="row">
							<div class="large-9 columns">
								<div class="row">
									<div class="large-2 columns"><? show_logo($d->id) ?></div>
									<div class="large-10 columns">
										<h6 class="clear-margin font-weight-normal"><small><?= show_extrainfo($d->id) ?></small></h6>
										<h6 class="clear-margin font-weight-normal"><small><?= ucfirst($d->address) ?></small></h6>
										<h6 class="clear-margin font-weight-normal"><small><?= lang('search.phone') ?>: <?= $d->phones ?>, <?= phones_show($d->id) ?></small></h6>									
									</div>
								</div>
							</div>
							<div class="large-3 columns">
								<div class="row"></div>
								<div class="row"></div>
							</div>
						</div>
    				</div>
  				</section>
  				
  				 <section>
				    <p class="title" data-section-title><a href="#panel2" class="enterprise-panel2" id="<?=$d->id?>"><?= lang('search.more') ?></a></p>
				    <div class="content" data-section-content id="section-content-<?=$d->id?>"></div>
 				</section>
				
				<?= show_promos($d->id) ?>
			</div>