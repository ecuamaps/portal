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
			<? $index = $start + 1?>
			<? foreach($docs as $i => $d): ?>
			<? $this->view('api/templates/'.$d->post_type_en, array('d' => $d, 'index' => $index)); ?>	
			<? $score_avg = number_format($d->score_avg, 2);
				$scores[$d->id] = '{id: '.$d->id.', name: "'.ucfirst($d->name).'", score_avg: '.$score_avg.'}'; 
				$index ++;
			?>		
			<? endforeach; ?>
		</div>
		
		<input type="hidden" name="serach-results-orderby" />
		<?= pagination($start, $rows, $numFound) ?>
		
		<a class="close-reveal-modal">&#215;</a>

		<script>		
		<? if($results->response->numFound): ?>
			var posts = {}; 
			<? foreach($scores as $id => $s): ?>
			posts[<?=$id?>] = <?=$s?>;<?="\n"?>
			<? endforeach; ?>
			
			var orderby = '<?=$sort?>';
			
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

				search(false, orderby);
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
		