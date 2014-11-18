<?php require('grid-style-grid.php') ?>
<?php $i = 0 ?>
<?php foreach($this->cells as $cell): ?>
	<?php if ($cell->background_color): ?>
		li#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?>{
			background-color: <?php echo uber_grid_color($cell->background_color) ?>;
		}
	<?php endif ?>

	<?php if ($cell->title_background_color || $cell->title_background_image): ?>
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title-wrapper{
			background-color: <?php echo uber_grid_color($cell->title_background_color, preg_match('/\-io$/', $cell->layout)) ?>;
			background-color: <?php echo uber_grid_color($cell->title_background_color, preg_match('/\-io$/', $cell->layout) ? 0.8 : 1) ?>;
			background: -moz-linear-gradient(top left,  rgba(0,0,0,0.1) 0%, rgba(0,0,0,0) 100%), <?php echo uber_grid_color($cell->title_background_color, preg_match('/\-io$/', $cell->layout) ? '0.8' : 1) ?>; /* FF3.6+ */
			background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,rgba(0,0,0,0.1)), color-stop(100%,rgba(0,0,0,0))), <?php echo uber_grid_color($cell->title_background_color, preg_match('/\-io$/', $cell->layout) ? '0.8' : 1) ?>; /* Chrome,Safari4+ */
			background: -o-linear-gradient(to top left,  rgba(0,0,0,0.1) 0%, rgba(0,0,0,0) 100%), <?php echo uber_grid_color($cell->title_background_color, preg_match('/\-io$/', $cell->layout) ? '0.8' : 1); ?>; /* Opera 11.10+ */
			background: -ms-linear-gradient(top,  rgba(0,0,0,0.1) 0%,rgba(0,0,0,0) 100%), <?php echo uber_grid_color($cell->title_background_color, preg_match('/\-io$/', $cell->layout) ? '0.8' : 1); ?>; /* IE10+ */
			background: linear-gradient(to top left,  rgba(0,0,0,0.1) 0%,rgba(0,0,0,0) 100%), <?php echo uber_grid_color($cell->title_background_color, preg_match('/\-io$/', $cell->layout) ? '0.8' : 1);?>; /* W3C */
			<?php if ($cell->title_background_image): ?>
				background-image: url(<?php echo $cell->getTitleBackgroundImageSrc() ?>)  !important;
			<?php endif ?>

		}
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title-wrapper:after{
			<?php if ($cell->imageLocation() == 'ir'): ?>
				border-left-color: <?php echo uber_grid_color($cell->title_background_color) ?>;
			<?php elseif ($cell->imageLocation() == 'il'): ?>
				border-right-color: <?php echo uber_grid_color($cell->title_background_color) ?>;
			<?php elseif ($cell->imageLocation() == 'ib'): ?>
				border-top-color: <?php echo uber_grid_color($cell->title_background_color) ?>;
			<?php elseif ($cell->imageLocation() == 'it'): ?>
				border-bottom-color: <?php echo uber_grid_color($cell->title_background_color) ?>;
			<?php endif ?>
		}
	<?php endif ?>
	<?php switch($cell->title_position): ?><?php case 'center': ?>
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title{
			text-align: center !important;
			line-height: 1.4 !important;
			box-sizing: border-box !important;
			-moz-box-sizing: border-box !important;
			top: 50%;
			padding-left: 4%;
			padding-right: 4%;
			width: 100%;
      height: auto;
      left: 0;
			position: absolute;
			margin-top: -<?php echo (($this->title_font_size ? $this->title_font_size : 13) * 1.2 + trim($cell->tagline) ? (($this->tagline_font_size ? $this->tagline_font_size : 13) * 1.2) : 0) / 2 ?>px;
		}
		@media screen and (max-width: 768px){
			div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title{
				margin-top: -<?php echo (($this->responsive_768_title_font_size ? $this->responsive_768_title_font_size : 13) * 1.2 +  trim($cell->tagline) ? (($this->responsive_768_tagline_font_size ? $this->responsive_768_tagline_font_size : 13) * 1.2) : 0) / 2 ?>px;
			}
		}
		@media screen and (max-width: 440px){
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title{
				margin-top: -<?php echo (($this->responsive_440_title_font_size ? $this->responsive_440_title_font_size : 13) * 1.2 + trim($cell->tagline) ? (($this->responsive_440_tagline_font_size ? $this->responsive_440_tagline_font_size : 13) * 1.2) : 0) / 2 ?>px;
			}
		}


	<?php break ?><?php case 'top-center'?><?php case 'top-left' ?><?php case 'top-right'?>
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title{
			padding: 8%;
			text-align: <?php echo str_replace('top-', '', $cell->title_position)?>;
		}
	<?php break ?>
	<?php break ?><?php case 'bottom-center'?><?php case 'bottom-left' ?><?php case 'bottom-right'?>
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title{
			bottom: 0;
			right: 0;
			height: auto;
			top: auto;
			position: absolute;
			padding: 8%;
			text-align: <?php echo str_replace('bottom-', '', $cell->title_position)?>;
		}
	<?php break ?>
	<?php break ?><?php case 'top-left-bottom-left'?><?php case 'top-left-bottom-right'?>
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title{
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			text-align: left;
		}
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title strong{
			position: absolute;
			top: 8%;
			left: <?php echo $cell->get_image_columns() == 1 ? '8' : '4' ?>%;
			right: <?php echo $cell->get_image_columns() == 1 ? '8' : '4' ?>%
		}
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title small{
			position: absolute;
			bottom: 8%;
			<?php echo str_replace('top-left-bottom-', '', $cell->title_position) ?>: <?php echo $cell->get_image_columns() == 1 ? '8' : '4' ?>%;
		}
	<?php break ?><?php case 'top-right-bottom-left'?><?php case 'top-right-bottom-right'?>
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title{
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			text-align: right;
		}
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title strong{
			position: absolute;
			left: <?php echo $cell->get_image_columns() == 1 ? '8' : '4' ?>%;
			right: <?php echo $cell->get_image_columns() == 1 ? '8' : '4' ?>%
			text-aligh: right;
		}
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title small{
			position: absolute;
			bottom: 8%;
			<?php echo str_replace('top-right-bottom-', '', $cell->title_position) ?>: 8%;
			max-width: 92%
		}

	<?php endswitch ?>
	<?php if ($cell->title_color): ?>
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title strong{
			color: <?php echo uber_grid_color($cell->title_color) ?>;
		}
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?>.io .uber-grid-cell-title strong{
			color: <?php echo $cell->title_color ?>;
		}
	<?php endif ?>

	<?php if ($cell->tagline_color): ?>
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-title small{
			color: <?php echo uber_grid_color($cell->tagline_color) ?>;
		}
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?>.io .uber-grid-cell-title small{
			color: <?php echo $cell->tagline_color ?>;
		}
	<?php endif ?>

	<?php if ($cell->hover_enable): ?>
			<?php if ($cell->hover_text_color): ?>
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover,
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover a,
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-title,
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-title strong{
					color: <?php echo uber_grid_color($cell->hover_text_color) ?>;
				}
			<?php endif ?>
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover{
			<?php if ($cell->hover_background_color): ?>
				background-color: <?php echo uber_grid_color($cell->hover_background_color) ?>;
				background-color: <?php echo uber_grid_color($cell->hover_background_color, 0.9) ?>;
			<?php endif ?>
			<?php if ($cell->hover_background_image): ?>
				background-image: url(<?php echo $cell->getHoverBackgroundImageSrc() ?>) !important;
			<?php endif ?>
			padding: <?php echo $cell->get_columns() == 1 ? '8' : '4'?>%;
		}
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover strong.uber-grid-hover-title{
			margin-bottom: <?php echo (($this->title_font_size ? $this->title_font_size : 13) * 1.2 + ($this->tagline_font_size ? $this->tagline_font_size : 13) * 1.2) / 4 ?>px;
		}

		<?php switch ($cell->hover_position):
			case 'top-right': ?>
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner{
					 text-align: right;
				}
			<?php break;
			case 'top-center': ?>
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner{
				text-align: center;
				}
			<?php break;
			case 'bottom-center': ?>
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner{
					text-align: center;
					position: absolute;
					left: <?php $cell->echo_horizontal_padding() ?>;
					bottom: <?php $cell->echo_vertical_padding() ?>;
					right: <?php $cell->echo_horizontal_padding() ?>;
					max-height: 90%;
				}
			<?php break;
			case 'bottom-left': ?>
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner{
					text-align: left;
					position: absolute;
					left: <?php $cell->echo_horizontal_padding() ?>;
					right: <?php $cell->echo_horizontal_padding() ?>;
					bottom: <?php $cell->echo_vertical_padding() ?>;
					max-height: 90%;
				}
			<?php break;
			case 'bottom-right': ?>
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner{
				text-align: right;
				position: absolute;
				left: <?php $cell->echo_horizontal_padding() ?>;
				bottom: <?php $cell->echo_vertical_padding() ?>;
				right: <?php $cell->echo_horizontal_padding() ?>;
				max-height: 90%;
				}
			<?php break;
			case 'center': ?>
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner{
				text-align: center;
				position: absolute;
				right: <?php $cell->echo_horizontal_padding() ?>;
				top: 50%;
				left: <?php $cell->echo_horizontal_padding() ?>;
				max-height: 60%;
				margin-top: -<?php echo ($this->hover_title_font_size + $this->hover_text_font_size * 2) / 1.4 ?>px;
				}
				<?php break;
			case 'top-left-bottom-right': ?>
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner{
					height: 100%;
				}
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner .uber-grid-hover-title{
					position: absolute;
					left: <?php $cell->echo_horizontal_padding() ?>;
					top: <?php $cell->echo_vertical_padding() ?>;
					display: block;
				}
				div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner .uber-grid-hover-text{
					position: absolute;
					right: <?php $cell->echo_horizontal_padding() ?>;
					bottom: <?php $cell->echo_vertical_padding() ?>;
					display: block;
				}
				<?php break;
				case 'top-left-bottom-left': ?>
					div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner{
					height: 100%;
					}
					div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner .uber-grid-hover-title{
					position: absolute;
					left: <?php $cell->echo_horizontal_padding() ?>;
					top: <?php $cell->echo_vertical_padding() ?>;
					display: block;
					}
					div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner .uber-grid-hover-text{
					position: absolute;
					left: <?php $cell->echo_horizontal_padding() ?>;
					bottom: <?php $cell->echo_vertical_padding() ?>;
					display: block;
					}
				<?php break;
				case 'top-right-bottom-right': ?>
					div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner{
					height: 100%;
					}
					div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner .uber-grid-hover-title{
					position: absolute;
					right: <?php $cell->echo_horizontal_padding() ?>;
					top: <?php $cell->echo_vertical_padding() ?>;
					display: block;
					}
					div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-hover-inner .uber-grid-hover-text{
					position: absolute;
					right: <?php $cell->echo_horizontal_padding() ?>;
					bottom: <?php $cell->echo_vertical_padding() ?>;
					display: block;
					}
					<?php break;
			default:

			endswitch ?>
	<?php endif ?>
	<?php if ($cell->label_enable): ?>
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-label{
			background-color: <?php echo uber_grid_color($cell->label_background_color) ?>;
			<?php if ($cell->label_border_top): ?>
				border-top: <?php echo $cell->label_border_top ?>px solid <?php echo uber_grid_color($cell->label_border_top_color) ?>;
			<?php endif ?>
			<?php if ($cell->label_border_bottom): ?>
				border-bottom: <?php echo $cell->label_border_bottom ?>px solid <?php echo uber_grid_color($cell->label_border_bottom_color) ?>;
			<?php endif ?>
		}
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-label .uber-grid-label-heading,
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-label .uber-grid-price-tag{
			color: <?php echo uber_grid_color($cell->label_title_color) ?>;
		}
		div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-label .uber-grid-label-text{
			color: <?php echo uber_grid_color($cell->label_tagline_color) ?>;
		}
		<?php if ($cell->label_price_color): ?>
			div#uber-grid-<?php echo $this->id ?>-cell-<?php echo $i ?> .uber-grid-cell-label .uber-grid-price-tag{
				color: <?php echo uber_grid_color($cell->label_price_color) ?>;
			}
		<?php endif ?>
	<?php endif ?>
	<?php $i++ ?>
<?php endforeach ?>
