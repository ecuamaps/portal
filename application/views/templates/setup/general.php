<h3><?=lang('setup.general.title')?></h3>

<?= $navigation ?>

<?=form_open('setup/manager', array('id' => 'setup-manager-form'));?>
	<fieldset>
		<legend><h5><?=lang('setup.general.manager')?></h5></legend>
			<div class="row">
				<div class="large-12 columns">
					<label for"manager.name" ><?=lang('setup.general.manager.name')?></label>
				    <input type="text" id="manager.name" name="manager.name" value="<?=set_value('manager.email');?>"/>
				</div>
			</div>

			<div class="row">
				<div class="large-12 columns">
					<label for"manager.email"><?=lang('setup.general.manager.email')?></label>
				    <input type="text" id="manager.email" name="manager.email" value="<?=set_value('manager.email');?>"/>
				</div>
			</div>

			<div class="row">
				<div class="large-12 columns">
					<label for"manager.address"><?=lang('setup.general.manager.address')?></label>
				    <input type="text" id="manager.address" name="manager.address" value="<?=set_value('manager.address');?>"/>
				</div>
			</div>

			<div class="row">
				<div class="large-12 columns">
					<label for"manager.phones"><?=lang('setup.general.manager.phones')?></label>
				    <input type="text" id="manager.phones" name="manager.phones" value="<?=set_value('manager.phones');?>"/>
				</div>
			</div>
		
		  <div class="row">
		      <div class="large-12 columns">
		      		<a href="javascript:void(0)" id="send-manager-form" class="button"><?=lang('setup.save')?></a>
		      </div>
	      </div>
	  
	  </fieldset>        
</form>  