<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cream_Blog
 */

?>
<section id="post-<?php the_ID(); ?>" <?php post_class( 'cb-page-entry cb-default-page-entry' ); ?>>
    <div class="page-title">
        <h2><?php the_title(); ?></h2>
    </div><!-- .page-title -->
    <?php cream_blog_post_thumbnail(); ?>
    <div class="page-contents">
        <div class="cb-editor-contents-entry">
            <?php
	    	the_content();

	    	wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cream-blog' ),
				'after'  => '</div>',
			) );

			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'cream-blog' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
	    	?>
        </div><!-- .cb-editor-contents-entry -->
    </div><!-- .page-contents -->
</section><!-- #post-<?php the_ID(); ?> -->

