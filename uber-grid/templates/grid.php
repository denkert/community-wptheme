<?php if ($this->font_families()): ?>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=<?php echo urlencode(implode('|', $this->font_families())) ?>"></link>
<?php endif ?>
<?php if (current_user_can('manage_options') && $options['show_edit']): ?>
	<div class="uber-grid-edit-wrapper">
		<a href="<?php echo admin_url('edit
				.php?post_type=uber-grid&page=support&url=http://' .
				$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']) ?>"><?php _e('Ask for support','uber-grid') ?></a>&nbsp;
		<a href="<?php echo admin_url('admin.php?page=uber-grid-image-troubleshooting-easy') ?>"><?php _e('Images not showing?', 'uber-grid') ?></a>&nbsp;
		<a href="<?php echo admin_url("post.php?post={$this->id}&action=edit") ?>" class="edit-grid"><?php _e('Edit grid', 'uber-grid')?></a>
	</div>
<?php endif ?>

<div class="<?php echo $this->get_classes() ?>" id="uber-grid-wrapper-<?php echo $this->id ?>" data-slug="<?php echo esc_attr($this->slug) ?>">
	<?php if (count($this->get_tags())): ?>
		<div class="uber-grid-filters">
			<div><a href="#"><?php _e($this->filters_all, 'uber-grid')?></a></div>
			<?php foreach($this->get_tags() as $tag): ?>
			<div><a href="#<?php echo esc_attr($tag) ?>"><?php echo esc_html($tag)?></a></div>
			<?php endforeach ?>
		</div>
	<?php endif ?>
	<div class="uber-grid-cells-wrapper">
		<div class="<?php echo implode(' ', $this->grid_classes()) ?>" id="uber-grid-<?php echo $this->id ?>" data-cell-width="<?php echo $this->cell_width ?>" data-cell-border="<?php echo $this->cell_border_width ?>" data-cell-gap="<?php echo $this->cell_gap ?>">
			<?php $this->render_cells() ?>
		</div>
	</div>
	<?php if ($this->pagination_enable): ?>
		<?php $this->render_pagination() ?>
	<?php endif ?>
</div>
<script>new UberGrid('#uber-grid-wrapper-<?php echo $this->id ?>', <?php echo json_encode($this->js_options()) ?>);</script>
