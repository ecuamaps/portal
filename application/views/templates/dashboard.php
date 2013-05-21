<div class="large-12 columns">
	<h3><?=lang('dashboard.pagetitle')?></h3>
	
	 <? if(check_feature('reports')): ?>
	<div class="row">
		<div class="large-4 columns">
			<div class="panel radius">
				<h5><?=lang('dashboard.available_rooms')?></h5>
				<h1><?=$available_rooms?></h1>
			</div>
		</div>

		<div class="large-4 columns">
			<div class="panel radius">
				<h5><?=lang('dashboard.occupied_rooms')?></h5>
				<h1><?=$occupied_rooms?></h1>
			</div>
		</div>

		<div class="large-4 columns">
			<div class="panel radius">
				<h5><?=lang('dashboard.load_factor')?></h5>
				<h1><?=number_format ( $load_factor, 2 )?></h1>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="large-4 columns">
			<div class="panel radius">
				<h5>This is a regular panel.</h5>
				<p>It has an easy to override visual style, and is appropriately subdued.</p>
			</div>
		</div>

		<div class="large-4 columns">
			<div class="panel">
				<h5>This is a regular panel.</h5>
				<p>It has an easy to override visual style, and is appropriately subdued.</p>
			</div>
		</div>

		<div class="large-4 columns">
			<div class="panel">
				<h5>This is a regular panel.</h5>
				<p>It has an easy to override visual style, and is appropriately subdued.</p>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="large-4 columns">
			<div class="panel">
				<h5>This is a regular panel.</h5>
				<p>It has an easy to override visual style, and is appropriately subdued.</p>
			</div>
		</div>

		<div class="large-4 columns">
			<div class="panel">
				<h5>This is a regular panel.</h5>
				<p>It has an easy to override visual style, and is appropriately subdued.</p>
			</div>
		</div>

		<div class="large-4 columns">
			<div class="panel">
				<h5>This is a regular panel.</h5>
				<p>It has an easy to override visual style, and is appropriately subdued.</p>
			</div>
		</div>
	</div>
	<? endif; ?>
	
</div>