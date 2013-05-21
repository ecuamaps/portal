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
  
  <?=$_styles?>

  <script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
  <script src="<?=base_url()?>assets/foundation/js/vendor/custom.modernizr.js"></script>
  
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
	           	<a href="" class="button alert"><?=lang('dashboard.login')?></a>
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

			  <? if(!$user): ?>
	          <li class="divider"></li>
	          <li><a href="javascript:void(0)" id="signin"><?=lang('dashboard.signin')?></a></li>
	          <? endif; ?>
	        	
	        </ul>
	      </section>
		
		 <!-- Right Nav Section -->
	      <section class="top-bar-section">
	        <ul class="right">
	          
	          <li class="divider"></li>
	          <li><a href="javascript:void(0)" id="followus" ><?=lang('dashboard.followus')?></a></li>
	          
	          <li class="divider"></li>
	          <li><a href="javascript:void(0)" id="about"><?=lang('dashboard.about')?></a></li>
	          	          
	        </ul>
	      </section>
	    </nav>
	</div>
		
	<!-- Content -->
	<div class="row full-width with100" id="wrapper">
	<?=$content?>
	</div>

	<div class="row full-width with100 footer">
		<div class="small-9 large-centered columns">
			<div class="panel radius callout opacity07 text-color-white padding-10px">
				Hola mundo!!!
			</div>
		</div>
	</div>

	
	<!-- End Content -->
	
	<!-- SignIn Form -->
	
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
  document.write('<script src=' +
  ('__proto__' in {} ? '<?=base_url()?>assets/foundation/js/vendor/zepto' : '<?=base_url()?>assets/foundation/js/vendor/jquery') +
  '.js><\/script>')
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
  $(document).foundation();
  
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