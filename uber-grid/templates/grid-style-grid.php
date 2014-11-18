div#uber-grid-wrapper-<?php echo $this->id ?>{
	min-width: <?php echo $this->get_columns_width($this->has_2x_cells() ? 2 : 1)?>px !important;
}
/* Cell layouts */
#uber-grid-<?php echo $this->id ?> > div{
	border-width: <?php echo (int)$this->cell_border_width ?>px;
	<?php if ((float)$this->cell_border_opacity < 1): ?>
		-webkit-transition: border-color 0.2s;
		-moz-transition: border-color 0.2s;
		-ms-transition: border-color 0.2s;
		-o-transition: border-color 0.2s;
		transition: border-color 0.2s;
	<?php endif ?>
	border-color: <?php echo uber_grid_color($this->cell_border_color, $this->cell_border_opacity) ?>;
	<?php if ((int)$this->cell_shadow_radius > 0 ): ?>
		box-shadow: 0px 0px <?php echo $this->cell_shadow_radius ?>px 0px rgba(0, 0, 0, 0.15);
		-o-box-shadow: 0px 0px <?php echo $this->cell_shadow_radius ?>px 0px rgba(0, 0, 0, 0.15);
		-ms-box-shadow: 0px 0px <?php echo $this->cell_shadow_radius ?>px 0px rgba(0, 0, 0, 0.15);
		-moz-box-shadow: 0px 0px <?php echo $this->cell_shadow_radius ?>px 0px rgba(0, 0, 0, 0.15);
		-webkit-box-shadow: 0px 0px <?php echo $this->cell_shadow_radius ?>px 0px rgba(0, 0, 0, 0.15);
	<?php endif ?>
	
}

<?php if ((int)$this->cell_border_radius > 0 ): ?>
	#uber-grid-<?php echo $this->id ?> > div,
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-hover,
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-blur,
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-wrapper,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-image,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-title-wrapper,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-title,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-content{
		overflow: hidden !important;
		<?php if ((int)$this->cell_border_radius > 0): ?>
			border-radius: <?php echo $this->cell_border_radius ?>px !important;
			-o-border-radius: <?php echo $this->cell_border_radius ?>px;
			-ms-border-radius: <?php echo $this->cell_border_radius ?>px;
			-moz-border-radius: <?php echo $this->cell_border_radius ?>px;
			-webkit-border-radius: <?php echo $this->cell_border_radius ?>px !important;
		<?php endif ?>
	}
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-wrapper{
		<?php if ((int)$this->cell_border_width > 0): ?>
			border-radius: <?php echo $this->cell_border_radius - 3 ?>px;
			-o-border-radius: <?php echo $this->cell_border_radius - 3 ?>px;
			-ms-border-radius: <?php echo $this->cell_border_radius - 3 ?>px;
			-moz-border-radius: <?php echo $this->cell_border_radius - 3?>px;
			-webkit-border-radius: <?php echo $this->cell_border_radius - 3 ?>px;
		<?php endif ?>
	}
	#uber-grid-<?php echo $this->id ?> > div.uber-grid-has-label .uber-grid-cell-wrapper{
		-webkit-border-bottom-right-radius: 0 !important;
		-webkit-border-bottom-left-radius: 0 !important;
		-moz-border-radius-bottomright: 0 !important;
		-moz-border-radius-bottomleft: 0 !important;
		border-bottom-right-radius: 0 !important;
		border-bottom-left-radius: 0 !important;
		overflow: hidden;
	}
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-label{
		-webkit-border-bottom-right-radius: <?php echo $this->cell_border_radius - 3 ?>px !important;
		-webkit-border-bottom-left-radius: <?php echo $this->cell_border_radius - 3 ?>px !important;
		-moz-border-radius-bottomright: <?php echo $this->cell_border_radius - 3 ?>px !important;
		-moz-border-radius-bottomleft: <?php echo $this->cell_border_radius - 3 ?>px !important;
		border-bottom-right-radius: <?php echo $this->cell_border_radius - 3 ?>px !important;
		border-bottom-left-radius: <?php echo $this->cell_border_radius - 3 ?>px !important;
		overflow: hidden;
	}
<?php endif ?>

<?php if ((int)$this->responsive_768_cell_border_radius > 0 ): ?>
	@media screen and (max-width: 768px){
	#uber-grid-<?php echo $this->id ?> > div,
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-hover,
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-blur,
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-wrapper,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-image,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-title-wrapper,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-title,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-content{
		overflow: hidden !important;
		<?php if ((int)$this->responsive_768_cell_border_radius > 0): ?>
			border-radius: <?php echo $this->responsive_768_cell_border_radius ?>px !important;
			-o-border-radius: <?php echo $this->responsive_768_cell_border_radius ?>px;
			-ms-border-radius: <?php echo $this->responsive_768_cell_border_radius ?>px;
			-moz-border-radius: <?php echo $this->responsive_768_cell_border_radius ?>px;
			-webkit-border-radius: <?php echo $this->responsive_768_cell_border_radius ?>px !important;
		<?php endif ?>
	}
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-wrapper{
		<?php if ((int)$this->responsive_768_cell_border_width > 0): ?>
			border-radius: <?php echo $this->responsive_768_cell_border_radius - 3 ?>px;
			-o-border-radius: <?php echo $this->responsive_768_cell_border_radius - 3 ?>px;
			-ms-border-radius: <?php echo $this->responsive_768_cell_border_radius - 3 ?>px;
			-moz-border-radius: <?php echo $this->responsive_768_cell_border_radius - 3?>px;
			-webkit-border-radius: <?php echo $this->responsive_768_cell_border_radius - 3 ?>px;
		<?php endif ?>
	}
	#uber-grid-<?php echo $this->id ?> > div.uber-grid-has-label .uber-grid-cell-wrapper{
		-webkit-border-bottom-right-radius: 0 !important;
		-webkit-border-bottom-left-radius: 0 !important;
		-moz-border-radius-bottomright: 0 !important;
		-moz-border-radius-bottomleft: 0 !important;
		border-bottom-right-radius: 0 !important;
		border-bottom-left-radius: 0 !important;
		overflow: hidden;
	}
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-label{
		-webkit-border-bottom-right-radius: <?php echo $this->responsive_768_cell_border_radius - 3 ?>px !important;
		-webkit-border-bottom-left-radius: <?php echo $this->responsive_768_cell_border_radius - 3 ?>px !important;
		-moz-border-radius-bottomright: <?php echo $this->responsive_768_cell_border_radius - 3 ?>px !important;
		-moz-border-radius-bottomleft: <?php echo $this->responsive_768_cell_border_radius - 3 ?>px !important;
		border-bottom-right-radius: <?php echo $this->responsive_768_cell_border_radius - 3 ?>px !important;
		border-bottom-left-radius: <?php echo $this->responsive_768_cell_border_radius - 3 ?>px !important;
		overflow: hidden;
	}
}
<?php endif ?>

<?php if ((int)$this->responsive_440_cell_border_radius > 0 ): ?>
	@media screen and (max-width: 440px){
	#uber-grid-<?php echo $this->id ?> > div,
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-hover,
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-blur,
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-wrapper,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-image,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-title-wrapper,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-title,
	#uber-grid-<?php echo $this->id ?> > div.io .uber-grid-cell-content{
		overflow: hidden !important;
		<?php if ((int)$this->responsive_440_cell_border_radius > 0): ?>
			border-radius: <?php echo $this->responsive_440_cell_border_radius ?>px !important;
			-o-border-radius: <?php echo $this->responsive_440_cell_border_radius ?>px;
			-ms-border-radius: <?php echo $this->responsive_440_cell_border_radius ?>px;
			-moz-border-radius: <?php echo $this->responsive_440_cell_border_radius ?>px;
			-webkit-border-radius: <?php echo $this->responsive_440_cell_border_radius ?>px !important;
		<?php endif ?>
	}
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-wrapper{
		<?php if ((int)$this->responsive_440_cell_border_width > 0): ?>
			border-radius: <?php echo $this->responsive_440_cell_border_radius - 3 ?>px;
			-o-border-radius: <?php echo $this->responsive_440_cell_border_radius - 3 ?>px;
			-ms-border-radius: <?php echo $this->responsive_440_cell_border_radius - 3 ?>px;
			-moz-border-radius: <?php echo $this->responsive_440_cell_border_radius - 3?>px;
			-webkit-border-radius: <?php echo $this->responsive_440_cell_border_radius - 3 ?>px;
		<?php endif ?>
	}
	#uber-grid-<?php echo $this->id ?> > div.uber-grid-has-label .uber-grid-cell-wrapper{
		-webkit-border-bottom-right-radius: 0 !important;
		-webkit-border-bottom-left-radius: 0 !important;
		-moz-border-radius-bottomright: 0 !important;
		-moz-border-radius-bottomleft: 0 !important;
		border-bottom-right-radius: 0 !important;
		border-bottom-left-radius: 0 !important;
		overflow: hidden;
	}
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-label{
		-webkit-border-bottom-right-radius: <?php echo $this->responsive_440_cell_border_radius - 3 ?>px !important;
		-webkit-border-bottom-left-radius: <?php echo $this->responsive_440_cell_border_radius - 3 ?>px !important;
		-moz-border-radius-bottomright: <?php echo $this->responsive_440_cell_border_radius - 3 ?>px !important;
		-moz-border-radius-bottomleft: <?php echo $this->responsive_440_cell_border_radius - 3 ?>px !important;
		border-bottom-right-radius: <?php echo $this->responsive_440_cell_border_radius - 3 ?>px !important;
		border-bottom-left-radius: <?php echo $this->responsive_440_cell_border_radius - 3 ?>px !important;
		overflow: hidden;
	}
}
<?php endif ?>


<?php if ((float)$this->cell_border_opacity < 1): ?>
#uber-grid-<?php echo $this->id ?> li:hover{
	border-color: <?php echo uber_grid_color($this->cell_border_color, 0.7) ?>;
}
<?php endif ?>

#uber-grid-<?php echo $this->id ?> > div.r1c1 .uber-grid-cell-wrapper{
	width: <?php echo $this->cell_width  ?>px;
	height: <?php echo $this->cell_height ?>px;
}
#uber-grid-<?php echo $this->id ?> > div.r2c2 .uber-grid-cell-wrapper{
	width: <?php echo $this->cell_width * 2 + $this->cell_border_width * 2  + $this->cell_gap ?>px;
	height: <?php echo $this->cell_height * 2 + $this->cell_border_width * 2  + $this->cell_gap ?>px;
}
#uber-grid-<?php echo $this->id ?> > div.r2c1 .uber-grid-cell-wrapper{
	width: <?php echo $this->cell_width ?>px;
	height: <?php echo $this->cell_height * 2 + $this->cell_border_width * 2 + $this->cell_gap?>px;
}
#uber-grid-<?php echo $this->id ?> > div.r1c2 .uber-grid-cell-wrapper{
	width: <?php echo $this->cell_width * 2 + $this->cell_border_width * 2  + $this->cell_gap ?>px;
	height: <?php echo $this->cell_height  ?>px;
}
#uber-grid-<?php echo $this->id ?> > div.r1c1, #uber-grid-<?php echo $this->id ?> div.r2c1{
	width: <?php echo $this->cell_width ?>px;
}
#uber-grid-<?php echo $this->id ?> > div.r2c2, #uber-grid-<?php echo $this->id ?> div.r1c2{
	width: <?php echo $this->cell_width * 2 + $this->cell_border_width * 2  + $this->cell_gap ?>px;
}

@media screen and (max-width: 768px){
	#uber-grid-<?php echo $this->id ?> .uber-grid-cell{
		border-width: <?php echo $this->responsive_768_cell_border_width ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r1c1 .uber-grid-cell-wrapper{
		width: <?php echo $this->responsive_768_cell_width ?>px;
		height: <?php echo $this->responsive_768_cell_height ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r2c2 .uber-grid-cell-wrapper{
		width: <?php echo $this->responsive_768_cell_width * 2 + $this->responsive_768_cell_border_width * 2  + $this->responsive_768_cell_gap ?>px;
		height: <?php echo $this->responsive_768_cell_height * 2 + $this->responsive_768_cell_border_width * 2  + $this->responsive_768_cell_gap ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r2c1 .uber-grid-cell-wrapper{
		width: <?php echo $this->responsive_768_cell_width ?>px;
		height: <?php echo $this->responsive_768_cell_height * 2 + $this->responsive_768_cell_border_width * 2 + $this->responsive_768_cell_gap ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r1c2 .uber-grid-cell-wrapper{
		width: <?php echo $this->responsive_768_cell_width * 2 + $this->responsive_768_cell_border_width * 2  + $this->responsive_768_cell_gap ?>px;
		height: <?php echo $this->responsive_768_cell_height ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r1c1, #uber-grid-<?php echo $this->id ?> > div.r2c1{
		width: <?php echo $this->responsive_768_cell_width ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r2c2, #uber-grid-<?php echo $this->id ?> > div.r1c2{
		width: <?php echo $this->responsive_768_cell_width * 2 + $this->responsive_768_cell_border_width * 2  + $this->responsive_768_cell_gap ?>px;
	}
}

@media screen and (max-width: 440px){
	#uber-grid-<?php echo $this->id ?> .uber-grid-cell{
		border-width: <?php echo $this->responsive_440_cell_border_width ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r1c1 .uber-grid-cell-wrapper{
		width: <?php echo $this->responsive_440_cell_width ?>px;
		height: <?php echo $this->responsive_440_cell_height ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r2c2 .uber-grid-cell-wrapper{
		width: <?php echo $this->responsive_440_cell_width * 2 + $this->responsive_440_cell_border_width * 2  + $this->responsive_440_cell_gap ?>px;
		height: <?php echo $this->responsive_440_cell_height * 2 + $this->responsive_440_cell_border_width * 2  + $this->responsive_440_cell_gap ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r2c1 .uber-grid-cell-wrapper{
		width: <?php echo $this->responsive_440_cell_width ?>px;
		height: <?php echo $this->responsive_440_cell_height * 2 + $this->responsive_440_cell_border_width * 2 + $this->responsive_440_cell_gap ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r1c2 .uber-grid-cell-wrapper{
		width: <?php echo $this->responsive_440_cell_width * 2 + $this->responsive_440_cell_border_width * 2  + $this->responsive_440_cell_gap  ?>px;
		height: <?php echo $this->responsive_440_cell_height  ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r1c1, #uber-grid-<?php echo $this->id ?> > div.r2c1{
		width: <?php echo $this->responsive_440_cell_width ?>px;
	}
	#uber-grid-<?php echo $this->id ?> > div.r2c2, #uber-grid-<?php echo $this->id ?> > div.r1c2{
		width: <?php echo $this->responsive_440_cell_width * 2 + $this->responsive_440_cell_border_width * 2  + $this->responsive_440_cell_gap ?>px;
	}
}


/* Fonts */ 

<?php $font_settings = array(
	'title' => "#uber-grid-{$this->id} > div .uber-grid-cell-title strong",
	'tagline' => "#uber-grid-{$this->id} > div .uber-grid-cell-title small",
	'hover_text' => "#uber-grid-{$this->id} > div .uber-grid-hover .uber-grid-hover-text",
	'hover_title' => "#uber-grid-{$this->id} > div .uber-grid-hover .uber-grid-hover-title strong",
	'lightbox_title' => ".uber-grid-{$this->id}-lightbox h3",
	'lightbox_text' => ".uber-grid-{$this->id}-lightbox",
	'label_title' => "#uber-grid-{$this->id} .uber-grid-cell-label .uber-grid-label-heading",
	'label_tagline' => "#uber-grid-{$this->id} .uber-grid-cell-label .uber-grid-label-text",
	'label_price' => "#uber-grid-{$this->id} .uber-grid-price-tag",
	'lightbox_text' => ".uber-grid-{$this->id}-lightbox-content",
	'lightbox_title' => ".uber-grid-{$this->id}-lightbox-content h3",
	'filters' => "#uber-grid-wrapper-{$this->id} .uber-grid-filters div a",
	'pagination' => "#uber-grid-wrapper-{$this->id} .uber-grid-pagination div a"
); 
?>
<?php foreach($font_settings as $var => $selector): ?>
	<?php $v1 = "{$var}_font" ?>
	<?php $v2 = "{$var}_font_style" ?>
	<?php $v3 = "{$var}_font_size" ?>
	<?php if ($this->$v1 || $this->$v2 || $this->$v3): ?>
	<?php echo $selector ?>{
		<?php if ($this->$v1): ?>
			font-family: "<?php echo $this->$v1 ?>", 'Helvetica Neue', Helvetica, sans-serif; 
		<?php endif ?>
		<?php if ($this->$v2): ?>
			font-weight: <?php echo $this->parse_font_weight($this->$v2) ?>;
			font-style: <?php echo $this->parse_font_style($this->$v2)?>;
		<?php endif ?>

		<?php if($this->$v3): ?>
			font-size: <?php echo $this->$v3 ?>px;
		<?php endif ?>
	}
	<?php endif ?>
<?php endforeach ?>

<?php if ($this->label_max_height): ?>
#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-label{
	height: <?php echo $this->label_max_height ?>px;
}
<?php endif ?>

<?php $font_settings = array(
	'title' => "#uber-grid-{$this->id} > div .uber-grid-cell-title strong",
	'tagline' => "#uber-grid-{$this->id} > div .uber-grid-cell-title small",
	'hover_text' => "#uber-grid-{$this->id} > div .uber-grid-hover .uber-grid-hover-text",
	'hover_title' => "#uber-grid-{$this->id} > div .uber-grid-hover strong",
	'label_title' => "#uber-grid-{$this->id} .uber-grid-cell-label .uber-grid-label-heading",
	'label_tagline' => "#uber-grid-{$this->id} .uber-grid-cell-label .uber-grid-label-text",
	'label_price' => "#uber-grid-{$this->id} .uber-grid-price-tag"
); 
?>
@media screen and (max-width: 768px){
	<?php foreach($font_settings as $var => $selector): ?>
		<?php $v3 = "responsive_768_{$var}_font_size" ?>
		<?php if ($this->$v3): ?>
		<?php echo $selector ?>{
			<?php if($this->$v3): ?>
				font-size: <?php echo $this->$v3 ?>px;
			<?php endif ?>
		}
		<?php endif ?>
	<?php endforeach ?>

	<?php if ($this->responsive_768_label_max_height): ?>
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-label{
		height: <?php echo $this->responsive_768_label_max_height ?>px;
	}
	<?php endif ?>

	div#uber-grid-wrapper-<?php echo $this->id ?>{
		min-width: <?php echo $this->responsive_768_get_columns_width($this->has_2x_cells() ? 2 : 1)?>px !important;
	}
}

@media screen and (max-width: 440px){
	<?php foreach($font_settings as $var => $selector): ?>
		<?php $v3 = "responsive_440_{$var}_font_size" ?>
		<?php if ($this->$v3): ?>
		<?php echo $selector ?>{
			<?php if($this->$v3): ?>
				font-size: <?php echo $this->$v3 ?>px !important;
			<?php endif ?>
		}
		<?php endif ?>
	<?php endforeach ?>

	<?php if ($this->responsive_440_label_max_height): ?>
	#uber-grid-<?php echo $this->id ?> > div .uber-grid-cell-label{
		height: <?php echo $this->responsive_440_label_max_height ?>px;
	}
	<?php endif ?>

	div#uber-grid-wrapper-<?php echo $this->id ?>{
		min-width: <?php echo $this->responsive_440_get_columns_width($this->has_2x_cells() ? 2 : 1)?>px !important;
	}
}

#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-filters{
	text-align: <?php echo $this->filters_align ?>;
}
#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-filters > div a,
#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-filters > div a:visited{
	color: <?php echo uber_grid_color($this->filters_color) ?> !important;
	background-color: <?php echo uber_grid_color($this->filters_background_color)?> !important;
}
#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-filters > div a:hover{
	background-color: <?php echo uber_grid_color($this->filters_accent_background_color) ?> !important;
}

#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-filters > div.active a,
#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-filters > div.active a:visited{
	color: <?php echo uber_grid_color($this->filters_accent_color) ?> !important;
	background-color: <?php echo uber_grid_color($this->filters_accent_background_color)?> !important;
}


#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-pagination{
	text-align: <?php echo $this->pagination_align ?>;
}
#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-pagination > div a,
#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-pagination > div a:visited{
	color: <?php echo uber_grid_color($this->pagination_color) ?> !important;
	background-color: <?php echo uber_grid_color($this->pagination_background_color)?> !important;
}
#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-pagination div a:hover{
	background-color: <?php echo uber_grid_color($this->pagination_current_page_background_color) ?> !important;
}

#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-pagination div.uber-grid-current a,
#uber-grid-wrapper-<?php echo $this->id ?> div.uber-grid-pagination div.uber-grid-current a:visited{
	color: <?php echo uber_grid_color($this->pagination_current_page_color) ?> !important;
	background-color: <?php echo uber_grid_color($this->pagination_current_page_background_color)?> !important;
}
