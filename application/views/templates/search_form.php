<div class="row full-width">
	<?= form_open('api/search', array('id' => 'search-form', 'class' => 'clear-margin')) ?>
	<div class="row full-width">
		<div class="large-12 columns">
			<div class="panel callout opacity07 text-color-white padding-10px clear-margin">
				<div class="row">
					<div class="small-3 columns"><? logo_svg(54, 70); ?></div>
					<div class="small-5 columns">
						<input type="text" name="search-text" placeholder="<?=lang('dashboard.searchform.searchtext')?>" class="radius clear-margin" />
						<h6><small class="text-color-white"><?=lang('dashboard.searchform.nearto')?>: <span id="current-address"></span> <a href="#" data-dropdown="change-location-wrapper" id="chlocation"><?=lang('dashboard.chlocationform.change')?></a></small></h6>		
					</div>
					<div class="small-4 columns">
						<a href="javascript:void(0)" id="search-btn" class="small button alert"><?icon_magni_glass(12, 13)?></a>
						<a href="javascript:void(0)" id="adv-search" data-dropdown="adv-search-block"><?=lang('dashboard.searchform.advsearch')?></a>
					</div>
					<!-- <div class="small-2 columns"></div> -->
				</div>					
			</div>
		</div>
	</div>
	</form>	
</div>

	<!-- Advanced Search Form -->
	<div class="f-dropdown content" id="adv-search-block" data-dropdown-content>	
		<div class="row margin-top-10px">
			<div class="large-12 columns">
				<label for="radio"><?=lang('dashboard.searchform.radio')?></label>
				<select id="radio" name="radio" class="medium">
					<option value="1" selected>1Km</option>
				    <option value="2">2Km</option>
				    <option value="3">3Km</option>
				    <option value="0"><?=lang('dashboard.searchform.noradio')?></option>
				</select>
			</div>
    	</div>

		<div class="row margin-top-10px">
			<div class="large-12 columns">
				<label for="results-amt"><?=lang('dashboard.searchform.maxresults')?></label>
				<select id="results-amt" name="results-amt" class="medium">
					<option value="5" selected>5</option>
				    <option value="10">10</option>
				    <option value="20">20</option>
				    <option value="all">All</option>
				</select>
			</div>
    	</div>
			
		<div class="row margin-top-10px">
			<div class="large-12 columns">
				<label for="results-amt"><?=lang('dashboard.searchform.posttype')?></label>
				<select id="results-amt" name="results-amt" class="medium">
					<option value="1">Negocio</option>
				    <option value="2">Producto</option>
				    <option value="3">Evento</option>
				    <option value="4">Descuento</option>
				    <option value="all" selected>Todos</option>
				</select>					
			</div>
    	</div>
					
	</div>
	
	<!-- End Advanced Search From-->

	<!-- Change location Form -->
	<div class="f-dropdown content medium" id="change-location-wrapper" data-dropdown-content>	
		<h5><?=lang('dashboard.chlocationform.title')?></h5>
		<div class="row">
			<div class="large-12 columns">
				<input type="text" name="new_addr" placeholder="<?=lang('dashboard.chlocationform.newaddr')?>" value=""/>
				<h6><small><?=lang('dashboard.chlocationform.ex')?></small></h6>
			</div>
    	</div>	
		<div class="row">
			<div class="large-12 columns"><a href="javascript:void(0)" id="chlocation-action" class="small button"><?=lang('dashboard.chlocationform.button')?></a></div>
    	</div>
		<div class="row">
			<div class="large-12 columns"><a href="javascript:void(0)" id="chlocation-go-current-location"><?=lang('dashboard.chlocationform.gocurrlocation')?></a></div>
    	</div>
	</div>	
	<!-- End Change location Form -->

	