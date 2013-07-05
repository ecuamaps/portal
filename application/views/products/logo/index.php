<div class="row">
  <div class="small-6 small-centered columns">
	<ul class="small-block-grid-2">
	<? if(isset($post->logo)): ?>
	  <li><img src="<?=$post->logo?>"></li>
	  <? else: ?>
	  <li><?no_logo_icon(100, 100)?></li>
	<? endif; ?>  
	</ul>  
  </div>
</div>

<div class="row">
  <div class="small-3 small-centered columns"></div>
</div>

<?= form_open_multipart('products/logo/update', array('id' => 'form-product-logo', 'class' => '')) ?>
	<div class="row">
	  <div class="small-6 small-centered columns">
	  	<input type="file" name="logo" id="logo" />
	  </div>
	</div>

	<div class="row">
	  <div class="small-6 small-centered columns"><a href="javascript:void(0)" id="upload-logo-button" class="small button disabled" ><?=lang('logo.upload')?></a></div>
	</div>
</form>

<script>
	
	$(document).ready(function(){
		
		$('#logo').change(function() {
			if($(this).val())
				$('#upload-logo-button').removeClass("small button disabled").addClass("small button");
		});
		
		
		$('#upload-logo-button').click(function(e){
			e.preventDefault();
			
			if($('#logo').val()){
				$('#form-product-logo').submit();
			}
			
		});
	});
</script>
