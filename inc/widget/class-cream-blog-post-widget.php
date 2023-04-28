<?php
/**
 * Post widget class.
 *
 * @package    Cream_Blog
 * @author     Themebeez <themebeez@gmail.com>
 * @copyright  Copyright (c) 2018, Themebeez
 * @link       http://themebeez.com/themes/cream-blog/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Widget class - Cream_Blog_Post_Widget.
 *
 * @since 1.0.0
 *
 * @package Cream_Blog
 */
class Cream_Blog_Post_Widget extends WP_Widget {

	/**
	 * Define id, name and description of the widget.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		parent::__construct(
			'cream-blog-post-widget',
			esc_html__( 'CB: Posts Widget', 'cream-blog' ),
			array(
				'classname'   => 'cb-rp-widget cb-post-widget',
				'description' => esc_html__( 'Displays Recent, Most Commented or Editor Picked Posts.', 'cream-blog' ),
			)
		);
	}

	/**
	 * Renders widget at the frontend.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Provides the HTML you can use to display the widget title class and widget content class.
	 * @param array $instance The settings for the instance of the widget..
	 */
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		$post_choice = ! empty( $instance['post_choice'] ) ? $instance['post_choice'] : 'recent';
		$posts_no    = ! empty( $instance['post_no'] ) ? $instance['post_no'] : 5;

		echo $args['before_widget']; // phpcs:ignore

		$post_args = array(
			'posts_per_page' => absint( $posts_no ),
			'post_type'      => 'post',
		);

		if ( ! empty( $post_choice ) ) {

			if ( 'most_commented' === $post_choice ) {
				$post_args['orderby'] = 'comment_count';
				$post_args['order']   = 'desc';
			}
		}

		$post_query = new WP_Query( $post_args );

		if ( $post_query->have_posts() ) {

			echo $args['before_title']; // phpcs:ignore
				echo esc_html( $title );
			echo $args['after_title']; // phpcs:ignore
			?>
			<div class="post-widget-container">
				<?php
				while ( $post_query->have_posts() ) {
					$post_query->the_post();
					?>
					<div class="cb-post-box">
						<div class="cb-col">
							<?php
							$thumbnail_url = '';
							if ( has_post_thumbnail() ) {
								$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'cream-blog-thumbnail-two' );
							}
							if ( ! empty( $thumbnail_url ) ) {
								?>
								<div class="thumb">
									<a href="<?php the_permalink(); ?>">
										<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
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
								if ( 'recent' === $post_choice ) {
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

		echo $args['after_widget']; // phpcs:ignore
	}

	/**
	 * Adds setting fields to the widget and renders them in the form.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance The settings for the instance of the widget..
	 */
	public function form( $instance ) {

		$defaults = array(
			'title'       => '',
			'post_choice' => 'recent',
			'post_no'     => 5,
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>">
				<strong><?php esc_html_e( 'Title', 'cream-blog' ); ?></strong>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $instance['title'] ); ?>"
			/>   
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'post_choice' ) ); ?>">
				<?php esc_html_e( 'Type of Posts:', 'cream-blog' ); ?>
			</label>
			<select
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'post_choice' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'post_choice' ) ); ?>"
			>
				<?php
				$post_choices = array(
					'recent'         => esc_html__( 'Recent Posts', 'cream-blog' ),
					'most_commented' => esc_html__( 'Most Commented', 'cream-blog' ),
				);

				foreach ( $post_choices as $key => $post_choice ) {
					?>
					<option
						value="<?php echo esc_attr( $key ); ?>"
						<?php
						if ( $instance['post_choice'] === $key ) {
							echo 'selected';
						}
						?>
					>
						<?php echo esc_html( $post_choice ); ?>
					</option>
					<?php
				}
				?>
			</select>
		</p> 

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'post_no' ) ); ?>">
				<strong><?php esc_html_e( 'No of Posts', 'cream-blog' ); ?></strong>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'post_no' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'post_no' ) ); ?>"
				type="number"
				value="<?php echo esc_attr( $instance['post_no'] ); ?>"
			/>   
		</p>
		<?php
	}

	/**
	 * Sanitizes and saves the instance of the widget.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance The settings for the new instance of the widget.
	 * @param array $old_instance The settings for the old instance of the widget.
	 * @return array Sanitized instance of the widget.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']       = isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['post_choice'] = isset( $new_instance['post_choice'] ) ? sanitize_text_field( $new_instance['post_choice'] ) : 'recent';
		$instance['post_no']     = isset( $new_instance['post_no'] ) ? absint( $new_instance['post_no'] ) : 5;

		return $instance;
	}
}
