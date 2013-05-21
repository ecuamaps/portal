<?php foreach($output->css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($output->js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<h3><?=lang('setup.general.title')?></h3>

<?= $navigation ?>

<h3><?=$title;?></h3>

    <div>
        <?= $output->output; ?>
    </div>