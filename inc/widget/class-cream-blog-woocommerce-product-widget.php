<?php
/**
 * WooCommerce product widget class.
 *
 * @package    Cream_Blog
 * @author     Themebeez <themebeez@gmail.com>
 * @copyright  Copyright (c) 2018, Themebeez
 * @link       http://themebeez.com/themes/cream-blog/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Widget class - Cream_Blog_Woocommerce_Product_Widget.
 *
 * @since 1.0.0
 *
 * @package Cream_Blog
 */
class Cream_Blog_WooCommerce_Product_Widget extends WP_Widget {

	/**
	 * Define id, name and description of the widget.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		parent::__construct(
			'cream-blog-woocommerce-product-widget',
			esc_html__( 'CB: Woocommerce Products', 'cream-blog' ),
			array(
				'classname'   => '',
				'description' => esc_html__( 'Displays Woocommerce Products.', 'cream-blog' ),
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

		$limit        = ! empty( $instance['no_of_products'] ) ? $instance['no_of_products'] : 4;
		$columns      = ! empty( $instance['no_of_columns'] ) ? $instance['no_of_columns'] : 4;
		$orderby      = ! empty( $instance['orderby'] ) ? $instance['orderby'] : 'date';
		$skus         = ! empty( $instance['skus'] ) ? $instance['skus'] : '';
		$categories   = ! empty( $instance['category'] ) ? $instance['category'] : '';
		$order        = ! empty( $instance['order'] ) ? $instance['order'] : 'desc';
		$on_sale      = ! empty( $instance['on_sale'] ) ? $instance['on_sale'] : false;
		$best_selling = ! empty( $instance['best_selling'] ) ? $instance['best_selling'] : false;
		$top_rated    = ! empty( $instance['top_rated'] ) ? $instance['top_rated'] : false;
		$featured     = ! empty( $instance['featured'] ) ? $instance['featured'] : false;

		$attr = array();

		if ( ! empty( $limit ) ) {
			$attr[] = 'limit="' . $limit . '"';
		}
		if ( ! empty( $columns ) ) {
			$attr[] = 'columns="' . $columns . '"';
		}
		if ( ! empty( $orderby ) ) {
			$attr[] = 'orderby="' . $orderby . '"';
		}
		if ( ! empty( $skus ) ) {
			$attr[] = 'skus="' . $skus . '"';
		}
		if ( ! empty( $categories ) ) {
			$attr[] = 'category="' . $categories . '"';
		}
		if ( ! empty( $order ) ) {
			$attr[] = 'order="' . $order . '"';
		}
		if ( true === $on_sale || 1 === $on_sale ) {
			$attr[] = 'on_sale="1"';
		}
		if ( true === $best_selling || 1 === $best_selling ) {
			$attr[] = 'best_selling="1"';
		}
		if ( true === $top_rated || 1 === $top_rated ) {
			$attr[] = 'top_rated="1"';
		}
		if ( true === $featured || 1 === $featured ) {
			$attr[] = 'visibility="featured"';
		}

		$shortcode = '[products]';

		if ( ! empty( $attr ) ) {
			$shortcode = '[products ' . implode( ' ', $attr ) . ']';
		}

		?>
		<section class="cb-woocommerce-products">
			<div class="section-inner">
				<?php
				if ( ! empty( $title ) ) {
					?>
					<div class="section-title">
						<h2><?php echo esc_html( $title ); ?></h2>
					</div><!-- .section-title -->
					<?php
				}
				?>
				<div class="section-main-contents">
					<?php echo do_shortcode( $shortcode ); ?>
				</div><!-- .section-main-contents -->
			</div><!-- .section-inner -->
		</section><!-- .cb-woocommerce-products -->
		<?php
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
			'title'          => '',
			'no_of_products' => 4,
			'no_of_columns'  => 4,
			'orderby'        => 'date',
			'skus'           => '',
			'category'       => '',
			'order'          => 'desc',
			'on_sale'        => false,
			'best_selling'   => false,
			'top_rated'      => false,
			'featured'       => false,
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
			<label for="<?php echo esc_attr( $this->get_field_name( 'no_of_products' ) ); ?>">
				<strong><?php esc_html_e( 'No of Products', 'cream-blog' ); ?></strong>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'no_of_products' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'no_of_products' ) ); ?>"
				type="number"
				value="<?php echo esc_attr( $instance['no_of_products'] ); ?>"
			/>  
			<small><?php esc_html_e( 'Set no of products to be displayed', 'cream-blog' ); ?></small> 
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'no_of_columns' ) ); ?>">
				<strong><?php esc_html_e( 'No of Columns', 'cream-blog' ); ?></strong>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'no_of_columns' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'no_of_columns' ) ); ?>"
				type="number" value="<?php echo esc_attr( $instance['no_of_columns'] ); ?>"
			/>  
			<small><?php esc_html_e( 'Set no of columns to be displayed', 'cream-blog' ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
				<?php esc_html_e( 'Orderby', 'cream-blog' ); ?>
			</label>
			<select
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>"
			>
				<?php
				$orderby_choices = array(
					'title'      => esc_html__( 'Title', 'cream-blog' ),
					'date'       => esc_html__( 'Date', 'cream-blog' ),
					'id'         => esc_html__( 'ID', 'cream-blog' ),
					'menu_order' => esc_html__( 'Menu Order', 'cream-blog' ),
					'popularity' => esc_html__( 'Popularity', 'cream-blog' ),
					'rand'       => esc_html__( 'Random', 'cream-blog' ),
					'rating'     => esc_html__( 'Rating', 'cream-blog' ),
				);

				foreach ( $orderby_choices as $key => $choice ) {
					?>
					<option
						value="<?php echo esc_attr( $key ); ?>"
						<?php
						if ( $instance['orderby'] === $key ) {
							echo 'selected';
						}
						?>
					><?php echo esc_html( $choice ); ?>
					</option>
					<?php
				}
				?>
			</select>
		</p> 

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'skus' ) ); ?>">
				<strong><?php esc_html_e( 'SKUS', 'cream-blog' ); ?></strong>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'skus' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'skus' ) ); ?>"
				type="text"
				value="<?php echo esc_attr( $instance['skus'] ); ?>"
			/>  
			<small><?php esc_html_e( 'List product SKUs seperated by comma.', 'cream-blog' ); ?></small> 
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>">
				<strong><?php esc_html_e( 'Product Categories', 'cream-blog' ); ?></strong>
			</label>
			<input
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>"
				type="text" value="<?php echo esc_attr( $instance['category'] ); ?>"
			/>  
			<small><?php esc_html_e( 'List product category slugs seperated by comma.', 'cream-blog' ); ?></small> 
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
				<?php esc_html_e( 'Order', 'cream-blog' ); ?>
			</label>
			<select
				class="widefat"
				id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"
				name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>"
			>
				<?php
				$order_choices = array(
					'asc'  => esc_html__( 'ASC', 'cream-blog' ),
					'desc' => esc_html__( 'DESC', 'cream-blog' ),
				);

				foreach ( $order_choices as $key => $choice ) {
					?>
					<option
						value="<?php echo esc_attr( $key ); ?>"
						<?php
						if ( $instance['order'] === $key ) {
							echo 'selected';
						}
						?>
					><?php echo esc_html( $choice ); ?>
					</option>
					<?php
				}
				?>
			</select>
		</p> 

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'on_sale' ) ); ?>">
				<input
					type="checkbox"
					id="<?php echo esc_attr( $this->get_field_id( 'on_sale' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'on_sale' ) ); ?>"
					value="1"
					<?php checked( 1, esc_attr( $instance['on_sale'] ) ); ?>
				/>
				<?php esc_html_e( 'Display On Sale Products', 'cream-blog' ); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'best_selling' ) ); ?>">
				<input
					type="checkbox"
					id="<?php echo esc_attr( $this->get_field_id( 'best_selling' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'best_selling' ) ); ?>"
					value="1"
					<?php checked( 1, esc_attr( $instance['best_selling'] ) ); ?>
				/>
				<?php esc_html_e( 'Display Best Selling Products', 'cream-blog' ); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'top_rated' ) ); ?>">
				<input
					type="checkbox"
					id="<?php echo esc_attr( $this->get_field_id( 'top_rated' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'top_rated' ) ); ?>"
					value="1" <?php checked( 1, esc_attr( $instance['top_rated'] ) ); ?>
				/>
				<?php esc_html_e( 'Display Top Rated Products', 'cream-blog' ); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_name( 'featured' ) ); ?>">
				<input
					type="checkbox"
					id="<?php echo esc_attr( $this->get_field_id( 'featured' ) ); ?>"
					name="<?php echo esc_attr( $this->get_field_name( 'featured' ) ); ?>"
					value="1"
					<?php checked( 1, esc_attr( $instance['featured'] ) ); ?>
				/>
				<?php esc_html_e( 'Display Featured Products', 'cream-blog' ); ?>
			</label>
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

		$instance['title']          = isset( $new_instance['title'] ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['no_of_products'] = isset( $new_instance['no_of_products'] ) ? absint( $new_instance['no_of_products'] ) : 4;
		$instance['no_of_columns']  = isset( $new_instance['no_of_columns'] ) ? absint( $new_instance['no_of_columns'] ) : 4;
		$instance['orderby']        = isset( $new_instance['orderby'] ) ? sanitize_text_field( $new_instance['orderby'] ) : 'date';
		$instance['skus']           = isset( $new_instance['skus'] ) ? sanitize_text_field( $new_instance['skus'] ) : '';
		$instance['category']       = isset( $new_instance['category'] ) ? sanitize_text_field( $new_instance['category'] ) : '';
		$instance['order']          = isset( $new_instance['order'] ) ? sanitize_text_field( $new_instance['order'] ) : 'desc';
		$instance['on_sale']        = isset( $new_instance['on_sale'] ) ? true : false;
		$instance['best_selling']   = isset( $new_instance['best_selling'] ) ? true : false;
		$instance['top_rated']      = isset( $new_instance['top_rated'] ) ? true : false;
		$instance['featured']       = isset( $new_instance['featured'] ) ? true : false;

		return $instance;
	}
}
