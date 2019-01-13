<?php
/**
 * Cream Blog Widget Init class for widgets and widget area initialization.
 *
 * @package    Cream_Blog
 * @author     Themebeez <themebeez@gmail.com>
 * @copyright  Copyright (c) 2018, Themebeez
 * @link       http://themebeez.com/themes/cream-blog/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Cream Blog Widget Init Class
 */
class Cream_Blog_Widget_Init {

	/**
	 * Setup class.
	 *
	 * @return  void
	 */
	public function __construct() {	

		add_action( 'widgets_init', array( $this, 'widgets_init' ), 5 );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ), 10 );

		$this->load_dependencies();
	}

	/**
	 * Load the required dependencies for this this.
	 *
	 * @return void
	 */
	public function load_dependencies() {
		// Load author widget class
		require get_template_directory() . '/inc/widget/class-cream-blog-author-widget.php';
		// Load post widget class
		require get_template_directory() . '/inc/widget/class-cream-blog-post-widget.php';
		// Load social widget class
		require get_template_directory() . '/inc/widget/class-cream-blog-social-widget.php';
		// Load woocommerce product widget class
		require get_template_directory() . '/inc/widget/class-cream-blog-woocommerce-product-widget.php';
	}

	/**
	 * Enqueue scripts and styles for admin.
	 *
	 * @see 	https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts
	 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 * @see 	https://developer.wordpress.org/reference/functions/wp_enqueue_script/
	 * @return 	void
	 */
	public function admin_enqueue() {

		wp_enqueue_script( 'media-upload' );

		wp_enqueue_media();

		wp_enqueue_style( 'cream-blog-admin-style', get_template_directory_uri() . '/admin/css/admin-style.css' );

		wp_enqueue_script( 'cream-blog-admin-script', get_template_directory_uri() . '/admin/js/admin-script.js', array( 'jquery' ), CREAM_BLOG_VERSION, true );
	}

	/**
	 * Register widget area.
	 *
	 * @see 	https://codex.wordpress.org/Function_Reference/register_sidebar
	 * @return  void
	 */
	public function widgets_init() {

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'cream-blog' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'cream-blog' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><h3>',
			'after_title'   => '</h3></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer', 'cream-blog' ),
			'id'            => 'footer',
			'description'   => esc_html__( 'Add widgets here.', 'cream-blog' ),
			'before_widget' => '<div class="col-lg-4 col-md-12 col-sm-12 col-12"><div class="widget"><div id="%1$s" class="%2$s">',
			'after_widget'  => '</div></div></div>',
			'before_title'  => '<div class="widget-title"><h3>',
			'after_title'   => '</h3></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Header Advertisement', 'cream-blog' ),
			'id'            => 'header-advertisement',
			'description'   => esc_html__( 'Add widgets here.', 'cream-blog' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><h3>',
			'after_title'   => '</h3></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Home Widget Area Top', 'cream-blog' ),
			'id'            => 'home-widget-area-top',
			'description'   => esc_html__( 'This widget area will be displayed below the banner and above the blog post list section.', 'cream-blog' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><h3>',
			'after_title'   => '</h3></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Home Widget Area Bottom', 'cream-blog' ),
			'id'            => 'home-widget-area-bottom',
			'description'   => esc_html__( 'This widget area will be displayed below the blog post list section and above the footer.', 'cream-blog' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><h3>',
			'after_title'   => '</h3></div>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Off Canvas Sidebar', 'cream-blog' ),
			'id'            => 'off-canvas-sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'cream-blog' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<div class="widget-title"><h3>',
			'after_title'   => '</h3></div>',
		) );

		if( class_exists( 'Woocommerce' ) ) {
			register_sidebar( array(
				'name'          => esc_html__( 'Woocommerce Sidebar', 'cream-blog' ),
				'id'            => 'woocommerce-sidebar',
				'description'   => esc_html__( 'Add widgets here.', 'cream-blog' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<div class="widget-title"><h3>',
				'after_title'   => '</h3></div>',
			) );
		}

		register_widget( 'Cream_Blog_Author_Widget' );

		register_widget( 'Cream_Blog_Post_Widget' );
		
		register_widget( 'Cream_Blog_Social_Widget' );

		register_widget( 'Cream_Blog_Woocommerce_Product_Widget' );
	}
}