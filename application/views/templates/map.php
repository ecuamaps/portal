<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="<?=base_url()?>assets/js/gmap3.js"></script>
<script src="<?=base_url()?>assets/js/mochkino.js"></script>

<div class="row full-width with100" id="wrapper">
	<div id="map_canvas" class="hide-for-small"></div> 
	
	<!-- Search Bar -->
	<div class="row full-width with100">
		<div class="small-9 large-centered columns">
		<!--<div class="large-12 columns" id="search-bar">-->
			<div class="panel radius callout opacity07 text-color-white padding-10px">
				<div class="row">
					<div class="small-3 columns">Logo</div>
					<div class="small-9 columns">
					<form method="post" id="search-form" class="clear-margin">
						<div class="row">
				      		<div class="large-6 columns" style="margin-top: 6px;">
	        					<input type="text" placeholder="<?=lang('dashboard.searchform.searchtext')?>" >
	      					</div>
	      					<div class="large-3 columns">
	      						<a href="javascript:void(0)" id="search-btn" class="button round alert"><?=lang('dashboard.searchform.searchbtn')?></a><br/>
	      						<a href="javascript:void(0)" id="adv-search"><span id="hiden-advsearch"><?=lang('dashboard.searchform.advsearch')?></span><span class="hide" id="visible-advsearch"><?=lang('dashboard.searchform.hideadvsearch')?></span></a>
	      					</div>
	      					<div class="small-3 columns hide-for-small">&nbsp;</div>
	    				</div>
	
						<div class="row hide" id="adv-search-block">
						    <div class="small-4 columns">
						      <label for="radio" class="text-color-white"><h5><?=lang('dashboard.searchform.radio')?></h5></label>
						      <select id="radio" name="radio" class="medium">
						        <option value="1" selected>1Km</option>
						        <option value="2">2Km</option>
						        <option value="3">3Km</option>
						        <option value="0"><?=lang('dashboard.searchform.noradio')?></option>
						      </select>
						    </div>
						    <div class="small-4 columns">
						      <label for="results-amt" class="text-color-white"><h5><?=lang('dashboard.searchform.maxresults')?></h5></label>
						      <select id="results-amt" name="results-amt" class="medium">
						        <option value="5" selected>5</option>
						        <option value="10">10</option>
						        <option value="20">20</option>
						        <option value="all" selected>All</option>
						      </select>
						    </div>
						    <div class="small-4 columns">&nbsp;</div>						
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



	<div class="row full-width with100 footer hide-for-small">
		<div class="small-9 large-centered columns">
			<div class="panel radius callout opacity07 text-color-white padding-10px">
				<div class="row">
					<div class="small-2 columns">
						<label for="checkbox1"><input type="checkbox" id="checkbox1">Farmacias</label>
  					</div>

					<div class="small-2 columns">
						<label for="checkbox1"><input type="checkbox" id="checkbox1">Restaurantes</label>
  					</div>

					<div class="small-2 columns">
						<label for="checkbox1"><input type="checkbox" id="checkbox1">Hoteles</label>
  					</div>

					<div class="small-2 columns">
						<label for="checkbox1"><input type="checkbox" id="checkbox1">Tecnología</label>
  					</div>

					<div class="small-2 columns">
						<label for="checkbox1"><input type="checkbox" id="checkbox1">Autos</label>
  					</div>

					<div class="small-2 columns">
						<a href="javascript:void(0)" id="adv-search"><span id="hiden-advsearch"><?=lang('dashboard.searchform.viewmore')?></span><span class="hide" id="visible-advsearch"><?=lang('dashboard.searchform.hideviewmore')?></span></a>
  					</div>

				</div>
			</div>
		</div>
	</div>