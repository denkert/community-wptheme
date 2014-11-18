<li>
	<?php global $wpdb ?>
	<select name="auto[meta_keys][]">
		<?php foreach($wpdb->get_results("SELECT DISTINCT(meta_key) FROM `$wpdb->postmeta` ORDER BY meta_key") as $result): ?>
			<option value="<?php echo esc_attr($result->meta_key )?>" <?php selected($filter['meta_key'], $result->meta_key)?>><?php echo esc_html($result->meta_key)?></option>
		<?php endforeach ?>
	</select>
	<select name="auto[meta_operators][]">
		<option value="=" <?php selected($filter['meta_operator'], '=')?>>=</option>
		<option value="!=" <?php selected($filter['meta_operator'], '!=')?>>!=</option>
		<option value="<" <?php selected($filter['meta_operator'], '<')?>>&lt;</option>
		<option value=">" <?php selected($filter['meta_operator'], '>')?>>&gt;</option>
		<option value="<=" <?php selected($filter['meta_operator'], '<=')?>>&lt;=</option>
		<option value=">=" <?php selected($filter['meta_operator'], '>=')?>>&gt;=</option>
	</select>
	<input type="text" name="auto[meta_values][]" placeholder="<?php _e('value') ?>" value="<?php echo esc_attr($filter['meta_value'])?>">
	<select name="auto[meta_types][]">
		<option value="CHAR" <?php selected($filter['meta_type'], 'CHAR')?>>CHAR</option>
		<option value="NUMERIC" <?php selected($filter['meta_type'], 'NUMERIC')?>>NUMERIC</option>
		<option value="BINARY" <?php selected($filter['meta_type'], 'BINARY')?>>BINARY</option>
		<option value="DATE" <?php selected($filter['meta_type'], 'DATE')?>>DATE</option>
		<option value="DATETIME" <?php selected($filter['meta_type'], 'DATETIME')?>>DATETIME</option>
		<option value="DECIMAL" <?php selected($filter['meta_type'], 'DECIMAL')?>>DECIMAL</option>
	</select>
	<button class="button"><?php _e('Remove', 'uber-grid')?></button>
</li>