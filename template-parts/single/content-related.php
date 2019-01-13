<?php
/**
 * The template for displaying related posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Cream_Blog
 */
$enable_related_posts = cream_blog_get_option( 'cream_blog_enable_related_section' );
$section_title = cream_blog_get_option( 'cream_blog_related_section_title' );
$related_posts_no = cream_blog_get_option( 'cream_blog_related_section_posts_number');

$related_args = array(
    'no_found_rows'       => true,
    'ignore_sticky_posts' => true,
);

if( absint( $related_posts_no ) > 0 ) {
    $related_args['posts_per_page'] = absint( $related_posts_no );
} else {
    $related_args['posts_per_page'] = 6;
}

$current_object = get_queried_object();

if ( $current_object instanceof WP_Post ) {

    $current_id = $current_object->ID;
    if ( absint( $current_id ) > 0 ) {
        // Exclude current post.
        $related_args['post__not_in'] = array( absint( $current_id ) );
        // Include current posts categories.
        $categories = wp_get_post_categories( $current_id );
        if ( ! empty( $categories ) ) {
            $related_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $categories,
                    'operator' => 'IN',
                    )
                );
        }
    }
}

$related_posts = new WP_Query( $related_args );

if( $related_posts->have_posts() && $enable_related_posts == true ) {
    ?>
    <div class="related-posts">
        <?php
        if( !empty( $section_title ) ) {
            ?>
            <div class="block-title">
                <h3><?php echo esc_html( $section_title ); ?></h3>
            </div><!-- .block-title -->
            <?php
        }
        ?>
        <div class="cb-recent-posts cb-grid-style-4">
            <div class="section-contants">
                <div class="row">
                    <?php
                    while( $related_posts->have_posts() ) {
                        $related_posts->the_post();

                        $sidebar_position = cream_blog_sidebar_position();
                        $post_container_class = '';
                        if( $sidebar_position != 'none' && is_active_sidebar( 'sidebar' ) ) {
                            $post_container_class = 'col-lg-6 col-md-6 col-sm-12 col-12';
                        } else {
                            $post_container_class = 'col-lg-4 col-md-4 col-sm-12 col-12';
                        }
                        ?>
                        <div class="<?php echo esc_attr( $post_container_class ); ?>">
                            <article class="cb-post-box">
                                <?php
                                $thumbnail = 'cream-blog-thumbnail-three';
                                $thumbnail_url = '';
                                if( has_post_thumbnail() ) {
                                    $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), $thumbnail );
                                    ?>
                                    <div class="thumb">
                                        <a class="lazyloading" href="<?php the_permalink(); ?>">
                                            <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo esc_url( $thumbnail_url ); ?>" data-srcset="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
                                            <noscript>
                                                <img src="<?php echo esc_url( $thumbnail_url ); ?>" srcset="<?php echo esc_url( $thumbnail_url ); ?>" class="image-fallback" alt="<?php the_title_attribute(); ?>">
                                            </noscript>
                                        </a>
                                    </div><!-- .thumb.lazyloading -->
                                    <?php
                                }
                                ?>
                                <div class="post-contents">
                                    <?php cream_blog_post_categories_meta(); ?>
                                    <div class="post-title">
                                        <h3>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                    </div><!-- .post-title -->
                                </div><!-- .post-contents -->
                            </article><!-- .cb-post-box -->
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                </div><!-- .row -->
            </div><!-- .section-contants -->
        </div><!-- .cb-recent-posts.cb-grid-style-4 -->
    </div><!-- .related-posts -->
    <?php
}