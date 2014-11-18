<?php $prefix = 'responsive_440' ?>
<p>
	<label><?php _e('Cell width', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[cell_width]" value="<?php echo esc_attr($grid->responsive_440_cell_width) ?>" placeholder="160">px
</p>
<p>
	<label><?php _e('Cell height', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[cell_height]" value="<?php echo esc_attr($grid->responsive_440_cell_height) ?>" placeholder="0">px
</p>
<p>
	<label><?php _e('Gap between cells', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[cell_gap]" value="<?php echo esc_attr($grid->responsive_440_cell_gap) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Cell border width', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[cell_border_width]" value="<?php echo esc_attr($grid->responsive_440_cell_border_width) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Cell border radius', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[cell_border_radius]" value="<?php echo esc_attr($grid->responsive_440_cell_border_radius) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Title font size', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[title_font_size]" value="<?php echo esc_attr($grid->responsive_440_title_font_size) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Tagline font size', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[tagline_font_size]" value="<?php echo esc_attr($grid->responsive_440_tagline_font_size) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Hover title font size', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[hover_title_font_size]" value="<?php echo esc_attr($grid->responsive_440_hover_title_font_size) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Hover text font size', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[hover_text_font_size]" value="<?php echo esc_attr($grid->responsive_440_hover_text_font_size) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Label title font size', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[label_title_font_size]" value="<?php echo esc_attr($grid->responsive_440_label_title_font_size) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Label tagline font size', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[label_tagline_font_size]" value="<?php echo esc_attr($grid->responsive_440_label_tagline_font_size) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Label price tag font size', 'uber-grid')?></label>
	<input type="number" name="<?php echo $prefix ?>[label_price_font_size]" value="<?php echo esc_attr($grid->responsive_440_label_price_font_size) ?>" placeholder="0">
</p>
<p>
	<label><?php _e('Max label height', 'uber-grid') ?></label>
	<input type="number" name="<?php echo $prefix ?>[label_max_height]" value="<?php echo $grid->responsive_440_label_max_height ?>" step="1">px
</p>