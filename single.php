<?php
/**
 * The template for displaying all single posts.
 *
 * @package community
 */

get_header(); ?>
	
	<div id="primary" class="content-area">
		<div class="single-post-page">
			<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php community_post_nav(); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>