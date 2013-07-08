<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title><?= $this->config->item('app_name') ?></title>
  
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
  <script src="<?=base_url()?>assets/js/ajaxfileupload.js"></script>
  
  <?=$_scripts?>

</head>
<body>

  <!-- body content/ here -->
  
  <? if(isset($browser_error))
  	{
  		alert();
  	}
  
  ?>
	
	<!-- Errors/messages here --> 
	<? if($flash_msg = $this->session->flashdata('flash_msg')): ?>
	<div data-alert class="alert-box <?= ($flash_msg['status'] == 'error') ? 'alert' : 'success'?>">
		<?= $flash_msg['msg'] ?>
	  <a href="#" class="close">&times;</a>
	</div>
	<? endif; ?>
	<!-- End Errors/messages here --> 
	
	<!-- Menu Bar-->
	<?= $menu ?>
	<!-- End Menu Mar-->
		
	<!-- Content -->
	
	<!-- Search Bar -->
	<?= $search_form ?>
	<!-- End Search Bar -->		


	<div class="row full-width" id="main-content-wrapper">		
  		<div class="large-12 columns" id="right-panel" style="max-height: inherit; height: 100%; padding: 0 !important">
  			<?=$map?>
  		</div>	
  	</div>
	<!-- End Content -->

	
	<!-- Search results -->
	<div class="reveal-modal" id="search-result-wrapper"></div>
	<!-- End Search Results-->
	
	
	<? if(!$user): ?>
	<!-- Login Form -->
	<div class="reveal-modal" id="login-form-wrapper">
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
		<a class="close-reveal-modal">&#215;</a>
	</div>
	<!-- End Login Form-->
	<? endif; ?>
		
	<? if(!$user): ?>
	<!-- Sign Up Form -->
	<div class="reveal-modal" id="signup-form-wrapper">
		<?= form_open('account/signup', array('id' => 'signup-form', 'class' => '')) ?>
			<h5><?=lang('dashboard.signupform.title')?></h5>
			<div class="row hide" id="signin-error-wrapper">
				<div data-alert class="alert-box alert">
  					<span id="signin-error-msg"></span>
				</div>
			</div>
			
			<div class="row">
				<div class="large-12 columns">
			    	<label><?=lang('dashboard.signupform.name')?></label>
			        <input type="text" name="user_name" placeholder=""/>
			    </div>
    		</div>
			
			<div class="row">
				<div class="large-12 columns">
					<label><?=lang('dashboard.signupform.email')?></label>
			        <input type="email" name="user_email" placeholder=""/>
			    </div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<label><?=lang('dashboard.signupform.pass')?></label>
			        <input type="password" name="user_passwd" placeholder=""/>
			    </div>
			</div>
			<div class="row">
				<div class="large-12 columns">
			    	<label><?=lang('dashboard.signupform.pass2')?></label>
			        <input type="password" name="user_passwd2" placeholder=""/>
			    </div>
			</div>

			<div class="row">
				<div class="large-12 columns"><a href="javascript:void(0)" id="signup-action" class="small  button"><?=lang('dashboard.signupform.button')?></a></div>
    		</div>
		</form>

		<div class="row" id="succesfull">
			<div class="large-12 columns"><?=sprintf(lang('dashboard.signupform.emailconfirmation'), get_config_val('account_activation_days'))?></div>
		</div>
		
		<div class="row full-width" id="waiting">
			<div class="small-1 small-centered columns"><?= img('assets/images/loading.gif'); ?></div>
		</div>
		
		<script>
			var lang = '<?=$this->lang->lang()?>';
			var err_msg_missing_field_signin = '<?=lang('dashboard.signupform.errmsg')?>';
			var err_msg_mismatch_pass = '<?=lang('dashboard.signupform.errmsg.pass')?>'
			var err_msg_wrong_email_format = '<?=lang('dashboard.signupform.errmsg.emailformat')?>';
			
			$(document).ready(function(){
				$('#waiting, #succesfull').hide();
			});
		</script>
		<a class="close-reveal-modal">&#215;</a>
	</div>
	<!-- End SignIn Form -->
	<? endif; ?>

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
  	  	
  });
  </script>
</body>
</html>