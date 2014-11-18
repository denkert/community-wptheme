<?php

class UberGrid_Grid{
	var $id;
	var $slug;
	var $data;

	var $mode;

	var $cells;
	var $template;

	var $max_width = null;
	var $cell_width = 160;
	var $cell_height = 160;
	var $cell_gap = 0;
	var $cell_autosize = 0;
	var $cell_border_width = 0;
	var $cell_border_color = "FFFFFF";
	var $cell_border_opacity = 1.0;
	var $cell_border_radius = 0;
	var $cell_shadow_radius = 0;


	var $responsive_440_cell_width = 120;
	var $responsive_440_cell_height = 120;
	var $responsive_440_cell_gap = 0;
	var $responsive_440_cell_border_width = 0;
	var $responsive_440_cell_border_radius = 0;
	var $responsive_440_title_font_size = 14;
	var $responsive_440_tagline_font_size = 11;
	var $responsive_440_hover_title_font_size = 14;
	var $responsive_440_hover_text_font_size = 11;
	var $responsive_440_label_title_font_size = 14;
	var $responsive_440_label_tagline_font_size = 11;
	var $responsive_440_label_price_font_size = 14;
	var $responsive_440_label_max_height;

	var $responsive_768_cell_width = 160;
	var $responsive_768_cell_height = 160;
	var $responsive_768_cell_gap = 0;
	var $responsive_768_cell_border_width = 0;
	var $responsive_768_cell_border_radius = 0;
	var $responsive_768_title_font_size = 18;
	var $responsive_768_tagline_font_size = 14;
	var $responsive_768_hover_title_font_size = 18;
	var $responsive_768_hover_text_font_size = 14;
	var $responsive_768_label_title_font_size = 18;
	var $responsive_768_label_tagline_font_size = 14;
	var $responsive_768_label_price_font_size = 18;
	var $responsive_768_label_max_height;



	var $title_font = "Marvel";
	var $title_font_style = "700";
	var $title_font_size = "24";

	var $tagline_font = "Marvel";
	var $tagline_font_style = "regular";
	var $tagline_font_size = "12";

	var $hover_text_font = "Marvel";
	var $hover_text_font_style = "regular";
	var $hover_text_font_size = "12";

	var $hover_title_font = "Marvel";
	var $hover_title_font_style = "700";
	var $hover_title_font_size = "18";

	var $lightbox_text_font = "Marvel";
	var $lightbox_text_font_style = "regular";
	var $lightbox_text_font_size = "13";

	var $lightbox_title_font = "Marvel";
	var $lightbox_title_font_style = "700";
	var $lightbox_title_font_size = "18";

	var $label_max_height;
	var $label_title_font = "Marvel";
	var $label_title_font_style = "regular";
	var $label_title_font_size = "16";

	var $label_tagline_font = "Marvel";
	var $label_tagline_font_style = "300";
	var $label_tagline_font_size = "12";

	var $label_price_font = "Marvel";
	var $label_price_font_style = "700";
	var $label_price_font_size = "24";

	var $filters_font = 'Marvel';
	var $filters_font_style = "700";
	var $filters_font_size = '18';
	var $filters_color = '#FFFFFF';
	var $filters_align = 'center';
	var $filters_background_color = '#ff6760';
	var $filters_accent_color = '#FFFFFF';
	var $filters_accent_background_color = "#616161";
	var $filters_all = 'All';
	var $filters_sort = false;

	var $bw;
	var $hover_effect;

	var $auto_enable = false;
	var $auto_post_type = 'post';
	var $auto_orderby = 'date';
	var $auto_order = 'DESC';
	var $auto_limit = '24';
	var $auto_offset = 0;
	var $auto_ids = array();

	var $auto_taxonomies = array();
	var $auto_tags = array();
	var $auto_operators = array();

	var $auto_meta_keys = array();
	var $auto_meta_operators = array();
	var $auto_meta_values = array();
	var $auto_meta_types = array();


	var $pagination_enable;
	var $pagination_per_page = 12;

	var $pagination_font = 'Marvel';
	var $pagination_font_style = "700";
	var $pagination_font_size = '18';
	var $pagination_color = '#FFFFFF';
	var $pagination_align = 'center';
	var $pagination_background_color = '#ff6760';
	var $pagination_current_page_color = '#FFFFFF';
	var $pagination_current_page_background_color = "#616161";
	var $pagination_pages = 'Pages:';


	function __construct($id = null, $options = array()){
		if (is_array($id) || $id){
			$this->load($id, $options);
		}
		if (!$this->template)
			$this->template = new UberGrid_CellTemplate;
	}

	function get_meta($name){
		if (!$this->data && $this->data !== false){
			$this->data = get_post_meta($this->id, '_ubergrid', true);
			if ($this->data){
				$this->data = json_decode($this->data, true);
			} else
				$this->data = false;
		}
		if ($this->data && isset($this->data[$name])){
			return $this->data[$name];
		}
		return get_post_meta($this->id, "_" . $name, true);
	}

	function load($cells, $options = null){
		if (!is_array($cells)){
			$posts = get_posts("post_type=uber-grid&p=$cells");
			if (!count($posts))
				return;
			$post = $posts[0];
			if ($post->post_status != 'publish')
				return;
			$this->id = $cells;
			$this->slug = $post->post_name;
			$this->mode = ($mode = $this->get_meta('current-mode')) ? $mode : 'manual';
			$cells = $this->get_meta('cells');
			foreach(array('template', 'layout', 'fonts', 'effects', 'auto', 'pagination',
					        'responsive_440', 'responsive_768') as $meta){
				$options[$meta] = $this->get_meta($meta);
			}
		}
		$this->cells = array();
		if (is_array($cells)){
			foreach($cells as $cell){
				$this->cells []= new UberGrid_Cell($cell);
			}
		}
		if ($options){
			if (isset($options['posts']) && $options['posts']){
				$this->data['posts'] = $options['posts'];
			}
			if (isset($options['layout']) && $options['layout']){
				$this->assign_layout_options($options['layout']);
			}
			if (isset($options['fonts']) && $options['fonts']){
				$this->assign_font_options($options['fonts']);
			}
			if (isset($options['effects']) && $options['effects']){
				$this->assign_effects_options($options['effects']);
			}
			if (isset($options['auto']) && $options['auto']){
				$this->assign_auto_options($options['auto']);
			}
			if (isset($options['ids']) && $options['ids']){
				$this->auto_ids = $options['ids'];
			}
			if (isset($options['template'])){
				$this->template = new Ubergrid_CellTemplate($options['template']);
			}
			if (isset($options['pagination'])){
				$this->assign_pagination_options($options['pagination']);
			}
			if (isset($options['responsive_440'])){
				$this->assign_responsive_440_options($options['responsive_440']);
			}
			if (isset($options['responsive_768'])){
				$this->assign_responsive_768_options($options['responsive_768']);
			}
		}
	}

	function assign_pagination_options($options){
		foreach(array('enable', 'per_page', 'color', 'background_color', 'current_page_color', 'current_page_background_color', 'align', 'pages') as $property){
			if (isset($options[$property])){
				$name = 'pagination_' . $property;
				$this->$name = $options[$property];
			}
		}
	}

	function assign_font_options($font){
		foreach(array('title_font', 'title_font_style', 'title_font_size', 'tagline_font', 'tagline_font_style', 'tagline_font_size', 'hover_text_font', 'hover_text_font_style', 'hover_text_font_size', 'hover_title_font', 'hover_title_font_style', 'hover_title_font_size', 'lightbox_text_font', 'lightbox_text_font_style', 'lightbox_text_font_size', 'lightbox_title_font', 'lightbox_title_font_style', 'lightbox_title_font_size', 'label_title_font', 'label_title_font_style', 'label_title_font_size', 'label_tagline_font', 'label_tagline_font_style', 'label_tagline_font_size', 'label_price_font', 'label_price_font_style', 'label_price_font_size', 'filters_font', 'filters_font_size', 'filters_font_style', 'filters_color', 'filters_align', 'filters_accent_color', 'filters_accent_background_color', 'filters_all', 'filters_sort', 'filters_background_color', 'pagination_font', 'pagination_font_style', 'pagination_font_size') as $property){
			if (isset($font[$property]))
				$this->$property = $font[$property];
		}
	}

	function assign_responsive_440_options($responsive){
		foreach(array('cell_width', 'cell_height', 'cell_gap', 'cell_border_width', 'title_font_size', 'tagline_font_size', 'hover_title_font_size', 'hover_text_font_size', 'label_title_font_size', 'label_tagline_font_size', 'label_price_font_size', 'cell_border_radius', 'label_max_height') as $property){
	 			if (isset($responsive[$property])){
					$longproperty = "responsive_440_$property";
	 				$this->$longproperty = $responsive[$property];
	 			}

	 		}
	}
	function assign_responsive_768_options($responsive){
		foreach(array('cell_width', 'cell_height', 'cell_gap', 'cell_border_width', 'title_font_size', 'tagline_font_size', 'hover_title_font_size', 'hover_text_font_size', 'label_title_font_size', 'label_tagline_font_size', 'label_price_font_size', 'cell_border_radius', 'label_max_height') as $property){
	 			if (isset($responsive[$property])){
					$longproperty = "responsive_768_$property";
	 				$this->$longproperty = $responsive[$property];
	 			}

	 		}
	}

	function assign_auto_options($options){
		foreach (array('post_type', 'taxonomies', 'tags', 'operators', 'meta_keys', 'meta_values', 'meta_types', 'meta_operators', 'order', 'orderby', 'limit', 'offset', 'enable') as $property){
			$property_name = "auto_$property";
			if (isset($options[$property]))
				$this->$property_name = $options[$property];
		}
	}

	function assign_layout_options($layout){
		foreach(array('max_width', 'cell_width', 'cell_height', 'cell_gap', 'cell_autosize', 'cell_border_width',
			        'cell_border_color', 'cell_border_opacity', 'cell_shadow_radius',
			        'cell_border_radius', 'label_max_height') as $property){
			if (isset($layout[$property]) && $layout[$property])
				$this->$property = $layout[$property];
		}
	}

	function assign_effects_options($effects){
		foreach(array('bw', 'hover_effect') as $property){
			if (isset($effects[$property]) && $effects[$property])
				$this->$property = $effects[$property];
		}
	}

	function get_classes(){
		$classes = array('uber-grid-wrapper');
		if (uber_grid_is_photon_enabled()){
			$classes []= 'uber-grid-photon';
		}
		return implode(" ", $classes);
	}

	function get_images(){
		$images = array();
		if ($this->cells)
		foreach($this->cells as $cell){
			$images []= $cell->image;
			$images []= $cell->background_image;
			$images []= $cell->title_background_image;
			$images []= $cell->lightbox_image;
		}
		return array_unique(array_filter($images));
	}

	function get_2x_width(){
		return $this->cell_width * 2 + $this->cell_border_width * 2 + $this->cell_gap;
	}

	function get_2x_height(){
		return $this->cell_height * 2 + $this->cell_border_width * 2 + $this->cell_gap;
	}


	function prepare_rendering($options){
		if ($this->auto_enable)
			$this->cells = array_merge($this->cells, $this->build_auto_cells($options));
	}
	function render($options = array()){
		$this->prepare_rendering($options);
		$options = wp_parse_args($options, array('show_edit' => true, 'css' => true, 'html' => true));
		if (isset($options['css']) && $options['css'])
			$this->render_css(isset($options['style_tag']) && $options['style_tag']);
		if (isset($options['html']) && $options['html'])
			$this->render_html($options);
	}

	function render_css($style_tag = false){
		if ($style_tag)
			echo "<style type='text/css'>";
		require('templates/grid-style.css.php');
		if ($style_tag)
			echo "</style>";
	}
	function build_auto_cells($options = array()){
		if (empty($this->data['posts'])){
			$query = array(
					'post_type' => $this->auto_post_type,
					'posts_per_page' => $this->auto_limit ? (int)$this->auto_limit : '-1',
					'offset' => (int)$this->auto_offset,
					'orderby' => $this->auto_orderby,
					'order' => $this->auto_order,
					'tax_query' => $this->build_auto_tax_query(),
					'meta_query' => $this->build_meta_query()
			);
			if ('attachment' == $query['post_type']){
				$query['post_status'] = 'inherit';
			}
		} else
			$query = array(
				'post__in' => explode(',', $this->data['posts']),
				'post_type' => 'any',
				'post_status' => 'any'
			);
		$auto_cells = array();
		$this->template->reset(); // Reset the template to choose a right layout next time
		$query = new WP_Query(apply_filters('uber_grid_auto_cells_query', $query, $this->id));
		global $post;
		while($query->have_posts()){
			$query->the_post();
			$auto_cells []= $this->template->build_cell($post, array('width' => $this->cell_width, 'height' => $this->cell_height));
		}
		wp_reset_query();
		return $auto_cells;
	}


	function build_meta_query(){
		$meta_query = array();
		for ($i = 0; $i < count($this->auto_meta_keys); $i++ ){
			$meta_query []= array(
				'key' => $this->auto_meta_keys[$i],
				'compare' => $this->auto_meta_operators[$i],
				'value' => $this->auto_meta_values[$i],
				'type' => $this->auto_meta_types[$i]
			);
		}
		return $meta_query;
	}
	function build_auto_tax_query(){
		$tax_query = array();
		for ($i = 0; $i < count($this->auto_taxonomies); $i++){
			$tax_query []= array(
				'taxonomy' => $this->auto_taxonomies[$i],
				'field' => 'slug',
				'terms' => array_map('trim', explode(',', $this->auto_tags[$i])),
				'operator' => $this->auto_operators[$i]
			);
		}
		return $tax_query;
	}

	function has_2x_cells(){
		if ($this->cells)
			foreach($this->cells as $cell){
				if ($cell->get_columns() == 2)
					return true;
			}
		return false;
	}

	function render_html($options){
		if (count($this->cells))
			require("templates/grid.php");
		else
			require("templates/grid-blank-slate.php");
	}

	function render_cells($page = 1){
		if ($page > 1)
			$this->prepare_rendering(array());
		if ($this->pagination_enable){
			$from = ($page - 1) * $this->pagination_per_page;
			$to = min($page * $this->pagination_per_page, count($this->cells));
		} else {
			$from = 0;
			$to = count($this->cells);
		}
		for ($index = $from; $index < $to; $index++): ?>
			<?php $cell = $this->cells[$index]?>
			<div <?php $cell->render_cell_attributes($this, $page, $index) ?>><?php require("templates/cell.php") ?></div>
		<?php endfor;
	}

	function render_pagination(){
		if (count($this->cells) <= $this->pagination_per_page)
			return;
		echo '<div class="uber-grid-pagination">';
		echo '<div>' . esc_html($this->pagination_pages) . "</div>";
		for($i = 1; $i <= ceil(count($this->cells) / $this->pagination_per_page); $i++){
			?><div class="uber-grid-pagination-page"><a href="#ubergrid-page-<?php echo $i ?>" class="ubergrid-pagination-link"><?php echo $i ?></a></div><?php
		}
		echo "</div>";
	}

	static function css_timestamp(){
		$posts = get_posts('post_type=uber-grid&order=desc&posts_per_page=1');
		if ($posts){
			return $posts[0]->post_modified;
		}
		else return '';
	}

	function font_families(){
		return array_unique(array_filter(array($this->title_font, $this->tagline_font, $this->hover_text_font, $this->hover_title_font,
			$this->lightbox_text_font, $this->lightbox_title_font, $this->label_title_font, $this->label_tagline_font, $this->label_price_font)));
	}

	function parse_font_weight($style){
		if (in_array($style, array('', 'regular', 'italic')))
			return '400';
		if ($style == 'bold')
			return '700';
		if (preg_match('/^(\d{3,4})/', $style, $matches))
			return $matches[0];
		return '400';
	}

	function parse_font_style($style){
		if (in_array($style, array('', 'italic')))
			return $style;
		if (preg_match('/^(\d{3,4}.+)/', $style, $matches))
			return preg_replace('/^(\d{3,4})/', '', $style);
		return 'normal';
	}

	function grid_classes(){
		$classes = array('uber-grid');
		if ($this->bw)
			$classes []= 'uber-grid-bw';
		if ($this->hover_effect)
			$classes []= 'uber-grid-effect-' . $this->hover_effect;
		return $classes;
	}

	function get_tags(){
		$tags = array();
		foreach($this->cells as $cell){
			if (!$cell->tags)
				continue;
			foreach(array_map('trim', explode(', ', $cell->tags)) as $tag)
				$tags []= $tag;
		}
		$tags = array_unique($tags);
		if ($this->filters_sort)
			sort($tags);
		return $tags;
	}

	function get_columns_width($columns){
		return $columns * ($this->cell_width + $this->cell_border_width * 2 + $this->cell_gap);
	}

	function label_height(){
		return  (int)$this->label_title_font_size * 1.2 + (int)$this->label_tagline_font_size * 1.2 + 24;
	}

	function responsive_440_get_columns_width($columns){
		return $columns * ($this->responsive_440_cell_width + $this->responsive_440_cell_border_width * 2 + $this->responsive_440_cell_gap);
	}

	function responsive_768_get_columns_width($columns){
		return $columns * ($this->responsive_768_cell_width + $this->responsive_768_cell_border_width * 2 + $this->responsive_768_cell_gap);
	}

	function responsive_768_label_height(){
		return  (int)$this->responsive_768_label_title_font_size * 1.2 + (int)$this->responsive_768_label_tagline_font_size * 1.2 + 24;
	}
	function responsive_440_label_height(){
		return  (int)$this->responsive_440_label_title_font_size * 1.2 + (int)$this->responsive_440_label_tagline_font_size * 1.2 + 24;
	}

	function get_lightbox_options(){
		switch (uber_grid_get_active_lightbox()){
			case 'prettyphoto':
				return array(
						'theme' => get_option('uber_grid_prettyphoto_theme', 'pp_default'),
						'slideshow' => true,
						'hook' => 'data-lightbox',
						'deeplinking' => true
				);
			default:
				return array();
		};
		return $options;
	}

	function js_options(){
		return array(
			'ajaxurl' => uber_grid_ajax_url(),
			'autosize' => $this->cell_autosize,
			'max_width' => $this->max_width,
			'lightbox' => uber_grid_get_active_lightbox(),
			'lightbox_options' => $this->get_lightbox_options(),
			'size' => array('width' => $this->cell_width, 'height' => $this->cell_height),
			'size440' => array('width' => $this->responsive_440_cell_width, 'height' => $this->responsive_440_cell_height),
			'size768' => array('width' => $this->responsive_768_cell_width, 'height' => $this->responsive_768_cell_height),
			'gutter' => $this->cell_gap,
			'gutter_768' => $this->responsive_768_cell_gap,
			'gutter_440' => $this->responsive_440_cell_gap,
			'cell_border' => $this->cell_border_width,
			'cell_border_440' => $this->responsive_440_cell_border_width,
			'cell_border_768' => $this->responsive_768_cell_border_width
		);
	}
}
