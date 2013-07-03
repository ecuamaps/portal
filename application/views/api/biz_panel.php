<h4><?=$biz->name?></h4>

<div class="section-container auto" data-section>
  <section>
    <p class="title" data-section-title><a href="#panel1"><?=lang('bizpanel.tab1')?></a></p>
    <div class="content" data-section-content>
		<div class="row hide" id="updatebiz-error-wrapper">
			<div data-alert class="alert-box alert">
	  			<span id="updatebiz-error-msg"></span>
			</div>
		</div>

    	<?= form_open('account/update_business', array('id' => 'addbiz-form-upd', 'class' => '')) ?>
    	
    	<? show_biz_form($biz) ?>

	    <div class="row">
	      <div class="large-12 columns">&nbsp;</div>
	    </div>

	    <div class="row">
	      <div class="large-12 columns">
			<a href="javascript:void(0)" id="bizpanel-update" class="tiny button"><?=lang('bizpanel.btn.update')?></a>
	      </div>
	    </div>
    	
    	</form>
    	
    </div>
  </section>
  <section>
    <p class="title" data-section-title><a href="#panel2" id="bizpanel-tab2"><?=lang('bizpanel.tab2')?></a></p>
    <div class="content" data-section-content>
      <p>Content of section 2.</p>
    </div>
  </section>
</div>

<a class="close-reveal-modal">&#215;</a>

<script>
	
	$(document).ready(function(){
			
		$('#bizpanel-tab2').click(function(e){
			console.log('hello');
		});
		
		$('#bizpanel-update').click(function(e){
			var url = $('#addbiz-form-upd').attr('action');
			var bz_type = $('select[name="bz-type"]').val();
			var name = $('input[name="bz-name"]').val();
			var lat = $('input[name="bz-lat"]').val();
			var lng = $('input[name="bz-lng"]').val();
			var email = $('input[name="bz-email"]').val();
			var emailReg = /^[a-zA-Z0-9._-]+([+][a-zA-Z0-9._-]+){0,1}[@][a-zA-Z0-9._-]+[.][a-zA-Z]{2,6}$/;
			
			
			if(!name || !lat || !lng || !bz_type){
				$('#updatebiz-error-msg').html('<?=lang('createbiz.error.requiredfields')?>');
				$('#updatebiz-error-wrapper').show();
				return false;
			}
			
			if (email && !emailReg.test(email)) {
				$('#updatebiz-error-msg').html('<?=lang('createbiz.error.emailformat')?>');
				$('#updatebiz-error-wrapper').show();
					return false;
			}
			
	        $.ajax({
	            type : "POST",
	            url : url,
	            dataType : "json",
	            data : {
	            	user_id: <?=$user->id?>,
	            	bz_id : $('input[name="bz-id"]').val(),
					bz_type_id : $('select[name="bz-type"]').val(),
					bz_name : $('input[name="bz-name"]').val(),
					bz_desc : $('input[name="bz-desc"]').val(),
					bz_addr : $('input[name="bz-addr"]').val(),
					bz_phones : $('input[name="bz-phones"]').val(),
					bz_ceo : $('input[name="bz-ceo"]').val(),
					bz_email : $('input[name="bz-email"]').val(),
					bz_lat : $('input[name="bz-lat"]').val(),
					bz_lng : $('input[name="bz-lng"]').val(),
					hms1 : $('input[name="hms1"]').val()
	            }
	        }).done(function(response) {
	        	if(response.status == 'ok'){
					alert(response.msg);
	        	}
	        });
			
		});
			
	});
	</script>  