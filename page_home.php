<?php
 /*
 Template Name: Home-page
 */
 ?>

<?php get_header(); ?>
	<div class="page-homepage">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->
		<?php get_sidebar(); ?>
		<div class="clear"></div>
	</div> <!-- .page-homepage -->


<?php get_footer(); ?>
