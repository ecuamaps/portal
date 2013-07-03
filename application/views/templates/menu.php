	
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
	          		<li><a href="<?=base_url($this->lang->lang().'/account/create_enterprise_form')?>" data-reveal-id="add-enterprise-form" data-reveal-ajax="true"><?=lang('dashboard.addbuz')?></a></li>
                    <li><a href="javascript:void(0)" id="chpwd" data-reveal-id="chpwd-form-wrapper"><?=lang('dashboard.chpwd')?></a></li>

	          	 	<li class="has-dropdown"><a href="javascript:void(0)"><?=lang('dashboard.mylocations')?></a>
	          	 		<ul class="dropdown" id="saved-locations">
	          	 			<li><a href="javascript:void(0)" data-reveal-id="add-location-form-wrapper"><?=lang('dashboard.addnewlocation')?></a></li>
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
	          
	          <? if(isset($businesses)): ?>
	          <li class="divider"></li>
	          <li class="has-dropdown"><a href="javascript:void(0)"><?=lang('dashboard.mybizs')?></a>
	          	<ul class="dropdown">
	          		<? foreach($businesses as $b): ?>
	          		<li><a href="javascript:void(0)" id="<?=$b->id?>" class="mybiz-link"><?=$b->name?></a></li>
	          		<? endforeach; ?>
	          	</ul>
	          <li>
	          <? endif; ?>
	          
			  <? endif; ?>
			  
			  <? if(!$user): ?>
	          <li class="divider"></li>
	          <li><a href="#" data-reveal-id="signup-form-wrapper"><?=lang('dashboard.signup')?></a></li>
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


	<? if($user): ?>
	<!-- Add Location Form -->
	<div class="reveal-modal" id="add-location-form-wrapper">
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
	<div class="reveal-modal" id="chpwd-form-wrapper">
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
                
            </script>
        </div>
	<!-- End Change Password Form -->
        
        
        
        
	<? endif; ?>
	