<?php $position_options = array("center" =>__('Center', 'uber-grid'),
				"top-center" =>   __('Top center', 'uber-grid'),
				"top-left" =>  __('Top left', 'uber-grid'),
				"top-right" =>  __('Top right', 'uber-grid'),
				"bottom-center" =>  __('Bottom center', 'uber-grid'),
				"bottom-left" => __('Bottom left', 'uber-grid'),
				"bottom-right" => __('Bottom right', 'uber-grid'),
				"top-left-bottom-left" => __('Top left - bottom left', 'uber-grid'),
				"top-left-bottom-right" =>  __('Top left - bottom right', 'uber-grid'),
				"top-right-bottom-right" => __('Top right - bottom right', 'uber-grid'),
				"top-left-bottom-left" => __('Top left - bottom left', 'uber-grid')) ?>
<div class="section cell-title">
	<label class="huge"><?php _e('Main', 'uber-grid')?></label>
	<div class="columns-2">
		<div class="column">
			<div class="field">
				<label><?php _e('Title', 'uber-grid')?></label>
				<input type="text" name="<?php echo $name_prefix ?>[title]" placeholder="<?php _e('Title', 'uber-grid') ?>" class="cell-title-editor" value="<?php echo esc_attr($cell->title)?>">
				<input type="text" name="<?php echo $name_prefix ?>[title_color]" value="<?php echo $cell->title_color ?>" class="color-picker">
			</div>
			<div class="field">
				<input type="text" name="<?php echo $name_prefix ?>[tagline]" placeholder="<?php _e('Tagline', 'uber-grid') ?>" class="full-width" value="<?php echo esc_attr($cell->tagline) ?>">
				<input type="text" name="<?php echo $name_prefix ?>[tagline_color]" value="<?php echo $cell->tagline_color ?>" class="color-picker">
			</div>

			<div class="field">
				<label><?php _e('Background color', 'uber-grid')?></label>
				<input type="text" name="<?php echo $name_prefix ?>[title_background_color]" value="<?php echo $cell->title_background_color ?>" class="color-picker">
			</div>

			<div class="field">
				<label><?php _e('Title / Tagline position')?></label>
				<select name="<?php echo $name_prefix ?>[title_position]">
					<?php $cell->render_select_options(array_merge(array('' => __('Do not show', 'uber-grid')), $position_options), $cell->title_position)?>
				</select>
			</div>
			<div class="field">
				<?php if (!$template_mode): ?>
					<label><?php _e('Tags (used for filtering)', 'uber-grid')?></label>
					<input type="text" name="<?php echo $name_prefix ?>[tags]" placeholder="<?php _e('comma-separated tags')?>" value="<?php echo esc_attr($cell->tags)?>">
				<?php else: ?>
						<label><?php _e('Fetch filtering tags from taxonomy', 'uber-grid') ?></label>
						<select name="<?php echo $name_prefix ?>[tags_source]">
							<option value="" <?php checked('', $cell->tags_source) ?>><?php _e('Dont fetch', 'uber-grid') ?></option>
							<?php global $wp_taxonomies ?>
							<?php foreach($wp_taxonomies as $taxonomy => $tax_args): ?>
									<option value="<?php echo esc_attr($taxonomy) ?>" <?php echo selected($taxonomy, $cell->tags_source) ?>><?php echo esc_html((isset($tax_args->label) && isset($tax_args->labels->name)) ? $tax_args->labels->name : $taxonomy) ?></option>
							<?php endforeach ?>
						</select>
				<?php endif ?>
			</div>
		</div>
		<div class="column">
			<label><?php _e('Main image', 'uber-grid')?></label>
			<div class="image-selector no-image">
				<input name="<?php echo $name_prefix ?>[image]" value="<?php echo $cell->image ?>" type="hidden">
				<?php if ($cell->image): ?>
					<img src="<?php echo esc_attr($cell->get_image_src($grid)) ?>">
				<?php endif ?>
				<div class="overlay"></div>
				<div class="actions-wrapper">
					<button class="select-image button "><?php _e('Select image', 'uber-grid')?></button>
					<br>
					<a href="#" class="image-delete"><?php _e('Remove image', 'uber-grid')?></a>
				</div>
			</div>
		</div>
		<div class="column">
			<label><?php _e('Background image', 'uber-grid')?></label>
			<div class="image-selector no-image">
				<input name="<?php echo $name_prefix ?>[title_background_image]" value="<?php echo $cell->title_background_image ?>" type="hidden">
				<?php if ($cell->title_background_image): ?>
					<img src="<?php echo esc_attr($cell->getTitleBackgroundImageSrc()) ?>">
				<?php endif ?>
				<div class="actions-wrapper">
					<button class="select-image button "><?php _e('Select image', 'uber-grid')?></button>
					<br>
					<a href="#" class="image-delete"><?php _e('Remove image', 'uber-grid')?></a>
				</div>
			</div>
		</div>
	</div>
	<br class="clear">
</div>
<div class="section cell-layout">
	<label class="huge"><?php _e('Layout',  'uber-grid')?></label>
	<?php if ($template_mode): ?>
		<div class="column-1">
			<ul class="layout-list">
				<?php $i = 0 ?>
				<?php foreach((array)$cell->layouts as $layout): ?>
						<li>
							<h3>
								<a href="#" class="delete-layout"><?php _e('Delete', 'uber-grid') ?></a>
								<span>Layout <?php echo ++$i ?></span>
							</h3>
							<?php $layout_input_name = '[layouts][]'; ?>
							<?php require('layout-chooser.php') ?>
							<br class="clear">
						</li>
				<?php endforeach ?>
			</ul>
			<a href="#" class="add-layout"><?php _e('Add a layout', 'uber-grid') ?></a>
		</div>
		<br class="clear">
	<?php else: ?>
		<?php $layout_input_name = '[layout]' ?>
		<?php $layout = $cell->layout ?>
		<?php require('layout-chooser.php') ?>
	<br class="clear">
	<?php endif ?>
</div>

<div class="section linking">
	<label class="huge"><input type="checkbox" name="<?php echo $name_prefix ?>[link_enable]" value="1" <?php echo checked($cell->link_enable)?>><?php _e('Linking and lightbox', 'uber-grid')?></label>
	<div class="columns-2">
		<div class="column">
			<div class="field">
				<label><?php _e('Link mode')?></label>
				<select name="<?php echo $name_prefix ?>[link_mode]" class="select-link-mode">
					<option value="url" <?php selected('url', $cell->link_mode)?>><?php _e('URL', 'uber-grid')?></option>
					<option value="lightbox" <?php selected('lightbox', $cell->link_mode)?>><?php _e('Lightbox', 'uber-grid')?></option>
				</select>
			</div>
			<div class="field">
				<label><?php _e('Link this cell to URL', 'uber-grid')?></label>
				<input type="text" class="full-width" name="<?php echo $name_prefix ?>[link_url]" value="<?php echo esc_attr($cell->link_url) ?>">
				<small><?php _e('Please don\'t use youtu.be short URLs - use full youtube.com/watch/... ones instead')?></small>
			</div>
			<div class="link-to-lightbox">
				<label><?php _e('Lightbox image', 'uber-grid')?></label>
				<div class="image-selector no-image">
					<input type="hidden" name="<?php echo $name_prefix ?>[lightbox_image]" value="<?php echo $cell->lightbox_image ?>">
					<?php if ($cell->lightbox_image): ?>
						<img src="<?php echo esc_attr($cell->get_lightbox_image_src()) ?>">
					<?php endif ?>
					<div class="actions-wrapper">
						<button class="select-image button "><?php _e('Select image', 'uber-grid')?></button>
						<br>
						<a href="#" class="image-delete"><?php _e('Remove image', 'uber-grid')?></a>
					</div>
				</div>
			</div>
			<div class="field link-to-lightbox">
				<label><?php _e('Lightbox Title', 'uber-grid')?></label>
				<input type="text" class="full-width" name="<?php echo $name_prefix ?>[lightbox_title]" value="<?php echo esc_html($cell->lightbox_title) ?>">
			</div>
			<div class="field link-to-lightbox">
				<label><?php _e('Lightbox Text', 'uber-grid')?></label>
				<textarea class="full-width" name="<?php echo $name_prefix ?>[lightbox_text]"><?php echo esc_textarea($cell->lightbox_text) ?></textarea>
			</div>

		</div>
		<div class="column">
			<div class="field link-to-url">
				<label><?php _e('Link "target" attribute value', 'uber-grid')?></label>
				<input type="text" class="full-width" name="<?php echo $name_prefix ?>[link_target]" value="<?php echo esc_attr($cell->link_target) ?>">
			</div>
			<div class="field link-to-url">
				<label><?php _e('Link "rel" attribute value', 'uber-grid')?></label>
				<input type="text" class="full-width" name="<?php echo $name_prefix ?>[link_rel]" value="<?php echo esc_attr($cell->link_rel) ?>">
			</div>
			<?php if (uber_grid_get_active_lightbox() != 'magnific-popup'): ?>
				<div style="display: none">
			<?php endif ?>
			<?php foreach(array('facebook', 'twitter', 'instagram', 'linkedin', 'pinterest', 'email', 'skype', 'dribbble', 'flickr', 'website', 'googleplus') as $service): ?>
				<div class="field link-to-lightbox">
					<label><?php _e(ucfirst($service . " url"), 'uber-grid')?></label>
					<?php $service_name = "lightbox_$service" ?>
					<input type="text" class="full-width" name="<?php echo $name_prefix ?>[lightbox_<?php echo $service ?>]" value="<?php echo esc_attr($cell->$service_name) ?>">
				</div>
			<?php endforeach ?>
			<?php if (uber_grid_get_active_lightbox() != 'magnific-popup'): ?>
				</div>
			<?php endif ?>
		</div>
	</div>
	<br class="clear">
</div>
<div class="section hover">
	<label class="huge"><input type="checkbox" name="<?php echo $name_prefix ?>[hover_enable]" value="1" <?php echo checked($cell->hover_enable)?>><?php _e('On-hover', 'uber-grid')?></label>
	<div class="columns-2">
		<div class="column">
			<div class="field">
				<label><?php _e('Text position')?></label>
				<select name="<?php echo $name_prefix ?>[hover_position]">
					<?php $cell->render_select_options($position_options, $cell->hover_position) ?>
				</select>
			</div>
			<p>
				<label><?php _e('Title', 'uber-grid')?></label>
				<input type="text" class="full-width" name="<?php echo $name_prefix ?>[hover_title]" value="<?php echo esc_html($cell->hover_title) ?>">
			</p>
			<p>
				<label><?php _e('Text', 'uber-grid')?></label>
				<textarea class="full-width" name="<?php echo $name_prefix ?>[hover_text]"><?php echo esc_textarea($cell->hover_text)?></textarea>
			</p>
			<p>
				<label><?php _e('Text color', 'uber-grid')?></label>
				<input type="text" class="color-picker" name="<?php echo $name_prefix ?>[hover_text_color]" value="<?php echo $cell->hover_text_color ?>">
			</p>
		</div>
		<div class="column">
			<p>
				<label><input type="checkbox" value="1" <?php checked($cell->hover_hide_arrow)?> name="<?php echo $name_prefix?>[hover_hide_arrow]"> <?php _e('Disable arrow in hover block', 'uber-grid')?>
			</p>
			<label><?php _e('Background image', 'uber-grid')?></label>
			<div class="image-selector no-image">
				<input type="hidden" name="<?php echo $name_prefix ?>[hover_background_image]" value="<?php echo $cell->hover_background_image ?>">
				<?php if ($cell->hover_background_image): ?><img src="<?php echo esc_attr($cell->gethoverBackgroundImageSrc()) ?>"><?php endif ?>
				<div class="overlay"></div>
				<div class="actions-wrapper">
					<button class="select-image button "><?php _e('Select image', 'uber-grid')?></button>
					<br>
					<a href="#" class="image-delete"><?php _e('Remove image', 'uber-grid')?></a>
				</div>
			</div>
			<label><?php _e('Background color', 'uber-grid')?></label>
			<input type="text" class="color-picker" name="<?php echo $name_prefix ?>[hover_background_color]" value="<?php echo $cell->hover_background_color ?>">
		</div>
		<br class="clear">
	</div>
	<br class="clear">
</div>
<div class="section label-content">
	<label class="huge"><input type="checkbox" name="<?php echo $name_prefix ?>[label_enable]" <?php checked($cell->label_enable)?> value="1"><?php _e('Label below', 'uber-grid')?></label>
	<div class="columns-2">
		<div class="column">
			<div class="field">
				<label><?php _e('Title', 'uber-grid')?></label>
				<input type="text" class="full-width larger" name="<?php echo $name_prefix ?>[label_title]" value="<?php echo esc_attr($cell->label_title) ?>">
				<input type="text" name="<?php echo $name_prefix ?>[label_title_color]" value="<?php echo $cell->label_title_color ?>" class="color-picker">
			</div>
			<div class="field">
				<label><?php _e('Small text', 'uber-grid')?></label>
				<input type="text" class="full-width" name="<?php echo $name_prefix ?>[label_tagline]" value="<?php echo esc_attr($cell->label_tagline) ?>">
				<input type="text" name="<?php echo $name_prefix ?>[label_tagline_color]" value="<?php echo $cell->label_tagline_color ?>" class="color-picker">
			</div>
			<div class="field">
				<label><?php _e('Price tag', 'uber-grid')?></label>
				<input type="text" name="<?php echo $name_prefix ?>[label_price]" value="<?php echo esc_attr($cell->label_price) ?>">
			</div>
			<div class="field">
				<label><?php _e('Border top', 'uber-grid') ?></label>
				<input type="number" step="1" name="<?php echo $name_prefix ?>[label_border_top]" value="<?php echo $cell->label_border_top ?>">px
				<input type="text" name="<?php echo $name_prefix ?>[label_border_top_color]" value="<?php echo $cell->label_border_top_color ?>" class="color-picker">
			</div>
			<div class="field">
				<label><?php _e('Border bottom', 'uber-grid') ?></label>
				<input type="number" step="1" name="<?php echo $name_prefix ?>[label_border_bottom]" value="<?php echo $cell->label_border_bottom ?>">px
				<input type="text" name="<?php echo $name_prefix ?>[label_border_bottom_color]" value="<?php echo $cell->label_border_bottom_color ?>" class="color-picker">
			</div>

		</div>
		<div class="column">
			<div class="field">
				<label><?php _e('Background color', 'uber-grid')?></label>
				<input type="text" name="<?php echo $name_prefix ?>[label_background_color]" value="<?php echo $cell->label_background_color ?>" class="color-picker">
			</div>
			<div class="field">
				<label><?php _e('Price color', 'uber-grid')?></label>
				<input type="text" name="<?php echo $name_prefix ?>[label_price_color]" value="<?php echo $cell->label_price_color ?>" class="color-picker">
			</div>
			<div class="field">
				<label><?php _e('Price background color', 'uber-grid')?></label>
				<input type="text" name="<?php echo $name_prefix ?>[label_price_background_color]" value="<?php echo $cell->label_price_background_color ?>" class="color-picker">
			</div>
		</div>
	</div>
	<br class="clear">
</div>
