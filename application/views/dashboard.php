<?php
$user = $this->session->userdata('user');
//$user->name = 'Patricio Guaman';
?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title><?= $title.' : '.$this->config->item('app_name') ?></title>
  
  <link rel="shortcut icon" href="<?=base_url()?>assets/images/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="<?=base_url()?>assets/foundation/css/normalize.css" />
  <link rel="stylesheet" href="<?=base_url()?>assets/foundation/css/app.css" />
  <link rel="stylesheet" href="<?=base_url()?>assets/foundation/css/foundation.min.css" />
  <link rel="stylesheet" href="<?=base_url()?>assets/webicons-master/fc-webicons.css">

  <!-- <link rel="stylesheet" href="<?=base_url()?>assets/js/jquery_modal/jquery.modal.css"> -->
  
  <?=$_styles?>

  <script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/vendor/custom.modernizr.js"></script>

  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&amp;region=EC"></script>
  
  <script src="<?=base_url()?>assets/js/mochkino.js"></script>
  <script src="<?=base_url()?>assets/js/jquery_modal/jquery.modal.js"></script>
  <script src="<?=base_url()?>assets/js/jquery.cookie.js"></script>
  
  <?=$_scripts?>

</head>
<body>

  <!-- body content/ here -->
	
	<!-- Errors/messages here --> 
	<? if($flash_msg = $this->session->flashdata('flash_msg')): ?>
	<div data-alert class="alert-box <?= ($flash_msg['status'] == 'error') ? 'alert' : 'success'?>">
		<?= $flash_msg['msg'] ?>
	  <a href="#" class="close">&times;</a>
	</div>
	<? endif; ?>
	
	<div class="stickyww">
	    <nav class="top-bar">
	      <ul class="title-area">
	      

	        <!-- Title Area -->
	        <li class="name">
	        	<? if(!$user): ?>
	           	<a href="#login-form-wrapper" rel="modal:open" class="button alert"><?=lang('dashboard.login')?></a>
	           	<? else: ?>
	            <h1 style="color: white;"><?=$user->name?></h1>
	           	<? endif; ?>
	        </li> 
	      
	        <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
	        <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	      </ul>
		<!-- Left Nav Section -->
		
		<!-- END Left Nav Section -->
	      <section class="top-bar-section">
	        <ul class="left">
			  <? if($user): ?>
	          <li class="divider"></li>
	          <li class="has-dropdown"><a href="javascript:void(0)"><?=lang('dashboard.myaccount')?></a>
	          	 <ul class="dropdown">
	          	 	<li class="has-dropdown"><a href="javascript:void(0)"><?=lang('dashboard.mylocations')?></a>
	          	 		<ul class="dropdown" id="saved-locations">
	          	 			<li><a href="#add-location-form-wrapper" rel="modal:open"><?=lang('dashboard.addnewlocation')?></a></li>
	          	 			<li><a href="<?=base_url($this->lang->lang().'/api/set_default_location')?>" <?= !isset($user_locations) ? 'style="display:none"' : ''?> id="set-default-location"><?=lang('dashboard.setdefaullocation')?></a></li>
	          	 			<li><a href="<?=base_url($this->lang->lang().'/api/delete_location')?>" <?= !isset($user_locations) ? 'style="display:none"' : ''?> id="delete-location"><?=lang('dashboard.deletelocation')?></a></li>
	          	 		<? if(isset($user_locations)): ?>
	          	 			<li class="divider"></li>
	          	 			<? foreach($user_locations as $l): ?>
	          	 			<? $name = ($l->def == '1') ?  $l->name.'*' : $l->name ?>
	          	 			<li><a href="javascript:void(0)" class="user-locations" lat="<?= $l->lat ?>" lng="<?= $l->lng ?>" name="<?= $l->name ?>" current="<?= $l->def ?>"><?= $name; ?></a></li>
	          	 			<? endforeach; ?> 
	          	 		<? endif; ?>
	          	 		</ul>
	          	 	</li>
              	 </ul> 
	          </li>			  	
			  <? endif; ?>
			  
			  <? if(!$user): ?>
	          <li class="divider"></li>
	          <li><a href="#signup-form-wrapper" rel="modal:open" id="signup-modal-open"><?=lang('dashboard.signup')?></a></li>
	          <? endif; ?>
	        	
	          <li class="has-dropdown"><a href="javascript:void(0)"><?=lang('dashboard.navmenu')?></a>
	          	<ul class="dropdown">
	          		<li><a href="javascript:void(0)" id="nav-menu-back"><?=lang('dashboard.navmenu.back')?></a></li>
	          		<li><a href="javascript:void(0)" id="nav-menu-move"><?=lang('dashboard.navmenu.move')?></a></li>
	          		<? if(isset($nav_locations)): ?>
	          			<? foreach($nav_locations  as $nav): ?>
	          				<li><a href="javascript:void(0)" class="nav-location" lat="<?=$nav['lat']?>" lng="<?=$nav['lng']?>"><?=lang('dashboard.navmenu.location').' '.$nav['name']?></a></li>
	          			<? endforeach; ?>
	          		<? endif; ?>
	          	</ul>
	          </li>
	        </ul>
	      </section>
		 
		 <!-- Right Nav Section -->
	      <section class="top-bar-section">
	        <ul class="right">
	          
	          <li class="divider"></li>
	          <li class="has-dropdown"><a href="javascript:void(0)" id="followus" ><?=lang('dashboard.followus')?></a>
	          	 <ul class="dropdown">
	          	 	<? foreach($follow_us_links as $f): ?>
	          	 		<? $name = ucfirst(str_replace('follow_us_', '', $f->keyname)) ?>
	          	 		<li><a href="<?= $f->value; ?>" target="_blank"><?= $name; ?></a></li>	
	          	 	<? endforeach; ?>
              	 </ul>
	          </li>
	          
	          <li class="divider"></li>
	          <li><a href="javascript:void(0)" id="about"><?=lang('dashboard.about')?></a></li>
			
       	<?
       		if($this->lang->lang() == 'en'){
       			$other_lang = 'es';
       			$other_lang_txt = 'Español';            			
       		}else{
       			$other_lang = 'en';
       			$other_lang_txt = 'English';            			
       		}
       	?>			
	          <li class="divider"></li>
	          <li><a href="<?=base_url($other_lang)?>" id="about"><?=$other_lang_txt?></a></li>
			
			<? if($user): ?>
	          <li class="divider"></li>
	          <li><?=anchor('account/logout', lang('dashboard.logout') )?></li>
	        <? endif; ?>
	             
	        </ul>
	      </section>
	    </nav>
	</div>
		
	<!-- Content -->
	<div class="row full-width">
	<!-- Search Bar -->
	<?= form_open('api/search', array('id' => 'search-form', 'class' => 'clear-margin')) ?>
	<div class="row full-width">
		<div class="large-12 columns">
			<div class="panel callout opacity07 text-color-white padding-10px clear-margin">
				<div class="row">
					<div class="small-2 columns">Logo</div>
					<div class="small-8 columns">
						<input type="text" name="search-text" placeholder="<?=lang('dashboard.searchform.searchtext')?>" class="radius clear-margin" />
						<h6><small class="text-color-white"><?=lang('dashboard.searchform.nearto')?>: <span id="current-address"><span></small></h6>
						<a href="javascript:void(0)" id="adv-search">
							<span id="hiden-advsearch"><?=lang('dashboard.searchform.advsearch')?></span>
							<span class="hide" id="visible-advsearch"><?=lang('dashboard.searchform.hideadvsearch')?></span>
						</a>		
					</div>
					<div class="small-2 columns">
						<a href="javascript:void(0)" id="search-btn" class="small button alert"><?icon_magni_glass(12, 13)?></a>
						<a href="javascript:void(0)" id="chlocation-btn" class="small button success"><?icon_location(7, 13)?></a>
					</div>
					<!--<div class="small-1 columns"></div>-->
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
					<div class="small-4 columns">
						<label for="results-amt" class="text-color-white"><h5><?=lang('dashboard.searchform.posttype')?></h5></label>
						<select id="results-amt" name="results-amt" class="medium">
							<option value="5" selected>5</option>
						    <option value="10">10</option>
						    <option value="20">20</option>
						    <option value="all" selected>All</option>
						</select>					
					</div>										
				</div>
					
			</div>
		</div>
	</div>
	</form>	
	<!-- End Search Bar -->		
	</div>


	<div class="row full-width" id="main-content-wrapper">
  		<div class="large-1 columns" id="left-panel" style="max-height: inherit; height: 100%; padding: 0 !important">
  			<div class="panel white-bg" style="max-height: inherit; height: 100%;">
  				<div class="row" style="border-bottom: 1px solid #D9D9D9">
				  <div style="float: left;" class="hide" id="clear-button-wrapper">
				  	<ul class="button-group">
  						<li><a href="#" class="tiny secondary radius button"><?=lang('dashboard.leftpanel.viewall')?></a></li>
  						<li><a href="#" class="tiny secondary radius button"><?=lang('dashboard.leftpanel.clearresults')?></a></li>
					</ul>
				  </div>
				  <div style="float: right;">
				  	<a href="javascript:void(0)" id="close-panel-button" class="small secondary radius button hide-for-small" style="display: none !important;"><? icon_arraw_left(10, 10) ?></a>
				  	<a href="javascript:void(0)" id="open-panel-button" class="small secondary radius button hide-for-small"><? icon_arraw_right(10, 10) ?></a>
				  </div>				  
  				</div>

			  <div class="row full-width" id="results-wrapper">


			  	
			  	<div class="search-results-panel" id="123">
			  		<input type="hidden" name="123-lat"  value="-0.17286542654272" />
			  		<input type="hidden" name="123-lng"  value="-78.4804487228393" />
			  		
			  		<div class="row">
			  			<div class="small-1 columns"><?icon_location(10, 16)?></div> 
			  			<div class="small-6 columns"><h6 class="clear-margin">El Rincón del sabor</h6></div>
			  			<div class="small-4 columns"><h5 class="clear-margin"><small>3.5</small></h5></div>
			  		</div>
			  		<div class="row">
			  			<div class="small-12 columns"><h6 class="clear-margin"><small>E845, Quito</small></h6></div>
			  		</div>
			  		<div class="row">
			  			<div class="small-12 columns"><h6 class="clear-margin"><small>Tels: 2264124 -2246453</small></h6></div>
			  		</div>
			  	</div>

			  	<div class="search-results-panel" id="124">
			  		<input type="hidden" name="124-lat"  value="-0.17273936329235" />
			  		<input type="hidden" name="124-lng"  value="-78.4803253412246" />
			  		
			  		<div class="row">
			  			<div class="small-1 columns"><?icon_location(10, 16)?></div> 
			  			<div class="small-6 columns"><h6 class="clear-margin">Papeletek</h6></div>
			  			<div class="small-4 columns"><h5 class="clear-margin"><small>N/A</small></h5></div>
			  		</div>
			  		<div class="row">
			  			<div class="small-12 columns"><h6 class="clear-margin"><small>N3909</small></h6></div>
			  		</div>
			  		<div class="row">
			  			<div class="small-12 columns"><h6 class="clear-margin"><small>Tels: no</small></h6></div>
			  		</div>
			  	</div>

			  
			  </div>
  				
			</div>
		</div>
		
  		<div class="large-11 columns" id="right-panel" style="max-height: inherit; height: 100%; padding: 0 !important">
  			<?=$content?>
  		</div>	
  	</div>
	<!-- End Content -->
	
	<!-- Login Form -->
	<div class="panel radius hide" id="login-form-wrapper">
		<?= form_open('account/login', array('id' => 'login-form', 'class' => '')) ?>
			<h4><?=lang('dashboard.loginform.title')?></h4>
			<div class="row hide" id="login-error-wrapper">
				<div data-alert class="alert-box alert">
  					<span id="login-error-msg"></span>
				</div>
			</div>
			
			<div class="row">
				<div class="large-12 columns">
			    	<label><?=lang('dashboard.loginform.username')?></label>
			        <input type="text" name="email"/>
			    </div>
    		</div>

			<div class="row">
				<div class="large-12 columns">
			    	<label><?=lang('dashboard.loginform.password')?></label>
			        <input type="password" name="passwd"/>
			    </div>
    		</div>
			<div class="row">
				<div class="large-12 columns"><a href="javascript:void(0)" id="login-action" class="button"><?=lang('dashboard.loginform.button')?></a></div>
    		</div>
		</form>
	</div>
	<!-- End Login Form-->
	
	<!-- Add Location Form -->
	<div class="panel radius hide" id="add-location-form-wrapper">
		<?= form_open('api/add_location', array('id' => 'add-location-form', 'class' => '')) ?>
			<h4><?=lang('dashboard.locationform.title')?></h4>
			<p><?=lang('dashboard.locationform.help')?></p>
			
			<div class="row hide" id="add-location-error-wrapper">
				<div data-alert class="alert-box alert">
  					<span id="add-location-error-msg"></span>
				</div>
			</div>
			
			<div class="row">
				<div class="large-12 columns">
			    	<label><?=lang('dashboard.locationform.name')?></label>
			        <input type="text" name="location-name"/>
			    </div>
    		</div>

			<div class="row">
				<div class="large-12 columns">
			    	<label>
			    		<input type="checkbox" name="location-def" value="1" />&nbsp;<?=lang('dashboard.locationform.def')?>
			    	</label>
			    </div>
    		</div>
			<div class="row">
				<div class="large-12 columns"><a href="javascript:void(0)" id="add-location-action" class="button"><?=lang('dashboard.locationform.button')?></a></div>
    		</div>
		</form>
		<script>
			var err_msg_missing_field = '<?=lang('dashboard.locationform.errmsg')?>';
		</script>
	</div>	
	<!-- End Add Location Form-->
	
	<!-- Sign Up Form -->
	<div class="panel radius hide" id="signup-form-wrapper">
		<?= form_open('account/signup', array('id' => 'signup-form', 'class' => '')) ?>
			<h5><?=lang('dashboard.signupform.title')?></h5>
			<div class="row hide" id="signin-error-wrapper">
				<div data-alert class="alert-box alert">
  					<span id="signin-error-msg"></span>
				</div>
			</div>
			
			<div class="row">
				<div class="large-12 columns">
			    	<label></label>
			        <input type="text" name="user_name" placeholder="<?=lang('dashboard.signupform.name')?>"/>
			    </div>
    		</div>
			
			<div class="row">
				<div class="large-12 columns">
			        <input type="email" name="user_email" placeholder="<?=lang('dashboard.signupform.email')?>"/>
			    </div>
			</div>
			<div class="row">
				<div class="large-12 columns">
			        <input type="password" name="user_passwd" placeholder="<?=lang('dashboard.signupform.pass')?>"/>
			    </div>
			</div>
			<div class="row">
				<div class="large-12 columns">
			    	<label></label>
			        <input type="password" name="user_passwd2" placeholder="<?=lang('dashboard.signupform.pass2')?>"/>
			    </div>
			</div>

			<div class="row">
				<div class="large-12 columns"><a href="javascript:void(0)" id="signup-action" class="small  button"><?=lang('dashboard.signupform.button')?></a></div>
    		</div>
		</form>
		<script>
			var lang = '<?=$this->lang->lang()?>';
			var err_msg_missing_field_signin = '<?=lang('dashboard.signupform.errmsg')?>';
			var err_msg_mismatch_pass = '<?=lang('dashboard.signupform.errmsg.pass')?>'
			var err_msg_wrong_email_format = '<?=lang('dashboard.signupform.errmsg.emailformat')?>';
			
		</script>
	</div>
	<!-- End SignIn Form -->
	
	<!-- Footer -->
	<!--
	<div id="bz_types">
		<div class="row full-width">
			<div class="large-4 columns">
				<p><?=$this->config->item('app_name');?> © 2013 sector78.com</p>
			</div>
			<div class="large-8 columns">
				<ul class="inline-list right">
			</div>
		</div>
	</div>-->
  <!-- END body content here -->


  <script>
  document.write('<script src="' +('__proto__' in {} ? '<?=base_url()?>assets/foundation/js/vendor/zepto' : '<?=base_url()?>assets/foundation/js/vendor/jquery') +'.js"><\/script>')
  </script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.alerts.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.clearing.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.cookie.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.dropdown.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.forms.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.joyride.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.magellan.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.orbit.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.placeholder.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.reveal.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.section.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.tooltips.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/foundation/foundation.topbar.js"></script>
 
  <script>
  $(function(){
    $(document).foundation();    
  })
  </script>

  <script>
  
  $(document).ready(function(){
  	
	var monthNames = [<?=lang('dashboard.months_names')?>];
	var dayNames= [<?=lang('dashboard.weekdays_names')?>]
	
	var newDate = new Date();
	$('#date').html(dayNames[newDate.getDay()] + ", " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());
  	
  });
  </script>
</body>
</html>