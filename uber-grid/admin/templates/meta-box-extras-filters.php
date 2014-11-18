<div id="filters-options">
	<p><label><?php _e('Color: ', 'uber-grid')?></label><input type="text" name="fonts[filters_color]" value="<?php echo esc_attr($grid->filters_color) ?>"></p>
	<p><label><?php _e('Background color: ', 'uber-grid')?></label><input type="text" name="fonts[filters_background_color]" value="<?php echo esc_attr($grid->filters_background_color) ?>"></p>
	<p><label><?php _e('Accent color: ', 'uber-grid')?></label><input type="text" name="fonts[filters_accent_color]" value="<?php echo esc_attr($grid->filters_accent_color) ?>"></p>
	<p><label><?php _e('Accent background color: ', 'uber-grid')?></label><input type="text" name="fonts[filters_accent_background_color]" value="<?php echo esc_attr($grid->filters_accent_background_color) ?>"></p>
	<p>
		<label><?php _e('Sort filters', 'uber-grid')?></label>
		<select name="fonts[filters_sort]">
			<option value="0" <?php selected($grid->filters_sort, 0)?>><?php _e('Off', 'uber-grid')?></option>
			<option value="1" <?php selected($grid->filters_sort, 1)?>><?php _e('On', 'uber-grid')?></option>
		</select>
	</p>
	<p><label><?php _e('Align:', 'uber-grid')?></label>
		<select name="fonts[filters_align]">
		<option value="center" <?php selected($grid->filters_align, 'center') ?>><?php _e('Center', 'uber-grid')?></option>
		<option value="left" <?php selected($grid->filters_align, 'left') ?>><?php _e('Left', 'uber-grid')?></option>
		<option value="right" <?php selected($grid->filters_align, 'right') ?>><?php _e('Right', 'uber-grid')?></option>
	</select></p>
	<p><label><?php _e('"All" wording', 'uber-grid')?></label><input type="text" name="fonts[filters_all]" value="<?php echo esc_attr($grid->filters_all) ?>"></p>
</div>