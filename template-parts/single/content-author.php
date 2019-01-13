<?php
/**
 * Template part for displaying author detail
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cream_Blog
 */
$show_author_section = cream_blog_get_option( 'cream_blog_enable_author_section' );
if( $show_author_section == 'true' ) {
    ?>
    <div class="author-box">
        <div class="author-thumb">
            <?php echo get_avatar( get_the_author_meta( 'ID' ), 300 ); ?>
        </div><!-- .author-thumb -->
        <div class="author-details">
            <div class="author-name">
                <h3><?php echo esc_html( get_the_author() ); ?></h3>
            </div><!-- .author-name -->
            <div class="author-desc">
                <p><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
            </div><!-- .author-desc -->
        </div><!-- .author-details -->
    </div><!-- .author-box -->
    <?php
}
