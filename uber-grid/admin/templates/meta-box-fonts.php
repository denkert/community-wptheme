<input name="fonts-loaded" value="" type="hidden" id="fonts-loaded">
<div class="spin-wrapper"><span class="spinner"></span><br class="clear"></div>
<div id="fonts">
	<p>You can preview fonts at <a href="http://www.google.com/fonts">Google Fonts directory</a></p>
	<p>
		<label><?php _e('Title font', 'uber-grid')?></label>
		<select role="font" name="fonts[title_font]" data-font="<?php echo $grid->title_font ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<select role="style" name="fonts[title_font_style]" data-font="<?php echo $grid->title_font_style ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<input type="number" name="fonts[title_font_size]" value="<?php echo $grid->title_font_size ?>">px
		<label><?php _e('Tagline font', 'uber-grid')?></label>
		<select role="font" name="fonts[tagline_font]" data-font="<?php echo $grid->tagline_font ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<select role="style" name="fonts[tagline_font_style]" data-font="<?php echo $grid->tagline_font_style ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<input type="number" name="fonts[tagline_font_size]" value="<?php echo $grid->tagline_font_size ?>">px
	</p>
	<p>
		<label><?php _e('Hover title font', 'uber-grid')?></label>
		<select role="font" name="fonts[hover_title_font]" data-font="<?php echo $grid->hover_title_font ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<select role="style" name="fonts[hover_title_font_style]" data-font="<?php echo $grid->hover_title_font_style ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<input type="number" name="fonts[hover_title_font_size]" value="<?php echo $grid->hover_title_font_size ?>">px
		
		<label><?php _e('Hover text font', 'uber-grid')?></label>
		<select role="font" name="fonts[hover_text_font]" data-font="<?php echo $grid->hover_text_font ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<select role="style" name="fonts[hover_text_font_style]" data-font="<?php echo $grid->hover_text_font_style ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<input type="number" name="fonts[hover_text_font_size]" value="<?php echo $grid->hover_text_font_size ?>">px
	</p>
	<p>
		<label><?php _e('Lightbox title font', 'uber-grid')?></label>
		<select role="font" name="fonts[lightbox_title_font]" data-font="<?php echo $grid->lightbox_title_font ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<select role="style" name="fonts[lightbox_title_font_style]" data-font="<?php echo $grid->lightbox_title_font_style ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<input type="number" name="fonts[lightbox_title_font_size]" value="<?php echo $grid->lightbox_title_font_size ?>">px
		<label><?php _e('Lightbox text font', 'uber-grid')?></label>
		<select role="font" name="fonts[lightbox_text_font]" data-font="<?php echo $grid->lightbox_text_font ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<select role="style" name="fonts[lightbox_text_font_style]" data-font="<?php echo $grid->lightbox_text_font_style ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<input type="number" name="fonts[lightbox_text_font_size]" value="<?php echo $grid->lightbox_text_font_size ?>">px
	</p>
	<p>
		<label><?php _e('Label title font', 'uber-grid')?></label>
		<select role="font" name="fonts[label_title_font]" data-font="<?php echo $grid->label_title_font ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<select role="style" name="fonts[label_title_font_style]" data-font="<?php echo $grid->label_title_font_style ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<input type="number" name="fonts[label_title_font_size]" value="<?php echo $grid->label_title_font_size ?>">px
		<label><?php _e('Label tagline font', 'uber-grid')?></label>
		<select role="font" name="fonts[label_tagline_font]" data-font="<?php echo $grid->label_tagline_font ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<select role="style" name="fonts[label_tagline_font_style]" data-font="<?php echo $grid->label_tagline_font_style ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<input type="number" name="fonts[label_tagline_font_size]" value="<?php echo $grid->label_tagline_font_size ?>">px
		
		<label><?php _e('Label price font', 'uber-grid')?></label>
		<select role="font" name="fonts[label_price_font]" data-font="<?php echo $grid->label_price_font ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<select role="style" name="fonts[label_price_font_style]" data-font="<?php echo $grid->label_price_font_style ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<input type="number" name="fonts[label_price_font_size]" value="<?php echo $grid->label_price_font_size ?>">px
	</p>
	<div class="section">
		<label><?php _e('Filters font', 'uber-grid')?></label>
		<select role="font" name="fonts[filters_font]" data-font="<?php echo $grid->filters_font ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<select role="style" name="fonts[filters_font_style]" data-font="<?php echo $grid->filters_font_style ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<input type="number" name="fonts[filters_font_size]" value="<?php echo $grid->filters_font_size ?>">px
	</div>
	<div class="section">
		<label><?php _e('Pagination font', 'uber-grid')?></label>
		<select role="font" name="fonts[pagination_font]" data-font="<?php echo $grid->pagination_font ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<select role="style" name="fonts[pagination_font_style]" data-font="<?php echo $grid->pagination_font_style ?>"><option value=""><?php _e('Default', 'uber-grid')?></option></select>
		<input type="number" name="fonts[pagination_font_size]" value="<?php echo $grid->pagination_font_size ?>">px
	</div>
</div>
