<?php
require('../../../wp-load.php');
if (!class_exists('UberGrid_Grid'))
	require_once('uber-grid.php');
header('Content-type: text/css');
foreach(get_posts('post_type=uber-grid&posts_per_page=-1') as $grid_post){
	$grid = new UberGrid_Grid($grid_post->ID);
	$grid->render(array('css' => true, 'style_tag' => false, 'generate_thumbnails' => false, 'html' => false));
}
exit;

