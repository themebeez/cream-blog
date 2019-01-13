<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cream_Blog
 */
?>
<div class="brick-item">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'cb-post-box' ); ?>>
        <?php cream_blog_post_thumbnail(); ?>
        <div class="post-contents">
            <?php cream_blog_post_categories_meta(); ?>
            <div class="post-title">
                <h3>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
            </div><!-- .post-title -->
            <?php cream_blog_post_meta( true, false, false ); ?>
            <div class="excerpt">
                <?php the_excerpt(); ?>
            </div><!-- .excerpt -->
        </div><!-- .post-contents -->
    </article><!-- .cb-post-box -->
</div><!-- .Brick item -->