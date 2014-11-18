<?php if ($have_social): ?>
<div class="uber-grid-social">
	<?php foreach(array('facebook', 'twitter', 'instagram', 'linkedin', 'pinterest', 'email', 'skype', 'dribbble', 'flickr', 'website', 'googleplus') as $service): ?>
		<?php $service_name = "lightbox_{$service}"?>
		<?php if ($cell->$service_name): ?>
			<a href="<?php echo esc_url($cell->$service_name) ?>" class="uber-grid-<?php echo $service ?>" target="_blank"></a>
		<?php endif?>
	<?php endforeach ?>
</div>
<?php endif ?>
