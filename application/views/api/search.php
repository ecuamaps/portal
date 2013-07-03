		<? header('Content-Type: text/html'); ?>  
  
		<h4><small><?= sprintf(lang('search.resultstitle'), $results->response->numFound) ?>:</small></h4>
		
		<? if($results->response->numFound): ?>
		<div class="row full-width">
			<div class="large-5 columns">
			<dl class="sub-nav" id="sort-wrapper">
			  <dt><?=lang('dashboard.searchform.sortby')?>:</dt>
			  <dd id="score-dd"><a href="javascript:void(0)" class="sort-onresults-option" id="score"><?=lang('dashboard.searchform.sortby.score')?></a></dd>
			  <dd id="score_avg-dd"><a href="javascript:void(0)" class="sort-onresults-option" id="score_avg"><?=lang('dashboard.searchform.sortby.scoreavg')?></a></dd>
			  <dd id="geodist-dd"><a href="javascript:void(0)" class="sort-onresults-option" id="geodist"><?=lang('dashboard.searchform.sortby.distance')?></a></dd>
			</dl>			
			</div>
    	</div>
		<? endif; ?>
		
		<?= pagination($start, $rows, $numFound) ?>
		
		<div class="row full-width" id="results-wrapper">
			<? foreach($docs as $index => $d): ?>
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
			<h4 class="subheader clear-margin"><?= ($start + $index + 1).'. '.ucfirst($d->name) ?></h4>
			<h6 class="clear-margin font-weight-normal line-height-08"><small><?= $str_types ?></small></h6>
			<h5 class="clear-margin font-weight-normal line-height-08 margin-bottom-5px"><small><?= lang('search.distance') ?>: <?= $distance ?>, <?= lang('search.score') ?>: <?= $score_avg ?></small></h5>
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
									<div class="large-2 columns"><?no_logo_icon(80, 80)?></div>
									<div class="large-10 columns">
										<h6 class="clear-margin font-weight-normal"><small><?= ucfirst($d->content) ?></small></h6>
										<h6 class="clear-margin font-weight-normal"><small><?= ucfirst($d->address) ?></small></h6>
										<h6 class="clear-margin font-weight-normal"><small><?= lang('search.phone') ?>: <?= $d->phones ?></small></h6>									
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
				    <p class="title" data-section-title><a href="#panel2"><?= lang('search.more') ?></a></p>
				    <div class="content" data-section-content>
				      <p>Extra info: photos, videos, links, prices, etc</p>
				    </div>
 				</section>

 				
			</div>
			
			<? endforeach; ?>
		</div>
		
		<?= pagination($start, $rows, $numFound) ?>
		
		<a class="close-reveal-modal">&#215;</a>

		<script>		
		<? if($results->response->numFound): ?>
			var posts = {}; 
			<? foreach($scores as $id => $s): ?>
			posts[<?=$id?>] = <?=$s?>;<?="\n"?>
			<? endforeach; ?>

			$('.qualify-post').click(function(e){
				e.preventDefault();
				var post_id = $(this).attr('post-id');
				var post = posts[post_id];
    			
    			$('#post_id').val(post_id);
    			$('#qf-post-name').html(post.name);
    			
    			$('#search-result-wrapper').foundation('reveal', 'close');    			
    			$('#add-qualification-wrapper').foundation('reveal', 'open');
    		});
			
			$('.goto-page').click(function (e){
				e.preventDefault();
				
				var start = parseInt($(this).attr('start'));
				
				$('input[name="search-start"]').val(start);
				search(false);
			})
			
			$('.sort-onresults-option').click(function(e){
				var value = $(this).attr('id');
				var active = value + '-dd';
				
				$('#sort-wrapper dd').each(function(index, elem){
					$(elem).removeClass('active');
				});
				
				$('#' + active).addClass('active');
				
				change_sort(value);		
			});
			
			highlightcurrentsort();
			
			function highlightcurrentsort(){
				$('#sort-wrapper dd').each(function(index, elem){
					$(elem).removeClass('active');
				});
				
				var active = '<?=$sort?>';
				active = active + '-dd';
				$('#' + active).addClass('active');	
			}
			
		<? endif; ?>
		
			$('.set-directions').click(function(e){
				e.preventDefault();
				var lat = $(this).attr('lat');
				var lng = $(this).attr('lng');
				var d = $(this).attr('dist');
				console.log(lat);
				set_directions(lat, lng, d);
				$('#add-qualification-wrapper').foundation('reveal', 'close');
			})
		</script>
		