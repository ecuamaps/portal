		<? header('Content-Type: text/html'); ?>  
  
		<h4><small><?= sprintf(lang('search.resultstitle'), $results->response->numFound) ?>:</small></h4>

		<div class="pagination-centered">
		  <ul class="pagination">
		    <li class="arrow unavailable"><a href="">&laquo;</a></li>
		    <li class="current"><a href="">1</a></li>
		    <li><a href="">2</a></li>
		    <li><a href="">3</a></li>
		    <li><a href="">4</a></li>
		    <li><a href="">5</a></li>
		    <li class="unavailable"><a href="">&hellip;</a></li>
		    <li class="arrow"><a href="">&raquo;</a></li>
		  </ul>
		</div>
		
		<div class="row full-width" id="results-wrapper">
			<? foreach($docs as $d): ?>
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
				
				foreach($types as $t){
					$tmp[] = $t->name;
				}
				
				$str_types = implode(', ', $tmp);
				$tmp = array();
				
				$scores[$d->id] = '{id: '.$d->id.', name: "'.ucfirst($d->name).'", score_avg: '.$score_avg.'}';
			?>
			<h4 class="subheader"><?= ucfirst($d->name) ?></h4>
			<div class="section-container auto" data-section>
				<section>
    				<p class="title" data-section-title><a href="#panel1">Basic</a></p>
    				<div class="content" data-section-content>
					  	<input type="hidden" name="<?= $d->id ?>-lat"  value="<?= $d->location_0_coordinate ?>" />
					  	<input type="hidden" name="<?= $d->id ?>-lng"  value="<?= $d->location_1_coordinate ?>" />
					  	<input type="hidden" name="<?= $d->id ?>-inmap"  value="0" />
					  	<div class="row">
							<div class="large-9 columns">
								<div class="row">
									<div class="large-3 columns"><h5 class="clear-margin"><small><?= $distance ?></small></h5></div>
									<div class="large-9 columns">
										<h6 class="clear-margin"><?= ucfirst($d->name) ?></h6>
										<h6 class="clear-margin"><small><?= $str_types ?></small></h6>
									</div>
								</div>
								<div class="row">
									<div class="large-3 columns"><h5 class="clear-margin"><small><?= lang('search.score') ?>: <?= $score_avg ?></small></h5></div>
									<div class="large-9 columns">
										<h6 class="clear-margin"><small><?= ucfirst($d->content) ?></small></h6>
										<h6 class="clear-margin"><small><?= ucfirst($d->address) ?></small></h6>
										<h6 class="clear-margin"><small><?= lang('search.phone') ?>: <?= $d->phones ?></small></h6>
									</div>						
								</div>
							</div>
							<div class="large-3 columns">
								<div class="row"><a href="javascript:void(0)" post-id="<?= $d->id ?>" class="qualify-post"><?= lang('search.review') ?></a></div>
								<div class="row"><a href="javascript:set_directions('<?= $d->location_0_coordinate ?>', '<?= $d->location_1_coordinate ?>', <?= $d->_dist_ ?>)" class=""><?= lang('search.howtoget') ?></a></div>
							</div>
						</div>			  	
    				</div>
  				</section>
  				
  				 <section>
				    <p class="title" data-section-title><a href="#panel2"><?= lang('search.more') ?></a></p>
				    <div class="content" data-section-content>
				      <p>Extra info: photos, videos, links, prices, etc</p>
				    </div>
 				</section>

 				
			</div>
			
			<? endforeach; ?>
		</div>

		<div class="pagination-centered">
		  <ul class="pagination">
		    <li class="arrow unavailable"><a href="">&laquo;</a></li>
		    <li class="current"><a href="">1</a></li>
		    <li><a href="">2</a></li>
		    <li><a href="">3</a></li>
		    <li><a href="">4</a></li>
		    <li><a href="">5</a></li>
		    <li class="unavailable"><a href="">&hellip;</a></li>
		    <li class="arrow"><a href="">&raquo;</a></li>
		  </ul>
		</div>

		<a class="close-reveal-modal">&#215;</a>
		
		<? if($results->response->numFound): ?>
		<script>
			var posts = {}; 
			<? foreach($scores as $id => $s): ?>
			posts[<?=$id?>] = <?=$s?>;<?="\n"?>
			<? endforeach; ?>

			$('.qualify-post').click(function(e){
				var post_id = $(this).attr('post-id');
				var post = posts[post_id];
    			
    			$('#post_id').val(post_id);
    			$('#qf-post-name').html(post.name);
    			
    			$('#search-result-wrapper').foundation('reveal', 'close');    			
    			$('#add-qualification-wrapper').foundation('reveal', 'open');
    		});
			
		</script>
		<? endif; ?>		