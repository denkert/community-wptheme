<p>
	<label><input type="checkbox" name="effects[bw]" value="1" <?php echo checked($grid->bw) ?>> <?php _e('Black & white images', 'uber-grid')?></label>
</p>
<p>
	<label><?php _e('Hover effect', 'uber-grid')?></label>
	<select name="effects[hover_effect]">
		<option value="none" <?php selected($grid->hover_effect, '')?>><?php _e('None', 'uber-grid')?></option>
		<option value="fade-in" <?php selected($grid->hover_effect, 'fade-in')?>><?php _e('Fade In', 'uber-grid')?></option>
		<option value="slide-down" <?php selected($grid->hover_effect, 'slide-down')?>><?php _e('Slide down', 'uber-grid')?></option>
		<option value="slide-up" <?php selected($grid->hover_effect, 'slide-up')?>><?php _e('Slide up', 'uber-grid')?></option>
		<option value="slide-left" <?php selected($grid->hover_effect, 'slide-left')?>><?php _e('Slide left', 'uber-grid')?></option>
		<option value="slide-right" <?php selected($grid->hover_effect, 'slide-right')?>><?php _e('Slide right', 'uber-grid')?></option>
		<option value="fly-in" <?php selected($grid->hover_effect, 'fly-in')?>><?php _e('Fly-In', 'uber-grid')?></option>
		<option value="fly-out" <?php selected($grid->hover_effect, 'fly-out')?>><?php _e('Fly-Out', 'uber-grid')?></option>
		<option value="teeth" <?php selected($grid->hover_effect, 'teeth')?>><?php _e('Teeth', 'uber-grid')?></option>
		<option value="jaws" <?php selected($grid->hover_effect, 'jaws')?>><?php _e('Jaws', 'uber-grid')?></option>
	</select>
</p>