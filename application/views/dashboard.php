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
  <script src="<?=base_url()?>assets/js/jquery_modal/jquery.modal.min.js"></script>
  <script src="<?=base_url()?>assets/js/jquery.cookie.js"></script>
  
  <?=$_scripts?>

</head>
<body>

  <!-- body content/ here -->

	<div class="sticky">
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
	          	 		<? if(isset($user_locations)): ?>
	          	 			<li><a href="<?=base_url($this->lang->lang().'/api/set_default_location')?>" id="set-default-location"><?=lang('dashboard.setdefaullocation')?></a></li>
	          	 			<li><a href="<?=base_url($this->lang->lang().'/api/delete_location')?>" id="delete-location"><?=lang('dashboard.deletelocation')?></a></li>
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
	          <li><a href="#signin-form-wrapper" rel="modal:open"><?=lang('dashboard.signup')?></a></li>
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
	<?=$content?>
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
	<div class="panel radius hide" id="signin-form-wrapper">
		<?= form_open('account/signin', array('id' => 'signin-form', 'class' => '')) ?>
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
			    	<label></label>
			        <input type="email" name="user_email" placeholder="<?=lang('dashboard.signupform.email')?>"/>
			    </div>
			</div>
			<div class="row">
				<div class="large-12 columns">
			    	<label></label>
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
				<div class="large-12 columns">
			    	<label></label>
			        <?=$recaptcha_html?>
			    </div>
			</div>
			<div class="row">
				<div class="large-12 columns"><a href="javascript:void(0)" id="signup-action" class="small  button"><?=lang('dashboard.signupform.button')?></a></div>
    		</div>
		</form>
		<script>
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
  	$('#send-form').click(function(e){
  		e.preventDefault();
  		$('#login-form').submit();
  	});
  	
	var monthNames = [<?=lang('dashboard.months_names')?>];
	var dayNames= [<?=lang('dashboard.weekdays_names')?>]
	
	var newDate = new Date();
	$('#date').html(dayNames[newDate.getDay()] + ", " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());
  	
  });
  </script>
</body>
</html>