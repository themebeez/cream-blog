<?php
/**
 * Template part for displaying banner layout four
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cream_Blog
 */
$banner_query = cream_blog_banner_query();
if( $banner_query->have_posts() ) {
    ?>
    <div class="cb-banner">
        <div class="banner-inner">
            <div class="cb-container">
                <div class="owl-carousel" id="cb-banner-style-2">
                	<?php
                	while( $banner_query->have_posts() ) {
                		$banner_query->the_post();
                		$thumbnail_url = '';
                		if( has_post_thumbnail() ) {
                			$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'cream-blog-thumbnail-one' );
                			if( !empty( $thumbnail_url ) ) {
                				?>
                				<div class="item">
			                        <div class="thumb lazyloading">
			                            <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo esc_url( $thumbnail_url ); ?>" data-srcset="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
							            <noscript>
							                <img src="<?php echo esc_url( $thumbnail_url ); ?>" srcset="<?php echo esc_url( $thumbnail_url ); ?>" class="image-fallback" alt="<?php the_title_attribute(); ?>">
							            </noscript>
			                            <div class="post-contents">
			                                <?php cream_blog_post_categories_meta(); ?>
			                                <div class="post-title">
			                                    <h3>
			                                    	<a href="<?php the_permalink(); ?>">
			                                    		<?php the_title(); ?>
			                                    	</a>
			                                    </h3>
			                                </div><!-- .post-title -->
			                                <?php cream_blog_post_meta( true, false, false ); ?>
			                            </div><!-- .post-contents -->
			                        </div><!-- .thumb.lazyloading -->
			                        <div class="mask"></div>
			                    </div><!-- .item -->
                				<?php
                			}
                		}
                	}
                	wp_reset_postdata();
                	?>
                </div><!-- #cb-banner-style-2.owl-carousel -->
            </div><!-- .cb-container -->
        </div><!-- .banner-inner -->
    </div><!-- .cb=banner -->
    <?php
}