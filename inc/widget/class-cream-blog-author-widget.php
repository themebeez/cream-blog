<?php
/**
 * Cream Blog class and the class object initialization.
 *
 * @package    Cream_Blog
 * @author     Themebeez <themebeez@gmail.com>
 * @copyright  Copyright (c) 2018, Themebeez
 * @link       http://themebeez.com/themes/cream-blog/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class Cream_Blog_Author_Widget extends WP_Widget {
 
    function __construct() { 

        parent::__construct(
            'cream-blog-author-widget',  // Base ID
            esc_html__( 'CB: Author Widget', 'cream-blog' ),   // Name
            array(
                'classname' => '',
                'description' => esc_html__( 'Displays Brief Author Description.', 'cream-blog' ), 
            )
        );
 
    }
 
    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
            
        $author_page = !empty( $instance['author_page'] ) ? $instance['author_page'] : ''; 

        $author_signature   = !empty( $instance['author_signature'] ) ? $instance['author_signature'] : '';

        $page_link_title = !empty( $instance['author_page_link_title'] ) ? $instance['author_page_link_title'] : '';

        echo $args[ 'before_widget' ];

            $author_args = array(
                'post_type' => 'page',
                'posts_per_page' => 1,
            ); 

            if( $author_page > 0 ) {
                $author_args['page_id'] = absint( $author_page );
            }

            $author = new WP_Query( $author_args );

            if( $author->have_posts() ) :
                if( !empty( $title ) ) {
                    echo $args['before_title'];
                    echo esc_html( $title );
                    echo $args['after_title'];
                }
                while( $author->have_posts() ) : $author->the_post();
                    ?>
                    <div class="cb-author-widget">
                        <?php
                        $thumbnail_url = '';
                        if( has_post_thumbnail() ) {
                            $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'cream-blog-thumbnail-three' );
                            ?>
                            <div class="thumb <?php cream_blog_parent_lazyload_class(); ?>">
                                <?php
                                if( cream_blog_get_option( 'cream_blog_enable_lazyload' ) == true ) {
                                    ?>
                                    <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo esc_url( $thumbnail_url ); ?>" data-srcset="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
                                    <noscript>
                                        <img src="<?php echo esc_url( $thumbnail_url ); ?>" srcset="<?php echo esc_url( $thumbnail_url ); ?>" class="image-fallback" alt="<?php the_title_attribute(); ?>">
                                    </noscript>
                                    <?php
                                } else {
                                    ?>
                                    <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
                                    <?php
                                }
                                ?>
                            </div><!-- .thumb.lazyloading -->
                            <?php
                        }
                        ?>
                        <div class="author-name">
                            <h4><?php the_title(); ?></h4>
                        </div><!-- .author-name -->
                        <div class="author-bio">
                            <?php the_excerpt(); ?>
                            <?php 
                            if( !empty( $page_link_title ) ) { 
                                ?>
                                <a href="<?php the_permalink(); ?>"><?php echo esc_html( $page_link_title ); ?></a>
                                <?php
                            }
                            ?>
                        </div><!-- .author-bio -->
                        <?php  
                        if( !empty( $author_signature ) ) {
                            ?>
                            <div class="author-signature">
                                <img src="<?php echo esc_url( $author_signature ); ?>" alt="signature">
                            </div><!-- .author-signature -->
                            <?php
                        }
                        ?>
                    </div><!-- .cb-author-widget -->
                    <?php
                endwhile;
                wp_reset_postdata();                
            endif;
        echo $args[ 'after_widget' ]; 
 
    }
 
    public function form( $instance ) {
        $defaults = array(
            'title' => '',
            'author_page' => '',
            'author_signature' => '',
            'author_page_link_title' => '',
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

        $author_signature = esc_url( $instance['author_signature'] );

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_name('title') ); ?>">
                <strong><?php esc_html_e('Title', 'cream-blog'); ?></strong>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />   
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'author_page' ) )?>"><strong><?php echo esc_html__( 'Author Page', 'cream-blog' ); ?></strong></label>
            <?php
                wp_dropdown_pages( array(
                    'id'               => esc_attr( $this->get_field_id( 'author_page' ) ),
                    'class'            => 'widefat',
                    'name'             => esc_attr( $this->get_field_name( 'author_page' ) ),
                    'selected'         => esc_attr( $instance[ 'author_page' ] ),
                    'show_option_none' => esc_html__( '&mdash; Select Page &mdash;', 'cream-blog' ),
                    )
                );
            ?>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('author_signature')); ?>">
                <strong><?php esc_html_e('Author Signature', 'cream-blog'); ?></strong>
            </label>
            <br/>
            <?php
            if ( !empty( $author_signature ) ) :
                echo '<img class="custom_media_image widefat" src="' . esc_url( $author_signature ) . '"/><br />';
            endif;
            ?>
            <input type="text" class="widefat custom_media_url"
                   name="<?php echo esc_attr($this->get_field_name('author_signature')); ?>"
                   id="<?php echo esc_attr($this->get_field_id('author_signature')); ?>" value="<?php echo esc_url( $author_signature ); ?>">
            <input type="button" class="button button-primary custom_media_button" id="custom_media_button"
                   name="<?php echo esc_attr($this->get_field_name('author_signature')); ?>"
                   value="<?php esc_attr_e('Upload', 'cream-blog') ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name('author_page_link_title') ); ?>">
                <strong><?php esc_html_e('Author Page Link Title', 'cream-blog'); ?></strong>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('author_page_link_title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('author_page_link_title') ); ?>" type="text" value="<?php echo esc_attr( $instance['author_page_link_title'] ); ?>" />   
        </p>
        <?php 
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field( $new_instance['title'] );

        $instance['author_page'] = absint( $new_instance['author_page'] );

        $instance['author_signature'] = esc_url_raw( $new_instance['author_signature'] );

        $instance['author_page_link_title'] = sanitize_text_field( $new_instance['author_page_link_title'] );

        return $instance;
    } 
}