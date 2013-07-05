<? header('Content-Type: text/html'); ?>

<? if(count($products)): ?>

<div class="section-container auto" data-section="auto">
  <? foreach($products as $index => $p): ?>
  <? $panel_id =  $index + 1; ?>
  <section>
    <p class="title" data-section-title><a href="#panel<?=$panel_id?>" id="link-product-setup-<?= $p->id ?>"  ><?= $p->name ?></a></p>
    <div class="content" data-section-content id="<?= $p->id ?>"></div>
  </section>
  <script>
  	$(document).ready(function(){
  		$('#link-product-setup-<?= $p->id ?>').click(function(e){
  			load_product_setup('<?= $p->helper_file ?>', '<?= $p->id ?>');
  		})
  	});
  </script>
  <? endforeach; ?>  
</div>

  <script>
	function load_product_setup(controller, wrapper_id){
		var post_id = <?= $post_id ?>;
		
		$.ajax({
            type : "GET",
            url : '<?=current_lang()?>/products/' + controller,
            dataType : "html",
            data : {
            	post_id : post_id
            }
        }).done(function(response) {
			$('#' + wrapper_id).html(response);	
        });				
		
	}
  </script>

<? else: ?>
	<h3><?=lang('bizpanel.setup.noproducts')?></h3>
	<a href="javascript:void(0)" class="small button"><?=lang('bizpanel.setup.addproducts')?></a>
<? endif; ?>