<?= form_open_multipart('products/logo/update', array('id' => 'form-product-logo', 'class' => '')) ?>
	<input type="hidden" name="media_id" <?=isset($logo_id) ? 'value="'.$logo_id.'"' : ''?>/>
	<div class="row">
	  <div class="large-2 columns" id="logo-output">
		<? if(isset($logo_url)): ?>
		  	<img src="<?= $logo_url ?>"  width="100" height="100">
		  <? else: ?>
		  	<?no_logo_icon(100, 100)?>
		<? endif; ?> 
	  </div>
	
		<div class="large-5 columns" id="process-inputs-1">
			<input type="file" name="logo" id="logo" />
		</div>
	
		<div class="large-2 columns" id="process-inputs-2">
			<a href="javascript:void(0)" id="upload-logo-button" class="small button disabled" ><?=lang('logo.upload')?></a>
		</div>

		<div class="large-3 columns" id="loading">
			<img src="assets/images/loading.gif">
		</div>
		
	</div>
</form>

<script>
	
	$(document).ready(function(){
		
		$("#loading").hide();
		
		$('#logo').change(function() {
			if($(this).val())
				$('#upload-logo-button').removeClass("small button disabled").addClass("small button");
		});
		
		
		$('#upload-logo-button').click(function(e){
			e.preventDefault();
			
			if($('#logo').val()){
				ajaxFileUpload();
			}
			
		});
	});

	function ajaxFileUpload()
	{
		$("#loading").show();
		$("#process-inputs-1, #process-inputs-2").hide();
		
		$.ajaxFileUpload
		(
			{
				url:'<?=current_lang()?>/products/logo/upload',
				secureuri:false,
				fileElementId:'logo',
				dataType: 'json',
				data:{
					post_id: <?=$post->id?>,
					user_id: <?=$user->id?>,
					media_id: $('input[name="media_id"]').val(),
					hms1: $('input[name="hms1"]').val()
				},
				success: function (data, status){
					$("#loading").hide();
					$("#process-inputs-1, #process-inputs-2").show();
					$('#logo').val('');
					$('#logo-output').html('<img src="' + data.url + '" width="100" height="100" >');
					$('input[name="media_id"]').val(data.media_id);
					alert(data.msg);			
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

	}
	
</script>
