<?php
/**
 * @package community
 */
?>
<div class="wrapper-post">

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<header class="entry-header">


		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

			<div class="entry-meta">
				<?php community_posted_on(); ?>
				<?php 
				    if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) { 
				        echo '<span class="comments-link">';
				        comments_popup_link( __( 'Leave a comment', 'community' ), __( '1 Comment', 'community' ), __( '% Comments', 'community' ) );
				        echo '</span>';
				    }
				?>
			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'community' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
</div>
	<footer class="entry-footer">
		<?php
		    echo get_the_tag_list( '<ul><li><i class="fa fa-tag"></i>', '</li><li><i class="fa fa-tag"></i>', '</li></ul>' );
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
