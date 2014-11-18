<?php class UberGrid_Ajax {
	function __construct(){
		add_action('wp_ajax_uber_grid_ping', array($this, '_ping'));
		add_action('wp_ajax_nopriv_uber_grid_ping', array($this, '_ping'));
		add_action('wp_ajax_nopriv_uber_grid_get_page', array($this, '_get_page'));
		add_action('wp_ajax_uber_grid_get_page', array($this, '_get_page'));
	}
	
	function _ping(){
		echo 'working';
		exit;
	}
	
	function _get_page(){
		$grid = new UberGrid_Grid($_REQUEST['id']);
		ob_start();
		$grid->render_cells($_REQUEST['page']);
		echo trim(ob_get_clean());
		exit;
	}
}
new UberGrid_Ajax;