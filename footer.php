<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package community
 */
?>

	</div><!-- #content -->



	<footer id="colophon" class="site-footer" role="contentinfo">
		
		<?php get_sidebar('footer'); ?>

		<div class="clear"></div>
		
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'http://thecommunitynyc.com', 'community' ) ); ?>"><?php printf( __( 'Copyright: %s', 'community' ), 'The Community 2014' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s', 'community' ), 'Community', '<a href="http://ellinordenkert.com" rel="designer">Ellinor Denkert</a>' ); ?>
			<span class="sep"> | </span>
			Photo Credit: Kirsten Chilstrom
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
