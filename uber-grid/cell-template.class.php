<?php
require_once(ABSPATH . "wp-admin/includes/image.php");
class UberGrid_CellTemplate extends UberGrid_Cell{
	var $current_post;
	var $index = 0;
	public $tags_source;
	public $layouts;

	function __construct($data = null){
		$this->title = "%post_title%";
		$this->link_enable = 1;
		$this->link_mode = 'link';
		$this->link_url = "%post_permalink%";
		$this->layouts = array('r1c1-io');
		parent::__construct();
		if ($data)
			$this->assign($data);
	}

	function get_cell_fields($class = null){
		return parent::get_cell_fields(__CLASS__);
	}

	function build_cell($post, $options = array()){
		$data = array();
		foreach(UberGrid_Cell::get_cell_fields() as $field){
			if (!preg_match('/_enable$/', $field))
				$data[$field] = $this->do_tags($this->$field, $post);
			else
				$data[$field] = $this->$field;
			$data[$field] = apply_filters('ubergrid_cell_field_value', $data[$field], $field, $post);
		}
		$data['layout'] = $this->choose_layout($post);
		$data = $this->find_featured_image($post, $data, $options);
		if ($tags = $this->find_tags($post, $options));
			$data['tags'] = $tags;

		return new UberGrid_Cell(apply_filters('uber_grid_auto_cell_data', $data, $post));
	}

	function choose_layout($post){
		$layout = $this->layouts[$this->i++ % count($this->layouts)];
		return $layout;
	}

	function find_tags($post, $options){
		if ($this->tags_source){
			$tags = array();
			foreach(wp_get_post_terms($post->ID, $this->tags_source) as $term){
				$tags []= $term->name;
			}
			return implode(', ', $tags);
		}
		return '';
	}


	function find_featured_image($post, $data, $options){
		$thumbnail = $post->post_type == 'attachment' ? $post->ID : get_post_thumbnail_id($post->ID);
		if ((int)$thumbnail && !$data['image']){
			$src = wp_get_attachment_image_src($thumbnail);
			if ($src[0])
				$data['image'] = $thumbnail;
		}
		if (!$thumbnail){
			$attachments = get_children(array('post_parent' => $post->ID, 'post_type' => 'attachment', 'numberposts' => 1, 'post_mime_type' => 'image'));
			if (count($attachments)){
				$keys = array_keys($attachments);
				$thumbnail = $keys[0];
			}
		}
		if (!$data['lightbox_image'] && $thumbnail && (!$data['link_url'] || $data['link_mode'] == 'lightbox')){
			$data['lightbox_image'] = $thumbnail;
		}
		return $data;
	}


	function do_tags($value, $post){
		$this->current_post = $post;
		$value = preg_replace_callback("/" . preg_quote('%post_title%') . "/", array($this, '_post_title_filter'), $value);
		$value = preg_replace_callback("/" . preg_quote('%post_excerpt%') . "/", array($this, '_post_excerpt_filter'), $value);
		$value = preg_replace_callback("/" . preg_quote('%post_content%') . "/", array($this, '_post_content_filter'), $value);
		$value = str_replace('%post_ID%', $post->ID, $value);
		$value = preg_replace_callback("/" . preg_quote('%post_permalink%') . "/", array($this, '_post_permalink_filter'), $value);
		$value = str_replace("%post_date%", mysql2date(get_option('date_format'), $post->post_date), $value);
		$value = preg_replace_callback("/" . preg_quote('%post_tags%') . "/", array($this, '_post_tags_filter'), $value);
		$value = preg_replace_callback("/%post_meta_([^%]+)%/", array($this, 'do_replace'), $value);
		$value = preg_replace('%post_author%', get_the_author(), $value);
		return $value;
	}

	function _post_tags_filter($match){
		global $post;
		return $this->find_tags($post, array());
	}

	function _post_permalink_filter($match){
		return get_permalink();
	}

	function _post_content_filter($match){
		global $post;
		return get_the_content();
	}

	function _post_title_filter($match){
		return get_the_title();
	}

	function _post_excerpt_filter($match){
		return get_the_excerpt();
	}

	function do_replace($matches){
		return get_post_meta($this->current_post->ID, $matches[1], true);
	}

	function reset(){
		$this->i = 0;
	}

}
