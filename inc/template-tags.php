<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package community
 */

if ( ! function_exists( 'community_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function community_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'community' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'community' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'community' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'community_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function community_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'community' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'community' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'community' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'community_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function community_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s"></time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="byline">Written by: %1$s</span><span class="posted-on">Posted on: %2$s</span>', 'community' ),
			    sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			        esc_html( get_the_author() )
			    ),
			        sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			        esc_url( get_permalink() ),
			        $time_string
			    )
			);
	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

if ( ! function_exists( 'community_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function community_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'community' ) );
		if ( $categories_list && community_categorized_blog() ) {
			printf( '<span class="cat-links">' . __( 'Posted in %1$s', 'community' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'community' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . __( 'Tagged %1$s', 'community' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'community' ), __( '1 Comment', 'community' ), __( '% Comments', 'community' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'community' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function community_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'community_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'community_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so community_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so community_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in community_categorized_blog.
 */
function community_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'community_categories' );
}
add_action( 'edit_category', 'community_category_transient_flusher' );
add_action( 'save_post',     'community_category_transient_flusher' );

/*
 * Social media icon menu as per http://justintadlock.com/archives/2013/08/14/social-nav-menus-part-2
 */

function community_social_menu() {
    if ( has_nav_menu( 'social' ) ) {
	wp_nav_menu(
		array(
			'theme_location'  => 'social',
			'container'       => 'div',
			'container_id'    => 'menu-social',
			'container_class' => 'menu-social',
			'menu_id'         => 'menu-social-items',
			'menu_class'      => 'menu-items',
			'depth'           => 1,
			'link_before'     => '<span class="screen-reader-text definitely is being used">',
			'link_after'      => '</span>',
			'fallback_cb'     => '',
		)
	);
    }
}
                