<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cream_Blog
 */

?>
<section class="cb-page-entry nothing-found-page-entry">
    <div class="page-title">
        <h2><?php esc_html_e( 'Nothing Found', 'cream-blog' ); ?></h2>
    </div><!-- .page-title -->
    <div class="page-contents">
        <div class="nothing-found-message">
            <p><?php esc_html_e( 'Nothing was found at this location. Try adjusting your keyword & search again.', 'cream-blog' ); ?></p>
        </div><!-- .nothing-found-message -->
        <div class="nthing-page-action">
            <div class="search-box">
                <?php get_search_form(); ?>
            </div><!-- .search-box -->
        </div><!-- .nthing-page-action -->
    </div><!-- .page-contents -->
</section><!-- .cb-page-entry.nothing-found-page-entry -->
