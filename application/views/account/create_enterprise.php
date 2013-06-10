<h4><?=lang('createbiz.title')?></h4>
<?= form_open('account/add_business', array('id' => 'addbiz-form', 'class' => '')) ?>

  <fieldset id="step1-wrapper">
    <legend><?=lang('createbiz.step1')?></legend>

	<div class="row hide" id="createbiz-error-wrapper">
		<div data-alert class="alert-box alert">
  			<span id="createbiz-error-msg"></span>
		</div>
	</div>

    <div class="row">
      <div class="large-4 columns">
        <label><?=lang('createbiz.name')?>*</label>
        <input type="text" name="bz-name" required/>
      </div>
      <div class="large-4 columns">
        <label><?=lang('createbiz.desc')?></label>
        <input type="text" name="bz-desc" placeholder="<?=lang('createbiz.desc.placeholder')?>" />
      </div>
      <div class="large-4 columns">
        <label><?=lang('createbiz.address')?></label>
        <input type="text" name="bz-addr" />        
      </div>
    </div>

    <div class="row">
      <div class="large-4 columns">
        <label><?=lang('createbiz.phones')?></label>
        <input type="text" name="bz-phones" />
      </div>
      <div class="large-4 columns">
        <label><?=lang('createbiz.CEO')?></label>
        <input type="text" name="bz-ceo" />
      </div>
      <div class="large-4 columns">
        <label><?=lang('createbiz.email')?></label>
        <input type="email" name="bz-email" />        
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns">
      	<label><?=lang('createbiz.map')?> <a href="javascript:void(0)" id="show-map" class="tiny button"><?=lang('createbiz.btn.showmap')?></a></label>
      	<input type="hidden" id="bz-lat" name="bz-lat" required/>
      	<input type="hidden" id="bz-lng" name="bz-lng" required/>
		<div id="map_addbiz" style=""></div> 
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns">&nbsp;</div>
    </div>

    <div class="row">
      <div class="large-12 columns">
		<a href="javascript:void(0)" id="step1-next" class="tiny button"><?=lang('createbiz.btn.next')?></a>
      </div>
    </div>
		
  </fieldset>

  <fieldset id="step2-wrapper">
    <legend><?=lang('createbiz.step2')?></legend>
	<h6 class="subheader"><?=lang('createbiz.step2.subheader')?></h6> <a href="javascript:void(0)" id="show-products" class="tiny button"><?=lang('createbiz.btn.showproducts')?></a>
	
    <div class="row" id="createbz-product-wrapper">


		<div class="section-container vertical-tabs" data-section="vertical-tabs">

		  <section>
		    <p class="title" data-section-title><a href="#">Section 1</a></p>
		    <div class="content" data-section-content>
		      <p>Content of section 1.</p>
		    </div>
		  </section>
		  <section>
		    <p class="title" data-section-title><a href="#">Section 2</a></p>
		    <div class="content" data-section-content>
		      <p>Content of section 2.</p>
		    </div>
		  </section>
		  <section>
		    <p class="title" data-section-title><a href="#">Section 3</a></p>
		    <div class="content" data-section-content>
		      <p>Content of section 3.</p>
		    </div>
		  </section>

		</div>



    </div>

    <div class="row">
      <div class="large-6 columns"><div style="float: right"><h3 class="subheader">Total:</h3></div></div>
      <div class="large-6 columns"><div style="float: right"><h2>$0</h2></div></div>
    </div>

    <div class="row">
      <div class="large-12 columns">
      	<a href="javascript:void(0)" id="step2-prev" class="tiny button"><?=lang('createbiz.btn.prev')?></a>
		<a href="javascript:void(0)" id="step2-next" class="tiny button"><?=lang('createbiz.btn.next')?></a>
      </div>
    </div>


  </fieldset>

  <fieldset id="step3-wrapper">
    <legend><?=lang('createbiz.step3')?></legend>
    <div class="row">
      <div class="large-12 columns">
        <label><?=lang('createbiz.step3.subheader')?></label>
        <textarea disabled style="height: 175px"><?=get_config_val('adding_bz_terms_n_cond_'.$this->lang->lang())?></textarea>
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns">
      	<label for="bz-accept"><input name="bz-accept" type="checkbox" id="bz-accept" > <?=lang('createbiz.accept')?></label>
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns">&nbsp;</div>
    </div>

    <div class="row">
      <div class="large-12 columns">
      	<a href="javascript:void(0)" id="step3-prev" class="tiny button"><?=lang('createbiz.btn.prev')?></a>
		<a href="javascript:void(0)" id="step3-post" class="tiny button success"><?=lang('createbiz.btn.post')?></a>
      </div>
    </div>

  </fieldset>
</form>
<a class="close-reveal-modal">&#215;</a>

<script>
var addbz_map;
var addbz_marker = null;
function mapInit() {
	var mapOpt = {
		zoom : 15,
		center : myLatlng,
		mapTypeId : google.maps.MapTypeId.ROADMAP,
		mapTypeControl : false,
		mapTypeControlOptions : {
			position : google.maps.ControlPosition.RIGHT_CENTER
		},
		panControl : false,
		scrollwheel : true,
		navigationControl : true,
		streetViewControl : false,
		zoomControlOptions : {
			style : google.maps.ZoomControlStyle.SMALL,
			position : google.maps.ControlPosition.RIGHT_CENTER
		},
		styles : styles
	};
 	
 	addbz_map = new google.maps.Map(document.getElementById('map_addbiz'), mapOpt);

	google.maps.event.addListener(addbz_map, 'click', function(event) {
		if(addbz_marker)
			addbz_marker.setMap(null);
			
		addbz_marker = new google.maps.Marker({
			position : event.latLng,
			map : addbz_map
		});
		addbz_map.setCenter(event.latLng);
		
		$('#bz-lat').val(event.latLng.lat());
		$('#bz-lng').val(event.latLng.lng());

	});
}

$(document).ready(function(){
	
	$('#step2-wrapper, #step3-wrapper, #step3-post, #createbz-product-wrapper').hide();
	
	$('#step1-next').click(function(e){
		e.preventDefault();		
		
		var name = $('input[name="bz-name"]').val();
		var lat = $('input[name="bz-lat"]').val();
		var lng = $('input[name="bz-lng"]').val();
		var email = $('input[name="bz-email"]').val();
		var emailReg = /^[a-zA-Z0-9._-]+([+][a-zA-Z0-9._-]+){0,1}[@][a-zA-Z0-9._-]+[.][a-zA-Z]{2,6}$/;
		
		
		if(!name || !lat || !lng){
			$('#createbiz-error-msg').html('<?=lang('createbiz.error.requiredfields')?>');
			$('#createbiz-error-wrapper').show();
			return false;
		}
		
		if (email && !emailReg.test(email)) {
			$('#createbiz-error-msg').html('<?=lang('createbiz.error.emailformat')?>');
			$('#createbiz-error-wrapper').show();
				return false;
		}			
		
		$('#step1-wrapper').hide();
		$('#step2-wrapper').show();
	});
	
	$('#step2-prev').click(function(e){
		e.preventDefault();		
		$('#step1-wrapper').show();
		$('#step2-wrapper').hide();
	});

	$('#step2-next').click(function(e){
		e.preventDefault();		
		$('#step2-wrapper').hide();
		$('#step3-wrapper').show();
	});


	$('#step3-prev').click(function(e){
		e.preventDefault();		
		$('#step2-wrapper').show();
		$('#step3-wrapper').hide();
	});
	
	$('#bz-accept').change(function(e){
		
		if($(this).is(':checked')){
			$('#step3-post').show();
		}else{
			$('#step3-post').hide();
		}
		
	});
	
	$('#show-map').click(function(e){
		$('#map_addbiz').attr('style', 'padding: 0; height: 200px; width: 100%;');
		mapInit();
		$(this).hide();
	});
	
	$('#show-products').click(function(e){
		e.preventDefault();
		$('#createbz-product-wrapper').show();
	});
	
});
</script>