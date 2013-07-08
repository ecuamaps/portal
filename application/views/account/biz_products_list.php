<? header('Content-Type: text/html'); ?>

<? if(count($products)): ?>
    
<div class="row">
  <div class="small-12 small-centered columns">
 
	<table>
	  <thead>
	    <tr>
	      <th width="200"><?=lang('bizpanel.products.th1')?></th>
	      <th><?=lang('bizpanel.products.th2')?></th>
	      <th width="150">&nbsp;</th>
	    </tr>
	  </thead>
	  <tbody>
	  <? foreach($products as $index => $p): ?>
	    <tr>
	      <td><?= $p->name ?></td>
	      <td><?= $p->description ?></td>
	      <td><a href="#" class="small button alert"><?=lang('bizpanel.products.disable')?></a></li></td>
	    </tr>
	  <? endforeach; ?>  
	  </tbody>
	</table>
  
  </div>
</div>

<div class="row">
	<div class="large-12 columns">
		<?=lang('bizpanel.products.availableprod')?>
	</div>
</div>

<div class="row">
      <div class="large-4 columns">
        <select name="available-products" id="available-products">
        	<? foreach($available_products as $av): ?>
        	<option value="<?= $av->id.'|'.$av->price ?>"><?=$av->name?>&nbsp;$<?=$av->price?></option>
        	<? endforeach; ?>
        </select>
      </div>
      <div class="large-4 columns">
        <a href="#" class="small button">+</a>
      </div>
      <div class="large-4 columns">&nbsp;</div>
</div>

<? else: ?>
	<h3><?=lang('bizpanel.setup.noproducts')?></h3>
	<a href="javascript:void(0)" class="small button"><?=lang('bizpanel.setup.addproducts')?></a>
<? endif; ?>