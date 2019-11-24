<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cream_Blog
 */

	get_header();
	$sidebar_existence = '';
    $sidebar_position = cream_blog_sidebar_position();
    $main_class = cream_blog_main_class();
    if( $sidebar_position != 'none' && is_active_sidebar( 'sidebar' ) ) {
        $sidebar_existence = 'has-sidebar';
    }
	?>
	<div class="cb-container">
	    <div class="cb-mid-wrap cb-innerpage-mid-wrap cb-archive-page-wrap <?php if( !empty( $sidebar_existence ) ) { echo esc_attr( $sidebar_existence ); } ?>">
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
                if( $sidebar_position == 'left' && is_active_sidebar( 'sidebar' ) ) {
                    get_sidebar();
                }
                ?>
	            <div class="<?php echo esc_attr( $main_class ); ?>">
	                <div id="primary" class="content-area">
	                    <main id="main" class="site-main">
	                    	<?php
	                    	if( have_posts() ) {
		                    	?>
		                        <section class="cb-page-entry archive-page-entry">

		                            <div class="page-title">
		                            	<?php
	                                    the_archive_title( '<h1>', '</h1>' );
	                                    the_archive_description( '<div class="archive-description">', '</div>' );
	                                    ?>
		                            </div><!-- .page-title -->
		                            
                        			<section class="cb-recent-posts cb-post-bricks">
                                        <div class="section-contants">
                                            <div id="bricks-row">
	                        				<?php
			                        		while( have_posts() ) {

			                                    the_post();

			                                    get_template_part( 'template-parts/layout/layout', 'masonry-with-excerpt' );
			                                }
			                                ?>
		                            		</div><!-- #bricks-row -->
	                        			</div><!-- .section-contants -->
                        				<?php
                        				/**
	                                    * Hook - cream_blog_pagination.
	                                    *
	                                    * @hooked cream_blog_pagination_action - 10
	                                    */
	                                    do_action( 'cream_blog_pagination' );
                        				?>
	                        		</section><!-- .cb-recent-posts.cb-post-bricks -->
		                        </section><!-- .cb-page-entry.archive-page-entry -->
		                        <?php
		                    } else {
		                    	get_template_part( 'template-parts/content', 'none' );
		                    }
		                    ?>
	                    </main><!-- #main.site-main -->
	                </div><!-- #primary.content-area -->
	            </div><!-- .col -->
	            <?php
                if( $sidebar_position == 'right' && is_active_sidebar( 'sidebar' ) ) {
                    get_sidebar();
                }
                ?>
	        </div><!-- .main row -->
	    </div><!-- .cb-mid-wrap.cb-innerpage-mid-wrap.cb-archive-page-wrap -->
	</div><!-- .cb-container -->
	<?php
get_footer();
