<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cream_Blog
 */

get_header();

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
	<div class="cb-mid-wrap cb-innerpage-mid-wrap cb-default-page-wrap <?php echo esc_attr( $cream_blog_has_sidebar_active ); ?>">
		<?php
		/**
		 * Hook - cream_blog_breadcrumb.
		 *
		 * @hooked cream_blog_breadcrumb_action - 10
		 */
		do_action( 'cream_blog_breadcrumb' );
		?>
		<div class="row">
			<?php
			if ( class_exists( 'WooCommerce' ) ) {
				if (
					is_cart() ||
					is_checkout() ||
					is_account_page()
				) {
					if (
						'left' === $cream_blog_sidebar_position &&
						is_active_sidebar( 'woocommerce-sidebar' )
					) {
						cream_blog_woocommerce_sidebar();
					}
				} else {
					if (
						'left' === $cream_blog_sidebar_position &&
						is_active_sidebar( 'sidebar' )
					) {
						get_sidebar();
					}
				}
			} else {
				if (
					'left' === $cream_blog_sidebar_position &&
					is_active_sidebar( 'sidebar' )
				) {
					get_sidebar();
				}
			}
			?>
			<div class="<?php echo esc_attr( $cream_blog_main_class ); ?>">
				<div id="primary" class="content-area">
					<main id="main" class="site-main">
						<?php
						while ( have_posts() ) {

							the_post();

							get_template_part( 'template-parts/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						}
						?>
					</main><!-- #main.site-main -->
				</div><!-- #primary.content-area -->
			</div>
			<?php
			if ( class_exists( 'WooCommerce' ) ) {
				if (
					is_cart() ||
					is_checkout() ||
					is_account_page()
				) {
					if (
						'right' === $cream_blog_sidebar_position &&
						is_active_sidebar( 'woocommerce-sidebar' )
					) {
						cream_blog_woocommerce_sidebar();
					}
				} else {
					if (
						'right' === $cream_blog_sidebar_position &&
						is_active_sidebar( 'sidebar' )
					) {
						get_sidebar();
					}
				}
			} else {
				if (
					'right' === $cream_blog_sidebar_position &&
					is_active_sidebar( 'sidebar' )
				) {
					get_sidebar();
				}
			}
			?>
		</div><!-- .row -->
	</div><!-- .cb-mid-wrap.cb-innerpage-mid-wrap.cb-default-page-wrap -->
</div><!-- .cb-container -->
<?php
get_footer();
