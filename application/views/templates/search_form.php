<div class="row full-width">
	<?= form_open('api/search', array('id' => 'search-form', 'class' => 'clear-margin')) ?>
	<input type="hidden" name="search-start" id="search-start" value="0"/>
	<div class="row full-width">
		<div class="large-12 columns">
			<div class="panel callout opacity07 text-color-white padding-10px clear-margin">
				<div class="row">
					<!--<div class="small-3 columns hide-for-small show-for-medium-up"><? logo_big_svg(200, 36); ?></div>
					<div class="small-3 columns show-for-small hide-for-medium-up"><? logo_big_svg(80, 15); ?></div>-->
					<div class="small-3 columns"><h1 id="bsk-logo">buskoo.com</h1></div>
					<div class="small-4 columns">
						<input type="text" name="search-text" placeholder="<?=lang('dashboard.searchform.searchtext')?>" class="radius clear-margin" />
						<h6><small class="text-color-white"><?=lang('dashboard.searchform.nearto')?>: <span id="current-address"></span> <a href="#" data-dropdown="change-location-wrapper" id="chlocation"><?=lang('dashboard.chlocationform.change')?></a></small></h6>		
					</div>
					<div class="small-5 columns">
						<a href="javascript:void(0)" id="search-btn" class="small button alert"><?icon_magni_glass(12, 13)?></a>
						<a href="javascript:void(0)" id="back-results-btn" class="small button success" style=""><?=lang('dashboard.searchform.reopensearchresults')?></a>
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
				<label for="distance"><?=lang('dashboard.searchform.radio')?></label>
				<select id="distance" name="distance" class="medium">
					<option value="1">1Km</option>
				    <option value="2" selected>2Km</option>
				    <option value="3">3Km</option>
				    <option value="5">5Km</option>
				    <option value="10">10Km</option>
				    <option value="15">15Km</option>
				</select>
			</div>
    	</div>

		<div class="row margin-top-10px">
			<div class="large-12 columns"><div id="search-orderby-wrapper">
				<label for="sort"><?=lang('dashboard.searchform.sortby')?></label>
				<select id="sort" name="sort" class="medium">
					<option value="score"><?=lang('dashboard.searchform.sortby.score')?></option>
					<option value="score_avg"><?=lang('dashboard.searchform.sortby.scoreavg')?></option>
					<option value="geodist"><?=lang('dashboard.searchform.sortby.distance')?></option>
				</select>
			</div></div>
    	</div>

		<div class="row margin-top-10px">
			<div class="large-12 columns">
				<label for="rows"><?=lang('dashboard.searchform.maxresults')?></label>
				<select id="rows" name="rows" class="medium">
					<option value="5" selected>5</option>
				    <option value="10">10</option>
				    <option value="20">20</option>
				    <option value="all"><?=lang('dashboard.searchform.all')?></option>
				</select>
			</div>
    	</div>
			
		<!--<div class="row margin-top-10px">
			<div class="large-12 columns">
				<label for="post_type"><?=lang('dashboard.searchform.posttype')?></label>
				<select id="post_type" name="post_type" class="medium">
				    <option value="all" selected><?=lang('dashboard.searchform.all')?></option>
				    <? $lng = current_lang(); 
				    $field = "name_$lng";
				    foreach($post_types as $pt):?>
					<option value="<?="post_type_$lng|".$pt->$field?>"><?= $pt->$field; ?></option>
				    <? endforeach; ?>
				</select>					
			</div>
    	</div>-->
					
	</div>
	
	<!-- End Advanced Search From-->

	<!-- Search results -->
	<div class="reveal-modal expand" id="search-result-wrapper"></div>
	<!-- End Search Results-->

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
			<div class="large-12 columns margin-bottom-5px"><a href="javascript:void(0)" id="chlocation-go-current-location"><?=lang('dashboard.chlocationform.gocurrlocation')?></a></div>
    	</div>

		<? if(isset($nav_locations)): ?>
	    	<? foreach($nav_locations  as $nav): ?>
	    		<div class="row">
					<div class="large-12 columns margin-bottom-5px"><a href="javascript:void(0)" class="nav-location" lat="<?=$nav['lat']?>" lng="<?=$nav['lng']?>"><?=lang('dashboard.navmenu.location').' '.$nav['name']?></a></div>
    			</div>
	        <? endforeach; ?>
	   <? endif; ?>
	          		    	
	</div>	
	<!-- End Change location Form -->

	<!-- Add Qualification Form -->
	<div class="reveal-modal small" id="add-qualification-wrapper">	
		<? if($user): ?>
		<?= form_open('api/qualification', array('id' => 'qualification-form', 'class' => '')) ?>
		<input type="hidden" name="post_id" id="post_id" value="" />
		<input type="hidden" name="user_agent" id="user_agent" value="<?=user_agent()?>" />
		<input type="hidden" name="user_ip" id="user_ip" value="<?=user_ip_address()?>" />
		<input type="hidden" name="user_id" id="user_id" value="<?=$user->id?>" />
		<h5><?=lang('dashboard.qualificationform.title')?></h5>
		<div class="row">
			<div class="large-12 columns"><h6><span id="qf-post-name"></span></h6></div>
    	</div>	
		<div class="row">
			<div class="large-12 columns">
				<label for="qualification"><?=lang('dashboard.qualificationform.rate')?>*</label>
				<select id="qualification" name="qualification" class="medium">
				    <option value="1">1</option>
				    <option value="2">2</option>
				    <option value="3">3</option>
				    <option value="4">4</option>
				    <option value="5">5</option>
				</select>					
			</div>
    	</div>	
		<div class="row">
			<div class="large-12 columns">
				<label for="review"><?=lang('dashboard.qualificationform.resena')?></label>
				<textarea name="review"></textarea>					
			</div>
    	</div>	
		<div class="row">
			<div class="large-12 columns">
				<a href="javascript:void(0)" id="rateform-action" class="small button"><?=lang('dashboard.qualificationform.button')?></a>
				<a href="javascript:void(0)" id="rateform-cancel-action" class="small button"><?=lang('dashboard.qualificationform.cancel')?></a>			
			</div>
    	</div>
		</form>
		<? else: ?>
		<div class="row">
			<div class="large-12 columns">
				<div data-alert class="alert-box alert">
					<?=lang('dashboard.qualificationform.userlogin')?>
				</div>			
			</div>
    	</div>	
			<div class="large-12 columns">
				<a href="javascript:void(0)" id="rateform-cancel-action" class="small button"><?=lang('dashboard.qualificationform.close')?></a>			
			</div>
		<? endif; ?>
	</div>	
	<!-- End Change location Form -->
