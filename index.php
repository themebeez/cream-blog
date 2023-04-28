<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cream_Blog
 */

get_header();

/**
 * Hook - cream_blog_banner_slider.
 *
 * @hooked cream_blog_banner_slider_action - 10
 */
do_action( 'cream_blog_banner_slider' );

$cream_blog_has_sidebar_active = '';
$cream_blog_sidebar_position   = cream_blog_sidebar_position();
$cream_blog_main_class         = cream_blog_main_class();

if (
	'none' !== $cream_blog_sidebar_position &&
	is_active_sidebar( 'sidebar' )
) {
	$cream_blog_has_sidebar_active = 'has-sidebar';
}
?>
<div class="cb-container">
	<div class="cb-fp-top-wrap">
		<?php
		/**
		 * Hook - cream_blog_homepage_widget_area_top.
		 *
		 * @hooked cream_blog_homepage_widget_area_top_action - 10
		 */
		do_action( 'cream_blog_homepage_widget_area_top' );
		?>
	</div><!-- .cb-fp-top-wrap -->
	<div class="cb-mid-wrap cb-fp-mid-wrap <?php echo esc_attr( $cream_blog_has_sidebar_active ); ?>">
		<div class="row">
			<?php
			if (
				'left' === $cream_blog_sidebar_position &&
				is_active_sidebar( 'sidebar' )
			) {
				get_sidebar();
			}
			?>
			<div class="<?php echo esc_attr( $cream_blog_main_class ); ?>">
				<div id="primary" class="content-area">
					<main id="main" class="site-main">
						<?php
						$cream_blog_list_layout = cream_blog_get_option( 'cream_blog_select_blog_post_list_layout' );

						if ( have_posts() ) {
							if ( 'list_1' === $cream_blog_list_layout ) {
								?>
								<div class="cb-recent-posts cb-list-style-2">
								<?php
							} elseif ( 'list_2' === $cream_blog_list_layout ) {
								?>
								<div class="cb-recent-posts cb-post-bricks">
									<div class="section-contants">
										<div id="bricks-row">
								<?php
							} else {
								?>
								<div class="cb-recent-posts cb-big-posts">
									<div class="section-contants">
								<?php
							}

							while ( have_posts() ) {

								the_post();

								if ( 'list_1' === $cream_blog_list_layout ) {

									get_template_part( 'template-parts/layout/layout', 'list-two-columns' );
								} elseif ( 'list_2' === $cream_blog_list_layout ) {

									get_template_part( 'template-parts/layout/layout', 'masonry-with-excerpt' );
								} else {

									get_template_part( 'template-parts/layout/layout', 'list-one-column' );
								}
							}

							if ( 'list_1' === $cream_blog_list_layout ) {
								/**
								* Hook - cream_blog_pagination.
								*
								* @hooked cream_blog_pagination_action - 10
								*/
								do_action( 'cream_blog_pagination' );
							}

							if ( 'list_1' === $cream_blog_list_layout ) {
								?>
								</div><!-- .cb-recent-posts.cb-list-style-2 -->
								<?php
							} elseif ( 'list_2' === $cream_blog_list_layout ) {
								?>
										</div><!-- .bricks-row -->
									</div><!-- .section-contants -->
									<?php
									/**
									 * Hook - cream_blog_pagination.
									 *
									 * @hooked cream_blog_pagination_action - 10
									 */
									do_action( 'cream_blog_pagination' );
									?>
								</div><!-- .cb-recent-posts.cb-post-bricks -->
								<?php
							} else {
								?>
									</div><!-- .section-contants -->
									<?php
									/**
									 * Hook - cream_blog_pagination.
									 *
									 * @hooked cream_blog_pagination_action - 10
									 */
									do_action( 'cream_blog_pagination' );
									?>
								</div><!-- .cb-recent-posts.cb-big-posts -->
								<?php
							}
						}
						?>
					</main><!-- #main.site-main -->
				</div><!-- #primary.site-main -->
			</div><!-- .col-* -->
			<?php
			if (
				'right' === $cream_blog_sidebar_position &&
				is_active_sidebar( 'sidebar' )
			) {
				get_sidebar();
			}
			?>
		</div><!-- .row -->
	</div><!-- .cb-mid-wrap.cb-fp-mid-wrap -->

	<div class="cb-fp-bottom-wrap">
		<?php
		/**
		 * Hook - cream_blog_homepage_widget_area_bottom.
		 *
		 * @hooked cream_blog_homepage_widget_area_bottom_action - 10
		 */
		do_action( 'cream_blog_homepage_widget_area_bottom' );
		?>
	</div><!-- .cb-fp-bottom-wrap -->
</div><!-- .cb-container -->
<?php
get_footer();
