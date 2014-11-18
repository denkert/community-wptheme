<?php $name_prefix = "cells[]" ?>
<?php $template_mode = false ?>
<li class="cell">
	<h3>
		<span class="handle"></span>
		<a class="cell-clone"><?php _e('clone', 'uber-crid')?></a>
		<span class="heading"><?php echo esc_html(trim($cell->title) ? trim($cell->title) : "Cell $i") ?></span>
	</h3>
	<div class="cell-content" style="display: none;">
		<?php require("cell-fields.php") ?>
		<div class="section submitdiv">
			<a href="#" class="cell-cancel"><?php echo _e('Cancel', 'uber-grid')?></a>
			<span class="separator">|</span>
			<a href="#" class="cell-delete"><?php echo _e('Remove', 'uber-grid')?></a>
		</div>
	</div>
</li>