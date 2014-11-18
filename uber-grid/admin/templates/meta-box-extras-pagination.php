<p><label><input type="checkbox" value="1" name="pagination[enable]" <?php checked($grid->pagination_enable)?> name="pagination[enable]"> <?php _e('Enable pagination')?></label></p>
<p>
	<label><?php _e('Items per page')?></label>
	<input type="number" value="<?php echo $grid->pagination_per_page ?>" name="pagination[per_page]">
</p>

<p><label><?php _e('Color: ', 'uber-grid')?></label><input type="text" name="pagination[color]" value="<?php echo esc_attr($grid->pagination_color) ?>"></p>
<p><label><?php _e('Background color: ', 'uber-grid')?></label><input type="text" name="pagination[background_color]" value="<?php echo esc_attr($grid->pagination_background_color) ?>"></p>
<p><label><?php _e('Current page color: ', 'uber-grid')?></label><input type="text" name="pagination[current_page_color]" value="<?php echo esc_attr($grid->pagination_current_page_color) ?>"></p>
<p><label><?php _e('Current page bg color: ', 'uber-grid')?></label><input type="text" name="pagination[current_page_background_color]" value="<?php echo esc_attr($grid->pagination_current_page_background_color) ?>"></p>
<p><label><?php _e('Align:', 'uber-grid')?></label>
	<select name="pagination[align]">
	<option value="center" <?php selected($grid->pagination_align, 'center') ?>><?php _e('Center', 'uber-grid')?></option>
	<option value="left" <?php selected($grid->pagination_align, 'left') ?>><?php _e('Left', 'uber-grid')?></option>
	<option value="right" <?php selected($grid->pagination_align, 'right') ?>><?php _e('Right', 'uber-grid')?></option>
</select></p>
<p><label><?php _e('"Pages" wording', 'uber-grid')?></label><input type="text" name="pagination[pages]" value="<?php echo esc_attr($grid->pagination_pages) ?>"></p>