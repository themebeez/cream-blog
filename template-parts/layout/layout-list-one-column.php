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
    <?php cream_blog_post_thumbnail(); ?>
    <div class="post-contents">
        <?php cream_blog_post_categories_meta(); ?>
        <div class="post-title">
            <h3>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        </div><!-- .post-title -->
        <?php cream_blog_post_meta( true, true, false ); ?>
        <div class="excerpt">
            <?php the_excerpt(); ?>
        </div><!-- .excerpt -->
        <?php 
        $post_link_title = cream_blog_get_option( 'cream_blog_post_link_title' );
        if( !empty( $post_link_title ) ) {
            ?>
            <div class="permalink">
                <a href="<?php the_permalink(); ?>" class="btn-general">
                    <?php echo esc_attr( $post_link_title ); ?>
                </a>
            </div><!-- .permalink -->
            <?php
        } 
        ?>
    </div><!-- .post-contents -->
</article><!-- .cb-post-box -->