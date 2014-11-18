<?php
class UberGrid_Shortcodes{
	function __construct(){
		add_shortcode('uber_grid', array($this, 'uber_grid'));
		add_shortcode('ubergrid', array($this, 'uber_grid'));
		add_action('wp_enqueue_scripts', array($this, '_wp_enqueue_scripts'), 0);
		if (get_option('uber_grid_shortcode_hack')){
			add_filter('the_content', array($this, '_shortcode_hack'), 1000);
		}
		if (!is_admin())
		add_action('wp_head', array($this, '_wp_head'));
		add_action('init', array($this, '_register_visual_composer'));

	}

	function _register_visual_composer(){
		if (!function_exists('vc_map'))
			return;
		$galleries = get_posts(array('post_type' => UBERGRID_POST_TYPE, 'posts_per_page' => -1));
		$params = array();
		foreach($galleries as $gallery){
			$params[$gallery->post_title] = $gallery->ID;
		}
		vc_map( array(
				"name" => __("UberGrid", 'uber-grid'),
				"base" => "ubergrid",
				"class" => "",
				"category" => __('Content', 'uber-grid'),
			//'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
			//'admin_enqueue_css' => array(get_template_directory_uri().'/vc_extend/bartag.css'),
				"params" => array(
						array(
								"type" => "dropdown",
								"holder" => "div",
								"class" => "",
								"heading" => __("UberGrid"),
								"param_name" => "id",
								"value" => $params,
								"description" => __("Please enter grid ID here.", 'uber-grid')
						)
				)
		) );
	}

	function _wp_head(){
		if (get_option('uber_grid_force_new_jquery')){
			?>
			<script type="text/javascript">
				if (typeof(jQuery) != 'undefined')
					uberGridjQueryBackup = jQuery;
				if (typeof($) != 'undefined')
					uberGrid$Backup = $;
			</script>
			<script type="text/javascript" src="<?php echo UBERGRID_URL . "assets/js/jquery-1.8.3.js" ?>"></script>
			<script type="text/javascript">
				window.uberGridjQuery = jQuery.noConflict(true);
			</script>
			<script type="text/javascript" src="<?php echo UBERGRID_URL . "assets/js/packery.pkgd.min.js?ver=" . UBERGRID_VERSION ?>"></script>
			<?php switch(uber_grid_get_active_lightbox()){
				case 'magnific-popup':
					?><script type="text/javascript" src="<?php echo UBERGRID_URL . "assets/js/jquery.magnific-popup.js?ver=" . UBERGRID_VERSION ?>"></script><?php
					break;
				case 'prettyphoto':
					?><script type="text/javascript" src="<?php echo UBERGRID_URL . "vendor/prettyphoto/jquery.prettyPhoto.js?ver=" . UBERGRID_VERSION ?>"></script><?php
					break;
				case 'swipebox':
					?><script type="text/javascript" src="<?php echo UBERGRID_URL . "vendor/swipebox/jquery.swipebox.js?ver=" . UBERGRID_VERSION ?>"></script><?php
					break;
				default:
			}?>

			<script type="text/javascript" src="<?php echo UBERGRID_URL . "assets/js/uber-grid.js?ver=" . UBERGRID_VERSION ?>"></script>
			<script type="text/javascript">
				if (typeof(uberGridjQueryBackup) != 'undefined')
					jQuery = uberGridjQueryBackup;
				if (typeof(uberGrid$Backup) != 'undefined')
					$ = uberGrid$Backup;
			</script>
			<?php
		}
	}

	function uber_grid($attributes = array(), $content = array()){
		if (!$id = intval($attributes['id']))
			return;
		if (get_option('uber_grid_shortcode_hack')){
			return "<!--ubergrid-$id-->";
		}
		return ubergrid($attributes['id'], $attributes);
	}

	function _shortcode_hack($content){
		return preg_replace_callback('/<\!\-\-ubergrid-(\d+)\-\->/', array($this, '_replace_callback'), $content);
	}
	function _replace_callback($matches){
		return ubergrid($matches[1]);
	}

	function enqueue_lightbox_styles(){
		switch (uber_grid_get_active_lightbox()){
			case 'swipebox':
				wp_enqueue_style('jquery.swipebox', UBERGRID_URL . "vendor/swipebox/swipebox.css", array(), UBERGRID_VERSION);
				break;
			case 'prettyphoto':
				wp_enqueue_style('jquery.prettyphoto', UBERGRID_URL . "vendor/prettyphoto/css/prettyPhoto.css", array(), UBERGRID_VERSION);
				break;
			case 'magnific-popup':
			default:
				wp_enqueue_style('jquery.magnific-popup-ubergrid', UBERGRID_URL . "assets/css/magnific-popup.css", array(), UBERGRID_VERSION);
		}
		wp_enqueue_style('jquery.magnific-popup-ubergrid', UBERGRID_URL . "assets/css/magnific-popup.css", array(), UBERGRID_VERSION);
	}

	function enqueue_lightbox_scripts(){
		switch(uber_grid_get_active_lightbox()){
			case 'swipebox':
				wp_enqueue_script('jquery.swipebox', UBERGRID_URL . "vendor/swipebox/jquery.swipebox.js", array('jquery'), UBERGRID_VERSION);
				break;
			case 'prettyphoto':
				wp_enqueue_script('jquery.prettyphoto', UBERGRID_URL . "vendor/prettyphoto/jquery.prettyPhoto.js", array('jquery'), UBERGRID_VERSION);
				break;
			case 'jetpack':
				//wp_enqueue_script('');
				if (class_exists('Jetpack_Carousel')){
					$carousel = new Jetpack_Carousel();
					$carousel->enqueue_assets(false);
				}
			case 'magnific-popup':
			default:
			wp_enqueue_script('jquery.magnific-popup', UBERGRID_URL . "assets/js/jquery.magnific-popup.js", array('jquery'), UBERGRID_VERSION);
		}
	}

	function _wp_enqueue_scripts(){
		if (is_admin())
			return;
		$this->enqueue_lightbox_styles();

		wp_enqueue_style('uber-grid', UBERGRID_URL . "assets/css/uber-grid.css", array('jquery.magnific-popup-ubergrid'), UBERGRID_VERSION);
		if (get_option('uber_grid_use_external_stylesheet'))
			wp_enqueue_style('uber-grid-dynamic', UBERGRID_URL . "frontend-style.css.php", array('uber-grid'), UberGrid_Grid::css_timestamp());
		if (!get_option('uber_grid_force_new_jquery')){
			wp_enqueue_script('packery', UBERGRID_URL . "assets/js/packery.pkgd.min.js", array('jquery'), UBERGRID_VERSION);
			$this->enqueue_lightbox_scripts();
			wp_enqueue_script('uber-grid', UBERGRID_URL . "assets/js/uber-grid.js", array('jquery', 'packery'), UBERGRID_VERSION);
		}
	}

}

$ubergrid_shortcodes = new UberGrid_Shortcodes;

function ubergrid_no_cache($id, $options = array()){
	$grid = new UberGrid_Grid();
	$grid->load($id, $options);
	ob_start();
	$css = !get_option('uber_grid_use_external_stylesheet');
	$grid->render(array('css' => $css, 'style_tag' => $css, 'generate_thumbnails' => true));
	return ob_get_clean();
}

function ubergrid($id, $options = array()){
	$options = wp_parse_args($options, array('echo' => false));
	global $ubergrid_shortcodes;
	if (get_option('uber_grid_enable_caching')){
		if (false === ($text = get_transient("uber_grid_$id")) || is_user_logged_in()){
			$text = ubergrid_no_cache($id, $options);
			if (get_option('uber_grid_enable_caching') && !is_user_logged_in())
				set_transient("uber_grid_$id", $text, 600);
		}
	} else {
		$text = ubergrid_no_cache($id, $options);
	}
	// Strip whitespace between tags to prevent adding <p></p>.
	//$result = preg_replace('/>\s+</', '><', $text);
	if ($options['echo']){
		echo $text;
		return;
	}
	return $text;
}

function uber_grid($id, $options = array()){return ubergrid($id, $options);}
