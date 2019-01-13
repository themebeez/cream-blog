<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cream_Blog
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'cb-post-box' ); ?>>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <?php cream_blog_post_thumbnail(); ?>
        </div><!-- .col -->
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="post-contents">
                <?php cream_blog_post_categories_meta(); ?>
                <div class="post-title">
                    <h3>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div><!-- .post-title -->
                <div class="excerpt">
                    <?php the_excerpt(); ?>
                </div><!-- .excerpt -->
                <?php cream_blog_post_meta( true, true, false ); ?>
                <div class="permalink">
                    <a href="<?php the_permalink(); ?>" class="btn-general">
                        <?php esc_html_e( 'Continue Reading', 'cream-blog' ); ?>
                    </a>
                </div><!-- .permalink -->
            </div><!-- .post-contents -->
        </div><!-- .col-* -->
    </div><!-- .row -->
</article><!-- .cb-post-box -->