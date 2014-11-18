<?php if ($cell->link_enable && !$cell->hover_enable): ?>
	<a <?php $cell->link_attributes($this) ?>>
<?php else: ?>
	<div class="uber-grid-cell-wrapper">
<?php endif?>
<div class="uber-grid-cell-content">
	<?php if ($cell->image): ?>
		<img src="<?php echo esc_attr($cell->get_image_src($this)) ?>" alt="<?php echo esc_attr($cell->title) ?>" data-lightbox-width="<?php echo $cell->get_lightbox_image_width() ?>"  data-lightbox-height="<?php echo $cell->get_lightbox_image_height() ?>" class="uber-grid-cell-image">
	<?php endif ?>
	<?php if ((trim($cell->title) || trim($cell->tagline)) && $cell->title_position): ?>
		<div class="uber-grid-cell-title-wrapper uber-grid-title-position-<?php echo $cell->title_position ?>">
			<div class="uber-grid-cell-title">
				<?php if (trim($cell->title)) :?>
					<strong><?php echo do_shortcode($cell->title) ?></strong>
				<?php endif?>
				<?php if (trim($cell->tagline)): ?>
					<small><?php echo do_shortcode($cell->tagline) ?></small>
				<?php endif?>
			</div>
		</div>
	<?php endif ?>
</div>
<?php if ($cell->hover_enable ): ?>
	<?php if ($cell->link_enable): ?>
		<a <?php $cell->hover_attributes($this) ?>>

	<?php else: ?>
		<div class="uber-grid-hover">
	<?php endif ?>
		<div class="uber-grid-hover-inner">
			<?php if ($cell->hover_title): ?>
				<div class="uber-grid-hover-title">
					<strong><?php echo do_shortcode($cell->hover_title)?></strong>
					<?php if ($cell->hover_text && !$cell->hover_hide_arrow): ?>⟶<?php endif ?>
				</div>
			<?php endif ?>
			<div class="uber-grid-hover-text"><?php echo nl2br(do_shortcode($cell->hover_text)) ?></div>
		</div>
	<?php if ($cell->link_enable): ?>
		</a>
	<?php else: ?>
	</div>
	<?php endif ?>
<?php endif ?>
<?php if ($cell->link_enable && !$cell->hover_enable): ?>
	</a>
<?php else: ?>
	</div>
<?php endif?>
<?php if ($cell->label_enable): ?>
	<div class="uber-grid-cell-label">
		<?php if ($cell->label_price): ?><div class="uber-grid-price-tag"><?php echo esc_html($cell->label_price)?></div><?php endif ?>
		<?php if (trim($cell->label_title)): ?><div class="uber-grid-label-heading"><?php echo do_shortcode($cell->label_title) ?></div><?php endif?>
		<?php if (trim($cell->label_tagline)): ?><div class="uber-grid-label-text"><?php echo do_shortcode($cell->label_tagline)?></div><?php endif ?>
	</div>
<?php endif ?>
<?php $have_social = false ?>
<?php foreach(array('facebook', 'twitter', 'linkedin', 'pinterest', 'email', 'skype', 'dribbble', 'flickr', 'website', 'googleplus') as $service): ?>
	<?php $service_name = "lightbox_{$service}"?>
	<?php if (!empty($cell->$service_name)): ?>
		<?php $have_social = true ?>
	<?php endif ?>
<?php endforeach ?>
<?php if ($cell->link_enable && $cell->link_mode == 'lightbox' &&  ($cell->lightbox_title || $cell->lightbox_text || $have_social)): ?>
	<div class="uber-grid-lightbox-content-wrapper">
		<?php if ($cell->lightbox_title || $cell->lightbox_text): ?>
			<div class="uber-grid-lightbox-content uber-grid-<?php echo $this->id ?>-lightbox-content <?php echo $have_social && $cell->lightbox_title && !$cell->lightbox_text ? 'uber-grid-nopadding-bottom' : '' ?>">
			<?php if ($cell->lightbox_title || $cell->lightbox_text): ?>
					<?php if ($cell->lightbox_title): ?>
					<h3 <?php echo $cell->lightbox_text ? '' : 'class="uber-grid-nopadding-bottom"'?>><?php echo do_shortcode($cell->lightbox_title) ?></h3>
					<?php endif ?>
					<?php if ($cell->lightbox_text): ?><div><?php echo do_shortcode(nl2br($cell->lightbox_text)) ?></div><?php endif ?>
			<?php endif ?>
			</div>
		<?php endif ?>
		<?php require('social.php') ?>
	</div>
<?php endif ?>
