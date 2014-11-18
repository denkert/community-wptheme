<ul class="ubergrid-tabs">
	<li class="ubergrid-current"><a href="#ubergrid-layout-default"><?php _e('Default', 'uber-grid') ?></a></li>
	<li><a href="#ubergrid-layout-768"><?php _e('< 768px', 'uber-grid') ?></a></li>
	<li><a href="#ubergrid-layout-440"><?php _e('< 440px', 'uber-grid') ?></a></li>
</ul>
<ul class="ubergrid-panels">
	<?php foreach(array('default', '768', '440') as $panel): ?>
		<li id="ubergrid-layout-<?php echo $panel ?>" class="<?php echo $panel == 'default' ? 'ubergrid-current' : '' ?>"><?php require("meta-box-layout-$panel.php") ?></li>
	<?php endforeach ?>
</ul>
<br class="clear">
