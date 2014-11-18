<?php

class UberGrid_Cell {
	var $layout = 'r1c1-io';
	var $title = 'Title';
	var $title_color = '#FFFFFF';
	var $title_background_color = '#ff6760';
	var $title_background_image;
	var $title_position = 'center';
	var $tagline = 'Tagline';
	var $tagline_color = '#FFFFFF';

	var $tags;

	var $image;

	var $link_enable;
	var $link_url;
	var $link_rel;
	var $link_target;

	var $link_mode;
	var $lightbox_image;
	var $lightbox_title;
	var $lightbox_text;

	var $background_image;
	var $background_color;

	var $hover_enable;
	var $hover_title;
	var $hover_text;
	var $hover_text_color = '#FFFFFF';
	var $hover_background_image;
	var $hover_background_color;
	var $hover_hide_arrow = false;
	var $hover_position = "top-left";



	var $label_enable;
	var $label_title;
	var $label_tagline;
	var $label_title_color = '#FFFFFF';
	var $label_tagline_color = '#FFFFFF';
	var $label_background_color;
	var $label_price;
	var $label_price_color = "#FFFFFF";
	var $label_price_background_color = "";
	var $label_border_bottom = "0";
	var $label_border_top = '0';
	var $label_border_bottom_color = "#999";
	var $label_border_top_color = "#444";


	var $lightbox_facebook;
	var $lightbox_twitter;
	var $lightbox_instagram;
	var $lightbox_email;
	var $lightbox_linkedin;
	var $lightbox_skype;
	var $lightbox_pinterest;
	var $lightbox_googleplus;
	var $lightbox_flickr;
	var $lightbox_website;
	var $lightbox_dribbble;

	function __construct($data = null){
		if ($data){
			$this->assign($data);
		}
	}

	function assign($data){
		foreach ($this->get_cell_fields() as $name){
			 $this->$name = isset($data[$name]) ? $data[$name] : $this->$name;
		 };
	}

	function render_cell_attributes($grid, $page, $index){
		$attr = array('id' => "uber-grid-{$grid->id}-cell-{$index}");
		$attr['class'] = 'uber-grid-cell ' . str_replace('-', ' ', $this->layout);
		if ($this->hover_enable)
			$attr['class'] .= " uber-grid-hover";
		if ($this->label_enable)
			$attr['class'] .= " uber-grid-has-label";
		$attr['data-page'] = $page;
		if ($this->tags)
			$attr['data-tags'] = $this->tags;
		$attr['data-slug'] = $this->get_slug();
		$this->render_attributes($attr);
	}

	function render_select_options($options, $selected){
		foreach($options as $value => $text){
			echo "<option ";
			echo $this->format_attribute('value', $value);
			selected($value, $selected);
			echo ">" . $text . "</option>";
		}
	}

	function get_slug(){
		$parts = array();
		if ($this->image)
			$parts []= $this->image;
		if ($this->title)
			$parts []= $this->title;
		elseif ($this->tagline)
			$parts []= $this->tagline;
		return implode('-', array_map('sanitize_title', $parts));
	}

	function get_cell_fields($klass = null){
		if (!$klass)
			$klass = __CLASS__;
		$class = new ReflectionClass($klass);
		$props = array();
		foreach($class->getProperties(ReflectionProperty::IS_PUBLIC) as $prop){
			$props []= $prop->getName();
		}
		return $props;
	}

	function setImage($id){
		$this->image = $id;
	}

	function get_image_width($grid){
		if ($this->get_image_columns() == 2)
			return $grid->get_2x_width();
		return $grid->cell_width;
	}

	function get_image_height($grid){
		if ($this->get_image_rows() == 2)
			return $grid->get_2x_height();
		return $grid->cell_height;
	}

	function get_image_src($grid){
		$width = $this->get_image_width($grid);
		$height = $this->get_image_height($grid);
		$img = wp_get_attachment_image_src($this->image, 'original');
		return uber_grid_get_image_url($img[0], array('width' => $width, 'height' => $height));
	}

	function getBackgroundImageSrc(){
		$img = wp_get_attachment_image_src($this->background_image, 'original');
		return $img[0];
	}

	function getTitleBackgroundImageSrc(){
		$img = wp_get_attachment_image_src($this->title_background_image, 'original');
		return $img[0];
	}


	function getHoverBackgroundImageSrc(){
		$img = wp_get_attachment_image_src($this->hover_background_image, 'original');
		return $img[0];
	}

	function get_lightbox_image_src(){
		$img = wp_get_attachment_image_src($this->lightbox_image, 'original');
		return $img[0];
	}

	function get_lightbox_image_width(){
		$image = isset($this->lightbox_image) && $this->lightbox_image ? $this->lightbox_image : $this->image;
		$img = wp_get_attachment_image_src($image, 'original');
		return $img[1];
	}

	function get_lightbox_image_height(){
		$image = isset($this->lightbox_image) && $this->lightbox_image ? $this->lightbox_image : $this->image;
		$img = wp_get_attachment_image_src($image, 'original');
		return $img[2];
	}

	function get_image_columns(){
		$columns = array(
			'r1c1-io' => 1,
			'r2c2-io' => 2,
			'r1c2-il' => 1,
			'r1c2-ir' => 1,
			'r2c2-il' => 1,
			'r2c2-ir' => 1,
			'r2c2-it' => 2,
			'r2c2-ib' => 2,
			'r1c2-io' => 2,
			'r2c1-it' => 1,
			'r2c1-ib' => 1,
			'r2c1-io' => 1
		);
		return $columns[$this->layout];
	}

	function get_image_rows(){
		$rows = array(
			'r1c1-io' => 1,
			'r2c2-io' => 2,
			'r1c2-il' => 1,
			'r1c2-ir' => 1,
			'r2c2-il' => 2,
			'r2c2-ir' => 2,
			'r2c2-it' => 1,
			'r2c2-ib' => 1,
			'r1c2-io' => 1,
			'r2c1-it' => 1,
			'r2c1-ib' => 1,
			'r2c1-io' => 2
		);
		return $rows[$this->layout];
	}

	function echo_horizontal_padding(){
		echo ($this->get_image_columns() == 1 ? '8' : '4') . "%";
	}

	function echo_vertical_padding(){
		echo ($this->get_image_rows() == 1 ? '8' : '4') . "%";
	}
	function get_default_link_attr($grid){
		$attr = array('class' => '');
		$attr['href'] = $this->get_link_url();
		if ($this->link_mode == 'url' && $this->link_rel){
			$attr['rel'] = $this->link_rel;
		}
		if ($this->link_mode == 'url' && $this->link_target){
			$attr['target'] = $this->link_target;
		}
		if ($this->lightbox_image){
			$attr['data-lightbox-image-id'] = $this->lightbox_image;
		}
		if (uber_grid_get_active_lightbox() == 'custom'){
			if ($rel = get_option('uber_grid_link_rel')){
				$attr['rel'] = $rel;
			}
			if ($custom_attr = get_option('uber_grid_link_custom_attr_name')){
				$attr[$custom_attr] = get_option('uber_grid_link_custom_attr_value');
			}
			if ($class = get_option('uber_grid_link_class')){
				$attr['class'] .= $class . " ";
			}
		}
		if (uber_grid_get_active_lightbox() == 'prettyphoto')
			$attr['data-lightbox'] = "prettyPhoto[{$grid->id}]";
		return $attr;
	}
	function link_attributes($grid){
		$attr = $this->get_default_link_attr($grid);
		$attr['class'] .= ' uber-grid-cell-wrapper';
		if ($this->link_mode == 'lightbox'){
			$attr['class'] .= ' uber-grid-lightbox';
		}
		$this->render_attributes($attr);
	}

	function hover_attributes($grid){
		$attr = $this->get_default_link_attr($grid);
		$attr['class'] .= 'uber-grid-hover';
		if ($this->link_mode == 'lightbox'){
			$attr['class'] .= ' uber-grid-lightbox';
		}
		$this->render_attributes($attr);
	}

	function format_attribute($name, $value){
		return "$name=\"" . esc_attr($value) . "\" ";
	}

	function render_attributes($attr){
		foreach($attr as $key => $val){
			echo $this->format_attribute($key, $val);
		}
	}

	function get_link_url(){
		if ($this->link_mode == 'url'){
			return $this->link_url;
		}
		if ($this->lightbox_image){
			return $this->get_lightbox_image_src();
		}
		if (isset($this->link_url) && trim($this->link_url))
			return trim($this->link_url);
		return "#";
	}

	function get_rows(){
		return str_replace('r', '', preg_replace('/c.*$/', '', $this->layout));
	}
	function get_columns(){
		return preg_replace('/[^\d]+$/', '', preg_replace('/^r\d+c/', '', $this->layout));
	}

	function imageOnly(){
		return preg_match('/-io$/', $this->layout);
	}

	function imageLocation(){
		return preg_replace('/.*\-/', '', $this->layout);
	}

}
