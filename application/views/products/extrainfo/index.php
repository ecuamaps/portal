<?= form_open('products/extrainfo/save', array('id' => 'form-product-extrainfo-'.$bz_product_id, 'class' => '')) ?>
	<input type="hidden" name="bz_product_id" value="<?=$bz_product_id?>" />
 <fieldset>
    <legend><?=lang('extrainfo.title')?></legend>
    	<div class="row">
    		<div class="large-12 columns"><small><?=lang('extrainfo.disclaimer')?></small></div>
    	</div>
    	<div class="row">
    		<div class="large-12 columns">&nbsp;</div>
    	</div>
		<div class="row">
	      <div class="large-4 columns">
	        <textarea name="extrainfo-<?=$bz_product_id?>" id="extrainfo-<?=$bz_product_id?>"><?=$extrainfo?></textarea>
	        <small id="chcount-<?=$bz_product_id?>"></small>
	      </div>
	    </div>
	
 </fieldset>	
 <a href="#" class="small button" id="save-phones-<?=$bz_product_id?>"><?=lang('extrainfo.save')?></a>
</form>

<script>
	$(document).ready(function(){
		
		count_chars($('#extrainfo-<?=$bz_product_id?>'), $('#chcount-<?=$bz_product_id?>'), 100);
				
		$('#extrainfo-<?=$bz_product_id?>').keyup(function(event) {
			count_chars($(this), $('#chcount-<?=$bz_product_id?>'), 100);
		});
		
		$('#save-phones-<?=$bz_product_id?>').click(function(e){
			e.preventDefault();
			
			var text = $('#extrainfo-<?=$bz_product_id?>').val();
			text = trunkEmails(text);
			text = trunkUrls(text);
			$('#extrainfo-<?=$bz_product_id?>').val(text);
			
			$.ajax({
		        type : "POST",
		        url : $('#form-product-extrainfo-<?=$bz_product_id?>').attr('action'),
		        dataType : "json",
		        data : {
		        	post_id : <?=$post->id?>,
		        	bz_product_id : <?=$bz_product_id?>,
		            extrainfo : text,
		            hms1 : $('input[name="hms1"]').val()
		        }
		    }).done(function(response) {
		        alert(response.msg);
		    });

		});
	
	});
	

</script>