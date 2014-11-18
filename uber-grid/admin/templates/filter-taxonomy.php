<li>
	<?php global $wp_taxonomies ?>
	<select name="auto[taxonomies][]">
		<?php foreach($wp_taxonomies as $taxonomy => $args): ?>
			<option value="<?php echo esc_attr($taxonomy) ?>" <?php selected($taxonomy, $filter['taxonomy'])?>><?php echo esc_html((isset($args->label) && isset($args->labels->name)) ? $args->labels->name : $taxonomy) ?></option>
		<?php endforeach ?>
	</select>
	<input type="text" name="auto[tags][]" placeholder="<?php _e('comma-separated tags', 'uber-grid')?>" value="<?php echo esc_attr($filter['tags']) ?>">
	<select name="auto[operators][]">
		<option value="IN" <?php selected('IN', $filter['operator']) ?>>IN</option>
		<option value="NOT IN" <?php selected('NOT IN', $filter['operator']) ?>>NOT IN</option>
		<option value="OR" <?php selected('OR', $filter['operator']) ?>>OR</option>
		<option value="AND" <?php selected('AND', $filter['operator']) ?>>AND</option>
	</select>
	<button class="button"><?php _e('Remove', 'uber-grid')?></button>
</li>