<p>
	<label><?php _e('Cell width', 'uber-grid')?></label>
	<input type="number" name="layout[cell_width]" value="<?php echo esc_attr($grid->cell_width) ?>" placeholder="160">px
</p>
<p>
	<label><?php _e('Cell height', 'uber-grid')?></label>
	<input type="number" name="layout[cell_height]" value="<?php echo esc_attr($grid->cell_height) ?>" placeholder="0">px
</p>
<p>
	<label><?php _e('Gap between cells', 'uber-grid')?></label>
	<input type="number" name="layout[cell_gap]" value="<?php echo esc_attr($grid->cell_gap) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Max grid width', 'uber-grid')?></label>
	<input type="number" name="layout[max_width]" value="<?php echo esc_attr($grid->max_width) ?>" placeholder="" step="1">
</p>
<p>
	<label><?php _e('Responsive cell size', 'uber-grid') ?></label>
	<select name="layout[cell_autosize]">
		<option value="0" <?php selected($grid->cell_autosize, 0) ?>><?php _e('Disabled', 'uber-grid') ?></option>
		<option value="1" <?php selected($grid->cell_autosize, 1) ?>><?php _e('Enabled', 'uber-grid') ?></option>
	</select>
</p>
<p>
	<label><?php _e('Cell border width', 'uber-grid')?></label>
	<input type="number" name="layout[cell_border_width]" value="<?php echo esc_attr($grid->cell_border_width) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Border color', 'uber-grid')?></label>
	<input type="text" name="layout[cell_border_color]" value="<?php echo esc_attr($grid->cell_border_color) ?>" placeholder="FFFFFF">
</p>
<p>
	<label><?php _e('Border radius', 'uber-grid')?></label>
	<input type="number" name="layout[cell_border_radius]" value="<?php echo esc_attr($grid->cell_border_radius) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Border opacity', 'uber-grid')?></label>
	<input type="number" name="layout[cell_border_opacity]" value="<?php echo esc_attr($grid->cell_border_opacity) ?>" placeholder="1.0" step="any">
</p>
<p>
	<label><?php _e('Shadow radius', 'uber-grid')?></label>
	<input type="number" name="layout[cell_shadow_radius]" value="<?php echo esc_attr($grid->cell_shadow_radius) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Max label height', 'uber-grid') ?></label>
	<input type="number" name="layout[label_max_height]" value="<?php echo $grid->label_max_height ?>" step="1">px
</p>
