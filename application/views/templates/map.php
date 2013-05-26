<div class="row full-width with100" id="wrapper">
	
	<div id="map_canvas" class=""></div> 
	
	<!-- Search Bar -->
	<?= form_open('search', array('id' => 'search-form', 'class' => 'clear-margin')) ?>
	<div class="row full-width with100">
		<div class="large-12 columns">
			<div class="panel radius callout opacity07 text-color-white padding-10px">
				<div class="row">
					<div class="small-3 columns">Logo</div>
					<div class="small-5 columns">
						<input type="text" placeholder="<?=lang('dashboard.searchform.searchtext')?>">
						<a href="javascript:void(0)" id="adv-search">
							<span id="hiden-advsearch"><?=lang('dashboard.searchform.advsearch')?></span>
							<span class="hide" id="visible-advsearch"><?=lang('dashboard.searchform.hideadvsearch')?></span>
						</a>					
					</div>
					<div class="small-2 columns">
						<a href="javascript:void(0)" id="search-btn" class="small button alert"><?=lang('dashboard.searchform.searchbtn')?></a>
					</div>
					<div class="small-2 columns">
					</div>
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
					
			</div>
		</div>
	</div>
	</form>	
</div>

<div class="row full-width with100 footer hide-for-small">
	<div class="small-11 large-centered columns">
		<?= form_open() ?>
		
		<div class="panel radius callout opacity07 text-color-white padding-10px">
			<div class="row">
			<?php foreach($bztop5types as $type):?>
				<div class="small-2 columns">
					<label class="text-color-white" for="<?="type_".$type['id']?>"><input class="bz-type" type="checkbox" name="<?="type_".$type['id']?>" id="<?="type_".$type['id']?>" value="<?=$type['id']?>"><?=$type['name']?></label>
				</div>				
			<?php endforeach; ?>
				<div class="small-2 columns">
					<a href="javascript:void(0)" id="view-all-types"><span id="hiden-types-bar"><?=lang('dashboard.searchform.viewmore')?></span><span class="hide" id="visible-types-bar"><?=lang('dashboard.searchform.hide')?></span></a>
  				</div>				
			</div>
				
			<div class="hide" id="extra-types"></div>
								
		</div>
		
		</form>
	</div>
</div>

<script>
	var map = new Object();
	var myLocation = new Object();
	var myLatlng = new Object();
	
	var sysDefaultLocation = new google.maps.LatLng('<?= $system_location[0] ?>', '<?= $system_location[1] ?>');
	<? if(isset($userDefaultLocation)): ?>
	var userDefaultLocation = new google.maps.LatLng('<?= $userDefaultLocation[0] ?>', '<?= $userDefaultLocation[1] ?>');	
	<? else: ?>
	var userDefaultLocation = null;		
	<? endif; ?>
	var map_zoom = <?= $map_zoom ?>;
	
	var currentPosLbl = '<?=lang('dashboard.searchform.currlocation')?>';
	var accuracyErrorMsg = '<?=lang('dashboard.searchform.accuracyerror')?>';
</script>