	
	    <nav class="top-bar">
	      <ul class="title-area">
	      

	        <!-- Title Area -->
	        <li class="name">
	        	<? if(!$user): ?>
	           	<a href="#" data-reveal-id="login-form-wrapper" class="button alert"><?=lang('dashboard.login')?></a>
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
                    <li><a href="javascript:void(0)" id="chpwd" data-reveal-id="chpwd-form-wrapper"><?=lang('dashboard.chpwd')?></a></li>

	          	 	<li class="has-dropdown"><a href="javascript:void(0)"><?=lang('dashboard.mylocations')?></a>
	          	 		<ul class="dropdown" id="saved-locations">
	          	 			<li><a href="#" data-reveal-id="add-location-form-wrapper"><?=lang('dashboard.addnewlocation')?></a></li>
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
	          
	         
	          <li class="divider"></li>
	          <li class="has-dropdown"><a href="javascript:void(0)"><?=lang('dashboard.mybizs')?></a>
	          	<ul class="dropdown">
	          		<li><a href="<?=base_url($this->lang->lang().'/account/create_enterprise_form')?>" data-reveal-id="add-enterprise-form" data-reveal-ajax="true"><?=lang('dashboard.addbuz')?></a></li>
	          		<? if(isset($businesses)): ?>
		          		<? foreach($businesses as $b): ?>
		          		<li><a href="javascript:void(0)" id="<?=$b->id?>" class="mybiz-link"><?=$b->name?></a></li>
		          		<? endforeach; ?>
	          		<? endif; ?>
	          	</ul>
	          <li>
	          
			  <? endif; ?>
			  
			  <? if(!$user): ?>
	          <li class="divider"></li>
	          <li><a href="javascript:void(0)" data-reveal-id="signup-form-wrapper"><?=lang('dashboard.signup')?></a></li>
	          <? endif; ?>
	        
	           <li class="divider"></li>
	           <li><a href="javascript:void(0)" id="goto-my-current-location" style="line-height: 0 !important; padding: 10px 5px 6px 5px;" data-tooltip class="has-tip" title="<?=lang('dashboard.navmenu.tooltip.target')?>"><? got_to_my_current_location_logo()?></a></li>
	           <li><a href="javascript:void(0)" id="nav-menu-back" style="line-height: 0 !important; padding: 10px 5px 6px 5px;" data-tooltip class="has-tip" title="<?=lang('dashboard.navmenu.tooltip.whereami')?>"><? where_am_i_logo() ?></a></li>
	           <li><a href="javascript:void(0)" id="nav-menu-move" style="line-height: 0 !important; padding: 10px 5px 6px 5px;" data-tooltip class="has-tip" title="<?=lang('dashboard.navmenu.tooltip.placemehere')?>"><? place_me_here_logo() ?></a></li>
	           
	          <!--<li class="has-dropdown"><a href="javascript:void(0)"><?=lang('dashboard.navmenu')?></a>
	          	<ul class="dropdown">
	          		<li><a href="javascript:void(0)" id="nav-menu-back"><?=lang('dashboard.navmenu.back')?></a></li>
	          		<li><a href="javascript:void(0)" id="nav-menu-move"><?=lang('dashboard.navmenu.move')?></a></li>
	          	</ul>
	          </li>-->
	        </ul>
	      </section>
		 
		 <!-- Right Nav Section -->
	      <section class="top-bar-section">
	        <ul class="right">
	          
	        <? foreach($follow_us_links as $f): ?>
		    	<? 
		    		$name = ucfirst(str_replace('follow_us_', '', $f->keyname));
		    		$icon = get_config_val("{$name}_icon");
		    	?>
		        <li><a href="<?= $f->value; ?>" <?= ($icon) ? 'style="line-height: 0 !important; padding: 10px 5px 6px 0;"' : ''?> target="_blank"><?= ($icon) ? $icon : $name; ?></a></li>	
		    <? endforeach; ?>
		          	 	
		          	 			     
	          <li class="divider"></li>
	          <li class="has-dropdown"><a href="javascript:void(0)" id="about"><?=lang('dashboard.about')?></a>
	         	 <ul class="dropdown">	         	 	
	         	 	<li><a href="http://www.buskoo.com">Historia</a></li>
	         	 	<li><a href="mailto:ventas@buskoo.com">Ventas</a></li>
	         	 	<li><a href="mailto:webmaster@buskoo.com">Soporte</a></li>
	         	 </ul>
	          </li>
	          
	          
			
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
	          <li><a href="<?=base_url($other_lang)?>" id="about"><?=$other_lang_txt?></a>
	          
	          </li>
			
			<? if($user): ?>
	          <li class="divider"></li>
	          <li><?=anchor('account/logout', lang('dashboard.logout') )?></li>
	        <? endif; ?>
	             
	        </ul>
	      </section>
	    </nav>


	<? if($user): ?>
	<!-- Add Location Form -->
	<div class="reveal-modal small" id="add-location-form-wrapper">
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
				<div class="large-12 columns"><a href="javascript:void(0)" id="add-location-action" class="button"><?=lang('dashboard.locationform.button')?></a></div>
    		</div>
		</form>
		<script>
			var err_msg_missing_field = '<?=lang('dashboard.locationform.errmsg')?>';
		</script>
		<a class="close-reveal-modal">&#215;</a>
	</div>	
	<!-- End Add Location Form-->
	
	<!-- Add Enterprise Form -->
	<div class="reveal-modal" id="add-enterprise-form"></div>
	<!-- End Add Enterprise Form -->

	<!-- Add Enterprise Form -->
	<div class="reveal-modal" id="biz-control-panel"></div>
	<!-- End Add Enterprise Form -->

	<!-- Change Password Form -->
	<div class="reveal-modal small" id="chpwd-form-wrapper">
            <?= form_open('account/change_password', array('id' => 'chpwd-form', 'class' => '')) ?>
            <input type="hidden" name="chpwd_email" value="<?=$user->email?>">
            <h5><?=lang('dashboard.chpwd')?></h5>
            <div class="row hide" id="chpwd-error-wrapper">
                <div data-alert class="alert-box alert">
                    <span id="chpwd-error-msg"></span>
                </div>
            </div>
            
            <div class="row">
		<div class="large-12 columns">
                   <label><?=lang('dashboard.chpwd.oldpass')?>*</label>
		   <input type="password" name="chpwd_oldpasswd"/>
		</div>
	    </div>
            <div class="row">
		<div class="large-12 columns">
		   <label><?=lang('dashboard.chpwd.newpass')?>*</label>
                    <input type="password" name="chpwd_newpasswd" />
		</div>
            </div>
            <div class="row">
		<div class="large-12 columns">
		   <label><?=lang('dashboard.chpwd.newpass2')?>*</label>
		   <input type="password" name="chpwd_newpasswd2" />
		 </div>
	   </div>
            <div class="row">
	        <div class="large-12 columns"><a href="javascript:void(0)" id="chpwd-action" class="small  button"><?=lang('dashboard.chpwd.button')?></a></div>
    	    </div>
          </form>
            <a class="close-reveal-modal">&#215;</a>
            
            <script>
                var chpwd_err_msg_missing_field = "<?=lang('dashboard.signupform.errmsg')?>";
                var chpwd_error_keys_mistmatch = "<?=lang('dashboard.signupform.errmsg.pass')?>";
                var location_delete = "<?=lang('dashboard.location.delete')?>";
                
            </script>
        </div>
	<!-- End Change Password Form -->

	<? endif; ?>
	