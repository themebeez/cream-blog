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

class Cream_Blog_Post_Widget extends WP_Widget {
 
    function __construct() { 

        parent::__construct(
            'cream-blog-post-widget',  // Base ID
            esc_html__( 'CB: Posts Widget', 'cream-blog' ),   // Name
            array(
                'classname' => 'cb-rp-widget cb-post-widget',
                'description' => esc_html__( 'Displays Recent, Most Commented or Editor Picked Posts.', 'cream-blog' ), 
            )
        );
 
    }
 
    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$post_choice = !empty( $instance[ 'post_choice' ] ) ? $instance[ 'post_choice' ] : 'recent';

		$posts_no = !empty( $instance[ 'post_no' ] ) ? $instance[ 'post_no' ] : 5;

		echo $args[ 'before_widget' ];

		$post_args = array(
			'posts_per_page' => absint( $posts_no ),
			'post_type' => 'post'
		);

		if( !empty( $post_choice ) ) {

			if( $post_choice == 'most_commented' ) {
				$post_args['orderby'] = 'comment_count';
				$post_args['order'] = 'desc';
			}
		}

		$post_query = new WP_Query( $post_args );

		if( $post_query->have_posts() ) {

			echo $args[ 'before_title' ];
				echo esc_html( $title );
			echo $args[ 'after_title' ];
            ?>
            <div class="post-widget-container">
                <?php
                while( $post_query->have_posts() ) {
                    $post_query->the_post();
                    ?>
                    <div class="cb-post-box">
                        <div class="cb-col">
                            <?php
                            $thumbnail_url = '';
                            if( has_post_thumbnail() ) {
                                $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'cream-blog-thumbnail-two' );
                            }
                            if( !empty( $thumbnail_url ) ) {
                                ?>
                                <div class="thumb <?php cream_blog_parent_lazyload_class(); ?>">
                                    <a href="<?php the_permalink(); ?>">
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
                                    </a>
                                </div>
                                <?php
                            }
                            ?>
                        </div><!-- .cb-col -->
                        <div class="cb-col">
                            <div class="post-contents">
                                <div class="post-title">
                                    <h4>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h4>
                                </div><!-- .post-title -->
                                <?php 
                                if( $post_choice == 'recent' ) {
                                    cream_blog_post_meta( true, false, false );
                                } else {
                                    cream_blog_post_meta( false, false, true );
                                }
                                ?>
                            </div><!-- .post-contents -->
                        </div><!-- .cb-col -->
                    </div><!-- .cb-post-box -->
                    <?php
                }
                wp_reset_postdata();
                ?>
            </div><!-- .post-widget-container -->
            <?php            
		}
			
		echo $args[ 'after_widget' ]; 
 
    }
 
    public function form( $instance ) {
        $defaults = array(
            'title'       => '',
            'post_choice'	=> 'recent',
            'post_no'	  => 5,
        );

        $instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
            <label for="<?php echo esc_attr( $this->get_field_name('title') ); ?>">
                <strong><?php esc_html_e('Title', 'cream-blog'); ?></strong>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />   
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_name('post_choice') ); ?>">
                <?php esc_html_e('Type of Posts:', 'cream-blog'); ?>
            </label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id('post_choice') ); ?>" name="<?php echo esc_attr( $this->get_field_name('post_choice') ); ?>">
            	<?php
            		$post_choices = array(
            			'recent' => esc_html__( 'Recent Posts', 'cream-blog' ),
            			'most_commented' => esc_html__( 'Most Commented', 'cream-blog' ),
            		);

            		foreach( $post_choices as $key => $post_choice ) {
            	        ?>
            			<option value="<?php echo esc_attr( $key ); ?>" <?php if( $instance['post_choice'] == $key ) { echo esc_attr( 'selected' ); } ?>>
            				<?php
            					echo esc_html( $post_choice );
            				?>
            			</option>
            	        <?php
            		}
            	?>
            </select>
        </p> 

		<p>
            <label for="<?php echo esc_attr( $this->get_field_name('post_no') ); ?>">
                <strong><?php esc_html_e('No of Posts', 'cream-blog'); ?></strong>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('post_no') ); ?>" name="<?php echo esc_attr( $this->get_field_name('post_no') ); ?>" type="number" value="<?php echo esc_attr( $instance['post_no'] ); ?>" />   
        </p>

        
		<?php
    }
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = $old_instance;

        $instance['title']  	= sanitize_text_field( $new_instance['title'] );

        $instance['post_choice']  	= sanitize_text_field( $new_instance['post_choice'] );

        $instance['post_no']  	= absint( $new_instance['post_no'] );

        return $instance;
    } 
}