<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Cream_Blog
 */

get_header();
?>
	<div class="cb-container">
        <div class="cb-mid-wrap cb-innerpage-mid-wrap cb-404-page">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <section class="cb-page-entry error-page-entry">
                        <div class="error-page-head">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/dist/img/404.png' ) ?>" alt="<?php esc_attr_e( '404 error page', 'cream-blog' ); ?>">
                        </div><!-- .error-page-head -->
                        <div class="error-page-body">
                            <h2 class="error-message"><?php esc_html_e( 'Page Not Found!', 'cream-blog' ); ?></h2><!-- .error-message -->
                            <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'cream-blog' ); ?></p>
                        </div><!-- .error-page-body -->
                        <div class="error-page-bottom">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-general"><?php echo esc_html__( 'Go Homepage', 'cream-blog' ); ?></a>
                        </div><!-- .error-page-bottom -->
                    </section><!-- .cb-page-entry.error-page-entry -->
                </main><!-- #main.site-main -->
            </div><!-- #primary.site-main -->
        </div><!-- .cb-mid-wrap.cb-innerpage-mid-wrap.cb-404-page -->
    </div><!-- .cb-container -->

<?php
get_footer();
