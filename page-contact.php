<?php
 /*
 Template Name: Contact-page
 Made By: Ellinor Denkert 
 */

 ?>

<?php get_header(); ?>
	<div class="page-contact">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->
		<div class="clear"></div>
	</div> <!-- .page-contact -->

<?php get_footer(); ?>
