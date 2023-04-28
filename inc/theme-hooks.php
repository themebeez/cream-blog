<?php
/**
 * Default WordPress filters and hooks modification.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Cream_Blog
 */

if ( ! function_exists( 'cream_blog_excerpt_length' ) ) {
	/**
	 * Modify post excerpt length.
	 *
	 * @param int $length Excerpt length.
	 */
	function cream_blog_excerpt_length( $length ) {

		if ( is_admin() ) {

			return $length;
		}

		$excerpt_length = cream_blog_get_option( 'cream_blog_post_excerpt_length' );

		if ( absint( $excerpt_length ) > 0 ) {
			$excerpt_length = absint( $excerpt_length );
		}

		return $excerpt_length;
	}

	add_filter( 'excerpt_length', 'cream_blog_excerpt_length' );
}
