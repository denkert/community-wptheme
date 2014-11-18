<input type="hidden" name="uber-grid" id="uber-grid-hack" name="uber-grid-hack"/>
<?php if ($post->post_status == 'publish'): ?>
	<div id="shortcode">
		<label><?php _e('Shortcode', 'uber-grid') ?>:</label> [ubergrid id=<?php echo $post->ID?>]
	</div>
<?php endif ?>

<h2 class="nav-tab-wrapper">
	<a href="<?php echo admin_url('edit
				.php?post_type=uber-grid&page=support&url=http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']) ?>" class="button-primary" style="float: right"><?php _e('Ask for support', 'uber-grid') ?></a>
	<a href="#manual" id="enable-manual-mode" class="nav-tab <?php echo $grid->mode == 'auto' ? '' : 'nav-tab-active' ?>"><?php _e('Manual', 'uber-grid')?></a>
	<a href="#auto" id="enable-auto-mode" class="nav-tab <?php echo $grid->mode == 'auto' ? 'nav-tab-active' : '' ?>"><?php _e('Automatic', 'uber-grid')?></a>
</h2>
<input id="current-mode" type="hidden" value="<?php echo $grid->mode ?>" name="current-mode">
<div id="manual-mode" class="<?php echo $grid->mode == 'auto' ? '' : 'active' ?>">
	<h2 id="cells-header">
		<?php _e('Cells', 'uber-grid') ?>
		<button class="button" id="add-new-cell"><?php _e('Add new cell', 'uber-grid')?></button>
	</h2>
	<ul id="cells">
		<?php $i = 1 ?>
		<?php if ($grid->cells): ?>
			<?php foreach($grid->cells as $cell): ?>
				<?php require('part-cell.php') ?>
				<?php $i++ ?>
			<?php endforeach ?>
		<?php endif ?>
	</ul>
	
</div>
<div id="auto-mode" class="<?php echo $grid->mode == 'auto' ? 'active' : '' ?>">
	<div id="auto-post-settings">
		<h3><?php _e('Build from posts', 'uber-grid')?></h3>
		<div class="inside">
			<div class="section">
				<label for="auto-post-type" class="larger"><?php _e('Post type')?></label>
				<div class="column-1">
					<?php _e('Fetch', 'uber-grid')?>
					<select name="auto[post_type]" id="auto-post-type">
						<?php global $wp_post_types?>
						<?php foreach($wp_post_types as $type => $args): ?>
							<?php if (!in_array($type, array('revision', 'nav_menu_item', 'uber-grid', 'media'))): ?>
								<option value="<?php echo esc_attr($type) ?>" <?php selected($grid->auto_post_type, $type) ?>><?php echo (isset($args->labels) && isset($args->labels->plural_name)) ? esc_html($args->labels->plural_name) : (isset($args->label) ? esc_html($args->label): $type) ?></option>
							<?php endif ?>
						<?php endforeach ?>
					</select>
					<?php _e('order by', 'uber-grid')?>
						<select name="auto[orderby]">
							<?php foreach(array('date' => __('Date', 'uber-grid'), 'none' => __('None', 'uber-grid'), 'ID' => 'ID', 'author' => __('Author', 'uber-grid'), 'title' => __('Title', 'uber-grid'), 'name' => __('Name', 'uber-grid'), 'modified' => __('Modification date', 'uber-grid'), 'rand' => __('Rand', 'uber-grid'), 'comment_count' => __('Comment count', 'uber-grid'), 'menu_order' => __('Menu position')) as $value => $label): ?>
									<option value="<?php echo esc_attr($value) ?>" <?php selected($grid->auto_orderby, $value) ?>><?php echo esc_html($label) ?></option>
							<?php endforeach ?>
						</select>
						<select name="auto[order]">
							<option value="DESC" <?php selected($grid->auto_order, 'DESC')?>>DESC</option>
							<option value="ASC" <?php selected($grid->auto_order, 'ASC')?>>ASC</option>
						</select><br> Limit to <input type="number" name="auto[limit]" id="auto-limit" value="<?php echo esc_attr($grid->auto_limit) ?>"> cells, offset
							<input type="number" name="auto[offset]" id="auto-offset" value="<?php echo esc_attr($grid->auto_offset) ?>" step="1"> posts.
				</div>
				<br class="clear">
			</div>
			<div class="section" id="taxonomy-filters">
				<label class="larger"><?php _e('Tagged with', 'uber-grid')?></label>
				<div class="column-1">
					<ul class="filters">

						<?php for ($i = 0; $i < count($grid->auto_taxonomies); $i++ ):?>
							<?php $filter = array('taxonomy' => $grid->auto_taxonomies[$i], 'tags' => $grid->auto_tags[$i], 'operator' => $grid->auto_operators[$i])?>
							<?php require('filter-taxonomy.php') ?>
						<?php endfor ?>
					</ul>
					<button class="button" id="add-taxonomy-filter"><?php _e('Add filter', 'uber-grid')?></button>
				</div>
				<br class="clear">
			</div>
			<div class="section" id="custom-field-filters">
				<label class="larger"><?php _e('Custom fields filters', 'uber-grid')?></label>
				<div class="column-1">
					<ul>
						<?php for ($i = 0; $i < count($grid->auto_meta_operators); $i++ ):?>
							<?php $filter = array('meta_key' => $grid->auto_meta_keys[$i], 'meta_value' => $grid->auto_meta_values[$i], 'meta_operator' => $grid->auto_meta_operators[$i], 'meta_type' => $grid->auto_meta_types[$i]) ?>
							<?php require('filter-custom-field.php') ?>
						<?php endfor ?>
					
				</ul>
					<button class="button" id="add-custom-field-filter"><?php _e('Add filter', 'uber-grid')?></button>
				</div>
				
				<br class="clear">
			</div>
			<div class="section" id="on-the-fly">
				<label class="larger"><?php _e('On-the-fly', 'uber-grid')?></label>
				<div class="column-1">
					<label><input type="checkbox" name="auto[enable]" value="1" <?php checked($grid->auto_enable) ?>> <?php _e('build the grid on the fly each time when showing or', 'uber-grid')?></label>
					<button class="button" id="build-now"><?php _e('Build now', 'uber-grid')?></button><span class="spinner"></span>
				</div>
				<br class="clear">
			</div>
		</div>
	</div>
	<div id="auto-cell-template" class="cell">
		<h3><?php _e('Cell template', 'uber-grid')?></h3>
		<div class="inside">
			<div class="section">
				<label class="huge"><?php _e('Pseudo-tags', 'uber-grid')?></label>
				<div class="columns-2">
					<div class="column">
						<p>You can use these pseudo-tags to mark places where actual post data should be used.</p>
						<ul>
							<li><strong>%post_title%</strong> = <?php _e('Post title', 'uber-grid')?></li>
							<li><strong>%post_excerpt%</strong> = <?php _e('Post excerpt', 'uber-grid')?></li>
							<li><strong>%post_ID%</strong> = <?php _e('Post ID', 'uber-grid')?></li>
							<li><strong>%post_permalink%</strong> = <?php _e('Post URL', 'uber-grid')?></li>
							<li><strong>%post_content%</strong>=<?php _e('Post content', 'uber-grid') ?></li>
							<li><strong>%post_tags%</strong>=<?php _e('Post tags', 'uber-grid') ?></li>
							<li><strong>%post_meta_...%</strong> - <?php _e('Add your meta key name instead of ellipsis to fetch custom field value', 'uber-grid') ?></li>
							<li><strong>%post_meta__regular_price%</strong> - <?php _e('WooCommerce product regular price', 'uber-grid')?></li>
							<li><strong>%post_meta__sale_price%</strong> - <?php _e('WooCommerce product sale price', 'uber-grid')?></li>
						</ul>
					</div>
				</div>
				<br class="clear">
			</div>
			<?php $template_mode = true ?>
			<?php $name_prefix = 'template' ?>
			<?php $cell = $grid->template ?>
			<?php require('cell-fields.php') ?>
		</div>
	</div>
</div>