<?php
/**
 * Handles the theme's theme customizer functionality.
 *
 * @package    Cream_Blog
 * @author     Themebeez <themebeez@gmail.com>
 * @copyright  Copyright (c) 2018, Themebeez
 * @link       http://themebeez.com/themes/cream-blog/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
class Cream_Blog_Customize {

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	public function __construct() {

		$this->setup_actions();

		$this->load_dependencies();
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'register_panels' ) );
		add_action( 'customize_register', array( $this, 'register_sections' ) );
		add_action( 'customize_register', array( $this, 'register_settings' ) );
		add_action( 'customize_register', array( $this, 'register_controls' ) );
		add_action( 'customize_register', array( $this, 'add_partials' ) );
		add_action( 'wp_head', array( $this, 'dynamic_style' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_scripts' ), 0 );

		// Enqueue scripts and styles for the preview.
		add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );
	}

	/**
	 * Loads dependency functions.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function load_dependencies() {

		require get_template_directory() . '/inc/customizer/functions/active-callback.php';

		require_once get_template_directory() . '/inc/upgrade-to-pro/class-cream-blog-customize-section-upsell.php';
	}


	/**
	 * Sets up the customizer panels.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param object $wp_customize WP Customize Manager instance.
	 * @return void
	 */
	public function register_panels( $wp_customize ) {

		// Home Page Customization Panel.
		$wp_customize->add_panel(
			'cream_blog_homepage_customization',
			array(
				'title'       => esc_html__( 'Homepage Customization', 'cream-blog' ),
				'description' => esc_html__( 'Cream Blog Homepage Customization. Set Options For Homepage Customization.', 'cream-blog' ),
				'priority'    => 10,
			)
		);

		// Basic Theme Customization Panel.
		$wp_customize->add_panel(
			'cream_blog_basic_customization',
			array(
				'title'       => esc_html__( 'Basic Customization', 'cream-blog' ),
				'description' => esc_html__( 'Cream Blog Basic Customization. Set Options For Basic Theme Customization.', 'cream-blog' ),
				'priority'    => 10,
			)
		);

		// Advance Theme Customization Panel.
		$wp_customize->add_panel(
			'cream_blog_advance_customization',
			array(
				'title'       => esc_html__( 'Advance Customization', 'cream-blog' ),
				'description' => esc_html__( 'Cream Blog Advance Customization. Set Options For Advance Theme Customization.', 'cream-blog' ),
				'priority'    => 10,
			)
		);
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param object $wp_customize WP Customize Manager instance.
	 * @return void
	 */
	public function register_sections( $wp_customize ) {

		$wp_customize->get_section( 'static_front_page' )->panel = 'cream_blog_basic_customization';
		$wp_customize->get_section( 'title_tagline' )->panel     = 'cream_blog_basic_customization';
		$wp_customize->get_section( 'colors' )->panel            = 'cream_blog_basic_customization';
		$wp_customize->get_section( 'header_image' )->panel      = 'cream_blog_basic_customization';
		$wp_customize->get_section( 'background_image' )->panel  = 'cream_blog_basic_customization';
		$wp_customize->get_section( 'custom_css' )->panel        = 'cream_blog_basic_customization';

		$wp_customize->register_section_type( 'Cream_Blog_Customize_Section_Upsell' );

		// Register sections.
		$wp_customize->add_section(
			new Cream_Blog_Customize_Section_Upsell(
				$wp_customize,
				'theme_upsell',
				array(
					'title'    => esc_html__( 'Cream Blog Pro', 'cream-blog' ),
					'pro_text' => esc_html__( 'Upgrade to Pro', 'cream-blog' ),
					'pro_url'  => 'https://themebeez.com/themes/cream-blog/',
					'priority' => 1,
				)
			)
		);

		// Section - Banner.
		$wp_customize->add_section(
			'cream_blog_banner_options',
			array(
				'title'       => esc_html__( 'Banner/Slider', 'cream-blog' ),
				'description' => esc_html__( 'Set and select options to configure banner/slider section.', 'cream-blog' ),
				'panel'       => 'cream_blog_homepage_customization',
			)
		);

		// Section - Blog Posts.
		$wp_customize->add_section(
			'cream_blog_homepage_blog_posts_options',
			array(
				'title' => esc_html__( 'Blog Posts', 'cream-blog' ),
				'panel' => 'cream_blog_homepage_customization',
			)
		);

		// Homepage Sidebar.
		$wp_customize->add_section(
			'cream_blog_homepage_sidebar_options',
			array(
				'title' => esc_html__( 'Homepage Sidebar', 'cream-blog' ),
				'panel' => 'cream_blog_homepage_customization',
			)
		);

		// Header Options.
		$wp_customize->add_section(
			'cream_blog_header_options',
			array(
				'title' => esc_html__( 'Header', 'cream-blog' ),
				'panel' => 'cream_blog_advance_customization',
			)
		);

		// Footer Options.
		$wp_customize->add_section(
			'cream_blog_footer_options',
			array(
				'title' => esc_html__( 'Footer', 'cream-blog' ),
				'panel' => 'cream_blog_advance_customization',
			)
		);

		// Archive Page Options.
		$wp_customize->add_section(
			'cream_blog_archive_page_options',
			array(
				'title' => esc_html__( 'Archive Page', 'cream-blog' ),
				'panel' => 'cream_blog_advance_customization',
			)
		);

		// Search Page Options.
		$wp_customize->add_section(
			'cream_blog_search_page_options',
			array(
				'title' => esc_html__( 'Search Page', 'cream-blog' ),
				'panel' => 'cream_blog_advance_customization',
			)
		);

		// Post Single Options.
		$wp_customize->add_section(
			'cream_blog_single_post_options',
			array(
				'title' => esc_html__( 'Post Single', 'cream-blog' ),
				'panel' => 'cream_blog_advance_customization',
			)
		);

		// Page Single Options.
		$wp_customize->add_section(
			'cream_blog_single_page_options',
			array(
				'title' => esc_html__( 'Page Single', 'cream-blog' ),
				'panel' => 'cream_blog_advance_customization',
			)
		);

		// Post Meta Options.
		$wp_customize->add_section(
			'cream_blog_post_meta_options',
			array(
				'title' => esc_html__( 'Post Meta', 'cream-blog' ),
				'panel' => 'cream_blog_advance_customization',
			)
		);

		// Excerpt Options.
		$wp_customize->add_section(
			'cream_blog_post_excerpt_options',
			array(
				'title'       => esc_html__( 'Post Excerpt', 'cream-blog' ),
				'description' => esc_html__( 'Post Excerpt is the number of words of content which are displayed instead of full content. You can control the number of words to be displyed in this section.', 'cream-blog' ),
				'panel'       => 'cream_blog_advance_customization',
			)
		);

		// Social Links.
		$wp_customize->add_section(
			'cream_blog_social_links_options',
			array(
				'title' => esc_html__( 'Social Links', 'cream-blog' ),
				'panel' => 'cream_blog_advance_customization',
			)
		);

		// Breadcrumb Options.
		$wp_customize->add_section(
			'cream_blog_breadcrumb_options',
			array(
				'title' => esc_html__( 'Breadcrumb', 'cream-blog' ),
				'panel' => 'cream_blog_advance_customization',
			)
		);

		// Image Options.
		$wp_customize->add_section(
			'cream_blog_image_options',
			array(
				'title'       => esc_html__( 'Image', 'cream-blog' ),
				'description' => esc_html__( 'For site optimization and fast page load, enable image lazy load.', 'cream-blog' ),
				'panel'       => 'cream_blog_advance_customization',
			)
		);

		// Typography Options.
		$wp_customize->add_section(
			'cream_blog_typography_options',
			array(
				'title' => esc_html__( 'Typography', 'cream-blog' ),
				'panel' => 'cream_blog_advance_customization',
			)
		);

		// Other Options.
		$wp_customize->add_section(
			'cream_blog_miscellaneous_options',
			array(
				'title' => esc_html__( 'Miscellaneous', 'cream-blog' ),
				'panel' => 'cream_blog_advance_customization',
			)
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$wp_customize->add_section(
				'cream_blog_woocommerce_sidebar',
				array(
					'title' => esc_html__( 'WooCommerce Sidebar', 'cream-blog' ),
					'panel' => 'woocommerce',
				)
			);
		}
	}

	/**
	 * Sets up the customizer settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param object $wp_customize WP Customize Manager instance.
	 * @return void
	 */
	public function register_settings( $wp_customize ) {

		// Dropdown Taxonomies.
		require get_template_directory() . '/inc/customizer/functions/sanitize-callback.php';

		// Set the transport property of existing settings.
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		$defaults = cream_blog_get_default_theme_options();

		// Set Tagline Color.
		$wp_customize->add_setting(
			'cream_blog_tagline_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => $defaults['cream_blog_tagline_color'],
			)
		);

		// Set Theme Color.
		$wp_customize->add_setting(
			'cream_blog_theme_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => $defaults['cream_blog_theme_color'],
			)
		);

		// Set Content Link Color.
		$wp_customize->add_setting(
			'cream_blog_content_link_color',
			array(
				'sanitize_callback' => 'sanitize_hex_color',
				'default'           => $defaults['cream_blog_content_link_color'],
			)
		);

		// Enable Banner/Slider.
		$wp_customize->add_setting(
			'cream_blog_enable_banner',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_banner'],
			)
		);

		// Banner Cateogries.
		$wp_customize->add_setting(
			'cream_blog_banner_categories',
			array(
				'sanitize_callback' => 'cream_blog_sanitize_choices',
			)
		);

		// Banner Posts No.
		$wp_customize->add_setting(
			'cream_blog_banner_posts_no',
			array(
				'sanitize_callback' => 'cream_blog_sanitize_number',
				'default'           => $defaults['cream_blog_banner_posts_no'],
			)
		);

		// Select Banner/Slider Layout.
		$wp_customize->add_setting(
			'cream_blog_select_banner_layout',
			array(
				'sanitize_callback' => 'cream_blog_sanitize_select',
				'default'           => $defaults['cream_blog_select_banner_layout'],
			)
		);

		// Select Post List Layout For Blog Page.
		$wp_customize->add_setting(
			'cream_blog_select_blog_post_list_layout',
			array(
				'sanitize_callback' => 'cream_blog_sanitize_select',
				'default'           => $defaults['cream_blog_select_blog_post_list_layout'],
			)
		);

		// Homepage Sidebar Position.
		$wp_customize->add_setting(
			'cream_blog_homepage_sidebar',
			array(
				'sanitize_callback' => 'cream_blog_sanitize_select',
				'default'           => $defaults['cream_blog_homepage_sidebar'],
			)
		);

		// Enable Sticky Menu Bar.
		$wp_customize->add_setting(
			'cream_blog_enable_sticky_menu',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_sticky_menu'],
			)
		);

		// Enable Top Header.
		$wp_customize->add_setting(
			'cream_blog_enable_top_header',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_top_header'],
			)
		);

		// Enable Sidebar Toggle Button.
		$wp_customize->add_setting(
			'cream_blog_enable_sidebar_toggle_button',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_sidebar_toggle_button'],
			)
		);

		// Enable Search Button.
		$wp_customize->add_setting(
			'cream_blog_enable_search_button',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_search_button'],
			)
		);

		// Select Header Layout.
		$wp_customize->add_setting(
			'cream_blog_select_header_layout',
			array(
				'sanitize_callback' => 'cream_blog_sanitize_select',
				'default'           => $defaults['cream_blog_select_header_layout'],
			)
		);

		// Setting - Display Footer Widgets Area.
		$wp_customize->add_setting(
			'cream_blog_display_footer_widgets',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_display_footer_widgets'],
			)
		);

		// Enable Footer Social Links.
		$wp_customize->add_setting(
			'cream_blog_enable_footer_social_links',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_footer_social_links'],
			)
		);

		// Coyright & Credit Text.
		$wp_customize->add_setting(
			'cream_blog_copyright_credit',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => $defaults['cream_blog_copyright_credit'],
			)
		);

		// Enable Scroll Top Button.
		$wp_customize->add_setting(
			'cream_blog_enable_scroll_top_button',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_scroll_top_button'],
			)
		);

		// Select Sidebar Position For Archive Page.
		$wp_customize->add_setting(
			'cream_blog_select_archive_sidebar_position',
			array(
				'sanitize_callback' => 'cream_blog_sanitize_select',
				'default'           => $defaults['cream_blog_select_archive_sidebar_position'],
			)
		);

		// Setting - Hide Pages In Search Result.
		$wp_customize->add_setting(
			'cream_blog_hide_pages_on_search_result',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_hide_pages_on_search_result'],
			)
		);

		// Select Sidebar Position For Search Page.
		$wp_customize->add_setting(
			'cream_blog_select_search_sidebar_position',
			array(
				'sanitize_callback' => 'cream_blog_sanitize_select',
				'default'           => $defaults['cream_blog_select_search_sidebar_position'],
			)
		);

		// Display Featured Image On Post Single.
		$wp_customize->add_setting(
			'cream_blog_display_featured_image_post',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_display_featured_image_post'],
			)
		);

		// Enable Author Section.
		$wp_customize->add_setting(
			'cream_blog_enable_author_section',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_author_section'],
			)
		);

		// Enable Related Section.
		$wp_customize->add_setting(
			'cream_blog_enable_related_section',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_related_section'],
			)
		);

		// Related Section Title.
		$wp_customize->add_setting(
			'cream_blog_related_section_title',
			array(
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => $defaults['cream_blog_related_section_title'],
			)
		);

		// Related Posts According To.
		$wp_customize->add_setting(
			'cream_blog_related_posts_by',
			array(
				'sanitize_callback' => 'cream_blog_sanitize_select',
				'default'           => $defaults['cream_blog_related_posts_by'],
			)
		);

		// Related Section Posts No.
		$wp_customize->add_setting(
			'cream_blog_related_section_posts_number',
			array(
				'sanitize_callback' => 'cream_blog_sanitize_number',
				'default'           => $defaults['cream_blog_related_section_posts_number'],
			)
		);

		// Display Featured Image On Page Single.
		$wp_customize->add_setting(
			'cream_blog_display_featured_image_page',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_display_featured_image_page'],
			)
		);

		// Enable Author Meta.
		$wp_customize->add_setting(
			'cream_blog_enable_author_meta',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_author_meta'],
			)
		);

		// Enable Date Meta.
		$wp_customize->add_setting(
			'cream_blog_enable_date_meta',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_date_meta'],
			)
		);

		// Enable Comment Meta.
		$wp_customize->add_setting(
			'cream_blog_enable_comment_meta',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_comment_meta'],
			)
		);

		// Enable Tag Meta.
		$wp_customize->add_setting(
			'cream_blog_enable_tag_meta',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_tag_meta'],
			)
		);

		// Enable Category Meta.
		$wp_customize->add_setting(
			'cream_blog_enable_category_meta',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_category_meta'],
			)
		);

		// Excerpt Length.
		$wp_customize->add_setting(
			'cream_blog_post_excerpt_length',
			array(
				'sanitize_callback' => 'cream_blog_sanitize_number',
				'default'           => $defaults['cream_blog_post_excerpt_length'],
			)
		);

		// Social Link - Facebook.
		$wp_customize->add_setting(
			'cream_blog_facebook_link',
			array(
				'sanitize_callback' => 'esc_url_raw',
				'default'           => $defaults['cream_blog_facebook_link'],
			)
		);

		// Social Link - Twitter.
		$wp_customize->add_setting(
			'cream_blog_twitter_link',
			array(
				'sanitize_callback' => 'esc_url_raw',
				'default'           => $defaults['cream_blog_twitter_link'],
			)
		);

		// Social Link - Instagram.
		$wp_customize->add_setting(
			'cream_blog_instagram_link',
			array(
				'sanitize_callback' => 'esc_url_raw',
				'default'           => $defaults['cream_blog_instagram_link'],
			)
		);

		// Social Link - Youtube.
		$wp_customize->add_setting(
			'cream_blog_youtube_link',
			array(
				'sanitize_callback' => 'esc_url_raw',
				'default'           => $defaults['cream_blog_youtube_link'],
			)
		);

		// Social Link - Linkedin.
		$wp_customize->add_setting(
			'cream_blog_linkedin_link',
			array(
				'sanitize_callback' => 'esc_url_raw',
				'default'           => $defaults['cream_blog_linkedin_link'],
			)
		);

		// Social Link - Pintereset.
		$wp_customize->add_setting(
			'cream_blog_pinterest_link',
			array(
				'sanitize_callback' => 'esc_url_raw',
				'default'           => $defaults['cream_blog_pinterest_link'],
			)
		);

		// Enable Breadcrumb.
		$wp_customize->add_setting(
			'cream_blog_enable_breadcrumb',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_breadcrumb'],
			)
		);

		// Enable Sticky Sidebar.
		$wp_customize->add_setting(
			'cream_blog_enable_sticky_sidebar',
			array(
				'sanitize_callback' => 'wp_validate_boolean',
				'default'           => $defaults['cream_blog_enable_sticky_sidebar'],
			)
		);

		// Body font setting.
		$wp_customize->add_setting(
			'cream_blog_body_font',
			array(
				'default'           => $defaults['cream_blog_body_font'],
				'sanitize_callback' => 'cream_blog_sanitize_font',
			)
		);

		// Headings font setting.
		$wp_customize->add_setting(
			'cream_blog_headings_font',
			array(
				'default'           => $defaults['cream_blog_headings_font'],
				'sanitize_callback' => 'cream_blog_sanitize_font',
			)
		);

		if ( class_exists( 'WooCommerce' ) ) {
			// Select Sidebar Position For Woocomerce Pages.
			$wp_customize->add_setting(
				'cream_blog_select_woocommerce_sidebar_position',
				array(
					'sanitize_callback' => 'cream_blog_sanitize_select',
					'default'           => $defaults['cream_blog_select_woocommerce_sidebar_position'],
				)
			);
		}
	}

	/**
	 * Sets up the customizer controls.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param object $wp_customize WP Customize Manager instance.
	 * @return void
	 */
	public function register_controls( $wp_customize ) {

		// Multiple Select Dropdown Taxonomies.
		require get_template_directory() . '/inc/customizer/controls/class-cream-blog-multiple-select-dropdown-taxonomies.php';
		// Radio Image Control.
		require get_template_directory() . '/inc/customizer/controls/class-cream-blog-radio-image-control.php';
		// Typography Control.
		require get_template_directory() . '/inc/customizer/controls/typography/class-cream-blog-customize-typography-control.php';
		$wp_customize->register_section_type( 'Cream_Blog_Customize_Typography_Control' );

		// Control - Tagline Color.
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cream_blog_tagline_color',
				array(
					'label'   => esc_html__( 'Tagline Color', 'cream-blog' ),
					'section' => 'title_tagline',
				)
			)
		);

		// Set Theme Color.
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cream_blog_theme_color',
				array(
					'label'   => esc_html__( 'Theme Color', 'cream-blog' ),
					'section' => 'colors',
				)
			)
		);

		// Content's Link Color.
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'cream_blog_content_link_color',
				array(
					'label'   => esc_html__( 'Content&rsquo;s Link Color', 'cream-blog' ),
					'section' => 'colors',
				)
			)
		);

		// Enable Banner/Slider.
		$wp_customize->add_control(
			'cream_blog_enable_banner',
			array(
				'label'   => esc_html__( 'Enable Banner/Slider', 'cream-blog' ),
				'section' => 'cream_blog_banner_options',
				'type'    => 'checkbox',
			)
		);

		// Banner/Slider Cateogries.
		$wp_customize->add_control(
			new Cream_Blog_Multiple_Select_Dropdown_Taxonomies(
				$wp_customize,
				'cream_blog_banner_categories',
				array(
					'label'           => esc_html__( 'Banner/Slider Post Categories', 'cream-blog' ),
					'section'         => 'cream_blog_banner_options',
					'choices'         => $this->get_category_taxonomies(),
					'active_callback' => 'cream_blog_is_banner_active',
				)
			)
		);

		// Banner/Slider Posts No.
		$wp_customize->add_control(
			'cream_blog_banner_posts_no',
			array(
				'label'           => esc_html__( 'Banner/Slider Posts Number', 'cream-blog' ),
				'section'         => 'cream_blog_banner_options',
				'type'            => 'number',
				'active_callback' => 'cream_blog_is_banner_active',
			)
		);

		// Select Banner/Slider Layout.
		$wp_customize->add_control(
			new Cream_Blog_Radio_Image_Control(
				$wp_customize,
				'cream_blog_select_banner_layout',
				array(
					'label'           => esc_html__( 'Select Banner/Slider Layout', 'cream-blog' ),
					'section'         => 'cream_blog_banner_options',
					'type'            => 'radio',
					'choices'         => $this->get_banner_layouts(),
					'active_callback' => 'cream_blog_is_banner_active',
				)
			)
		);

		// Select Post List Layout For Blog Page.
		$wp_customize->add_control(
			new Cream_Blog_Radio_Image_Control(
				$wp_customize,
				'cream_blog_select_blog_post_list_layout',
				array(
					'label'   => esc_html__( 'Select Post Listing Layout', 'cream-blog' ),
					'section' => 'cream_blog_homepage_blog_posts_options',
					'type'    => 'select',
					'choices' => $this->get_post_listing_layout(),
				)
			)
		);

		// Homepage Sidebar Position.
		$wp_customize->add_control(
			new Cream_Blog_Radio_Image_Control(
				$wp_customize,
				'cream_blog_homepage_sidebar',
				array(
					'label'   => esc_html__( 'Sidebar Position', 'cream-blog' ),
					'section' => 'cream_blog_homepage_sidebar_options',
					'type'    => 'radio',
					'choices' => $this->get_sidebar_position(),
				)
			)
		);

		// Select Header Layout.
		$wp_customize->add_control(
			new Cream_Blog_Radio_Image_Control(
				$wp_customize,
				'cream_blog_select_header_layout',
				array(
					'label'   => esc_html__( 'Select Header Layout', 'cream-blog' ),
					'section' => 'cream_blog_header_options',
					'type'    => 'select',
					'choices' => $this->get_header_layout(),
				)
			)
		);

		// Enable Top Header.
		$wp_customize->add_control(
			'cream_blog_enable_top_header',
			array(
				'label'           => esc_html__( 'Enable Top Header', 'cream-blog' ),
				'section'         => 'cream_blog_header_options',
				'type'            => 'checkbox',
				'active_callback' => 'cream_blog_is_header_layout_2_active',
			)
		);

		// Enable Sidebar Toggle Button.
		$wp_customize->add_control(
			'cream_blog_enable_sidebar_toggle_button',
			array(
				'label'   => esc_html__( 'Enable Sidebar Toggle Button', 'cream-blog' ),
				'section' => 'cream_blog_header_options',
				'type'    => 'checkbox',
			)
		);

		// Enable Search Button.
		$wp_customize->add_control(
			'cream_blog_enable_search_button',
			array(
				'label'   => esc_html__( 'Enable Search Button', 'cream-blog' ),
				'section' => 'cream_blog_header_options',
				'type'    => 'checkbox',
			)
		);

		// Enable Sticky Menu Bar.
		$wp_customize->add_control(
			'cream_blog_enable_sticky_menu',
			array(
				'label'   => esc_html__( 'Enable Sticky Menu Bar', 'cream-blog' ),
				'section' => 'cream_blog_header_options',
				'type'    => 'checkbox',
			)
		);

		// Control - Display Footer Widgets.
		$wp_customize->add_control(
			'cream_blog_display_footer_widgets',
			array(
				'label'   => esc_html__( 'Display Footer Widgets Area', 'cream-blog' ),
				'section' => 'cream_blog_footer_options',
				'type'    => 'checkbox',
			)
		);

		// Enable Footer Social Links.
		$wp_customize->add_control(
			'cream_blog_enable_footer_social_links',
			array(
				'label'   => esc_html__( 'Enable Footer Social Links', 'cream-blog' ),
				'section' => 'cream_blog_footer_options',
				'type'    => 'checkbox',
			)
		);

		// Copyright & Credit.
		$wp_customize->add_control(
			'cream_blog_copyright_credit',
			array(
				'label'   => esc_html__( 'Copyright & Credit Text', 'cream-blog' ),
				'section' => 'cream_blog_footer_options',
				'type'    => 'text',
			)
		);

		// Enable Scroll Top Button.
		$wp_customize->add_control(
			'cream_blog_enable_scroll_top_button',
			array(
				'label'   => esc_html__( 'Enable Scroll Top Button', 'cream-blog' ),
				'section' => 'cream_blog_footer_options',
				'type'    => 'checkbox',
			)
		);

		// Select Sidebar Position For Archive Page.
		$wp_customize->add_control(
			new Cream_Blog_Radio_Image_Control(
				$wp_customize,
				'cream_blog_select_archive_sidebar_position',
				array(
					'label'   => esc_html__( 'Select Sidebar Position', 'cream-blog' ),
					'section' => 'cream_blog_archive_page_options',
					'type'    => 'select',
					'choices' => $this->get_sidebar_position(),
				)
			)
		);

		// Control - Hide Pages In Search Result.
		$wp_customize->add_control(
			'cream_blog_hide_pages_on_search_result',
			array(
				'label'   => esc_html__( 'Hide Pages In Search Result', 'cream-blog' ),
				'section' => 'cream_blog_search_page_options',
				'type'    => 'checkbox',
			)
		);

		// Select Sidebar Position For Search Page.
		$wp_customize->add_control(
			new Cream_Blog_Radio_Image_Control(
				$wp_customize,
				'cream_blog_select_search_sidebar_position',
				array(
					'label'   => esc_html__( 'Select Sidebar Position', 'cream-blog' ),
					'section' => 'cream_blog_search_page_options',
					'type'    => 'select',
					'choices' => $this->get_sidebar_position(),
				)
			)
		);

		// Display Featured Image On Post Single.
		$wp_customize->add_control(
			'cream_blog_display_featured_image_post',
			array(
				'label'   => esc_html__( 'Display Featured Image', 'cream-blog' ),
				'section' => 'cream_blog_single_post_options',
				'type'    => 'checkbox',
			)
		);

		// Enable Author Section.
		$wp_customize->add_control(
			'cream_blog_enable_author_section',
			array(
				'label'   => esc_html__( 'Enable Author Section', 'cream-blog' ),
				'section' => 'cream_blog_single_post_options',
				'type'    => 'checkbox',
			)
		);

		// Enable Related Section.
		$wp_customize->add_control(
			'cream_blog_enable_related_section',
			array(
				'label'   => esc_html__( 'Enable Related Posts Section', 'cream-blog' ),
				'section' => 'cream_blog_single_post_options',
				'type'    => 'checkbox',
			)
		);

		// Related Section Title.
		$wp_customize->add_control(
			'cream_blog_related_section_title',
			array(
				'label'           => esc_html__( 'Related Posts Section Title', 'cream-blog' ),
				'section'         => 'cream_blog_single_post_options',
				'type'            => 'text',
				'active_callback' => 'cream_blog_is_active_related_post',
			)
		);

		// Related Posts According To.
		$wp_customize->add_control(
			'cream_blog_related_posts_by',
			array(
				'label'           => esc_html__( 'Display Related Posts By', 'cream-blog' ),
				'section'         => 'cream_blog_single_post_options',
				'type'            => 'select',
				'choices'         => array(
					'category' => esc_html__( 'Category', 'cream-blog' ),
					'tag'      => esc_html__( 'Tag', 'cream-blog' ),
					'both_or'  => esc_html__( 'Category Or Tag', 'cream-blog' ),
					'both_and' => esc_html__( 'Category And Tag', 'cream-blog' ),
				),
				'active_callback' => 'cream_blog_is_active_related_post',
			)
		);

		// Related Section Posts No.
		$wp_customize->add_control(
			'cream_blog_related_section_posts_number',
			array(
				'label'           => esc_html__( 'Related Section Posts Number', 'cream-blog' ),
				'section'         => 'cream_blog_single_post_options',
				'type'            => 'number',
				'active_callback' => 'cream_blog_is_active_related_post',
			)
		);

		// Display Featured Image On Page Single.
		$wp_customize->add_control(
			'cream_blog_display_featured_image_page',
			array(
				'label'   => esc_html__( 'Display Featured Image', 'cream-blog' ),
				'section' => 'cream_blog_single_page_options',
				'type'    => 'checkbox',
			)
		);

		// Enable Author Meta.
		$wp_customize->add_control(
			'cream_blog_enable_author_meta',
			array(
				'label'   => esc_html__( 'Enable Post Author Meta', 'cream-blog' ),
				'section' => 'cream_blog_post_meta_options',
				'type'    => 'checkbox',
			)
		);

		// Enable Date Meta.
		$wp_customize->add_control(
			'cream_blog_enable_date_meta',
			array(
				'label'   => esc_html__( 'Enable Posted Date Meta', 'cream-blog' ),
				'section' => 'cream_blog_post_meta_options',
				'type'    => 'checkbox',
			)
		);

		// Enable Comment Meta.
		$wp_customize->add_control(
			'cream_blog_enable_comment_meta',
			array(
				'label'   => esc_html__( 'Enable Post Comments Number Meta', 'cream-blog' ),
				'section' => 'cream_blog_post_meta_options',
				'type'    => 'checkbox',
			)
		);

		// Enable Category Meta.
		$wp_customize->add_control(
			'cream_blog_enable_category_meta',
			array(
				'label'   => esc_html__( 'Enable Post Categories Meta', 'cream-blog' ),
				'section' => 'cream_blog_post_meta_options',
				'type'    => 'checkbox',
			)
		);

		// Enable Tag Meta.
		$wp_customize->add_control(
			'cream_blog_enable_tag_meta',
			array(
				'label'   => esc_html__( 'Enable Post Tags Meta', 'cream-blog' ),
				'section' => 'cream_blog_post_meta_options',
				'type'    => 'checkbox',
			)
		);

		// Excerpt Length.
		$wp_customize->add_control(
			'cream_blog_post_excerpt_length',
			array(
				'label'   => esc_html__( 'Excerpt Length', 'cream-blog' ),
				'section' => 'cream_blog_post_excerpt_options',
				'type'    => 'number',
			)
		);

		// Social Links - Facebook.
		$wp_customize->add_control(
			'cream_blog_facebook_link',
			array(
				'label'   => esc_html__( 'Facebook Link', 'cream-blog' ),
				'section' => 'cream_blog_social_links_options',
				'type'    => 'url',
			)
		);

		// Social Links - Twitter.
		$wp_customize->add_control(
			'cream_blog_twitter_link',
			array(
				'label'   => esc_html__( 'Twitter Link', 'cream-blog' ),
				'section' => 'cream_blog_social_links_options',
				'type'    => 'url',
			)
		);

		// Social Links - Instagram.
		$wp_customize->add_control(
			'cream_blog_instagram_link',
			array(
				'label'   => esc_html__( 'Instagram Link', 'cream-blog' ),
				'section' => 'cream_blog_social_links_options',
				'type'    => 'url',
			)
		);

		// Social Links - Youtube.
		$wp_customize->add_control(
			'cream_blog_youtube_link',
			array(
				'label'   => esc_html__( 'Youtube Link', 'cream-blog' ),
				'section' => 'cream_blog_social_links_options',
				'type'    => 'url',
			)
		);

		// Social Links - Linkedin.
		$wp_customize->add_control(
			'cream_blog_linkedin_link',
			array(
				'label'   => esc_html__( 'Linkedin Link', 'cream-blog' ),
				'section' => 'cream_blog_social_links_options',
				'type'    => 'url',
			)
		);

		// Social Links - Pinterest.
		$wp_customize->add_control(
			'cream_blog_pinterest_link',
			array(
				'label'   => esc_html__( 'Pinterest Link', 'cream-blog' ),
				'section' => 'cream_blog_social_links_options',
				'type'    => 'url',
			)
		);

		// Enable Breadcrumb.
		$wp_customize->add_control(
			'cream_blog_enable_breadcrumb',
			array(
				'label'   => esc_html__( 'Enable Breadcrumb', 'cream-blog' ),
				'section' => 'cream_blog_breadcrumb_options',
				'type'    => 'checkbox',
			)
		);

		// Enable Sticky Sidebar.
		$wp_customize->add_control(
			'cream_blog_enable_sticky_sidebar',
			array(
				'label'   => esc_html__( 'Enable Sticky Sidebar', 'cream-blog' ),
				'section' => 'cream_blog_miscellaneous_options',
				'type'    => 'checkbox',
			)
		);

		// Body font control.
		$wp_customize->add_control(
			new Cream_Blog_Customize_Typography_Control(
				$wp_customize,
				'cream_blog_body_font',
				array(
					'label'   => esc_html__( 'Body Font', 'cream-blog' ),
					'section' => 'cream_blog_typography_options',
				)
			)
		);

		// Headings font control.
		$wp_customize->add_control(
			new Cream_Blog_Customize_Typography_Control(
				$wp_customize,
				'cream_blog_headings_font',
				array(
					'label'   => esc_html__( 'Headings Font', 'cream-blog' ),
					'section' => 'cream_blog_typography_options',
				)
			)
		);

		if ( class_exists( 'WooCommerce' ) ) {

			// Select Sidebar Position For Archive Page.
			$wp_customize->add_control(
				new Cream_Blog_Radio_Image_Control(
					$wp_customize,
					'cream_blog_select_woocommerce_sidebar_position',
					array(
						'label'   => esc_html__( 'Select Sidebar Position', 'cream-blog' ),
						'section' => 'cream_blog_woocommerce_sidebar',
						'type'    => 'select',
						'choices' => $this->get_sidebar_position(),
					)
				)
			);
		}
	}

	/**
	 * Sets up the customizer partials.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param object $wp_customize WP Customize Manager instance.
	 * @return void
	 */
	public function add_partials( $wp_customize ) {

		if ( isset( $wp_customize->selective_refresh ) ) {

			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.site-title a',
					'render_callback' => array( $this, 'customize_partial_blogname' ),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.site-description',
					'render_callback' => array( $this, 'customize_partial_blogdescription' ),
				)
			);
		}
	}

	/**
	 * Render the site title for the selective refresh partial.
	 *
	 * @return void
	 */
	public function customize_partial_blogname() {
		bloginfo( 'name' );
	}

	/**
	 * Render the site tagline for the selective refresh partial.
	 *
	 * @return void
	 */
	public function customize_partial_blogdescription() {
		bloginfo( 'description' );
	}

	/**
	 * Loads theme customizer JavaScript.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function customize_preview_js() {

		wp_enqueue_script(
			'cream-blog-customizer',
			get_template_directory_uri() . '/admin/js/customizer.js',
			array( 'customize-preview' ),
			CREAM_BLOG_VERSION,
			true
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function customizer_scripts() {

		wp_enqueue_style(
			'cream-blog-upgrade',
			get_template_directory_uri() . '/inc/upgrade-to-pro/upgrade.css',
			array(),
			CREAM_BLOG_VERSION,
			'all'
		);

		wp_enqueue_style(
			'chosen',
			get_template_directory_uri() . '/admin/css/chosen.css',
			array(),
			'1.8.3',
			'all'
		);

		wp_enqueue_style(
			'cream-blog-customizer-style',
			get_template_directory_uri() . '/admin/css/customizer-style.css',
			array(),
			CREAM_BLOG_VERSION,
			'all'
		);

		wp_enqueue_script(
			'cream-blog-upgrade',
			get_template_directory_uri() . '/inc/upgrade-to-pro/upgrade.js',
			array( 'jquery' ),
			CREAM_BLOG_VERSION,
			true
		);

		wp_enqueue_script(
			'chosen',
			get_template_directory_uri() . '/admin/js/chosen.js',
			array( 'jquery' ),
			'1.8.3',
			true
		);

		wp_enqueue_script(
			'cream-blog-customizer-script',
			get_template_directory_uri() . '/admin/js/customizer-script.js',
			array( 'jquery' ),
			CREAM_BLOG_VERSION,
			true
		);
	}

	/**
	 * Function to load choices for controls.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function get_category_taxonomies() {

		$taxonomy = 'category';
		$terms    = get_terms( $taxonomy );
		$blog_cat = array();

		foreach ( $terms as $term ) {
			$blog_cat[ $term->term_id ] = $term->name;
		}

		return $blog_cat;
	}

	/**
	 * Function to load layout choices for header.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_header_layout() {

		$header_layouts = array(
			'header_1' => get_template_directory_uri() . '/admin/images/header-placeholders/header_1.png',
			'header_2' => get_template_directory_uri() . '/admin/images/header-placeholders/header_2.png',
		);
		return $header_layouts;
	}

	/**
	 * Function to load layout choices for banner/slider.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_banner_layouts() {

		$banner_layouts = array(
			'banner_1' => get_template_directory_uri() . '/admin/images/banner-placeholders/banner_1.png',
			'banner_2' => get_template_directory_uri() . '/admin/images/banner-placeholders/banner_2.png',
		);
		return $banner_layouts;
	}

	/**
	 * Function to load layout choices for post listing.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_post_listing_layout() {

		$list_layouts = array(
			'list_1' => get_template_directory_uri() . '/admin/images/post-listing-placeholders/list_1.png',
			'list_2' => get_template_directory_uri() . '/admin/images/post-listing-placeholders/list_2.png',
			'list_3' => get_template_directory_uri() . '/admin/images/post-listing-placeholders/list_3.png',
		);
		return $list_layouts;
	}

	/**
	 * Function to load layout choices for sidebar.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_sidebar_position() {

		$sidebar_positions = array(
			'left'  => get_template_directory_uri() . '/admin/images/sidebar-placeholders/sidebar_left.png',
			'right' => get_template_directory_uri() . '/admin/images/sidebar-placeholders/sidebar_right.png',
			'none'  => get_template_directory_uri() . '/admin/images/sidebar-placeholders/sidebar_none.png',
		);
		return $sidebar_positions;
	}

	/**
	 * Function to load dynamic styles.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function dynamic_style() {

		$show_search_icon          = cream_blog_get_option( 'cream_blog_enable_search_button' );
		$show_toggled_sidebar_icon = cream_blog_get_option( 'cream_blog_enable_sidebar_toggle_button' );
		$show_scroll_top_icon      = cream_blog_get_option( 'cream_blog_enable_scroll_top_button' );
		$theme_color               = cream_blog_get_option( 'cream_blog_theme_color' );
		$tagline_color             = cream_blog_get_option( 'cream_blog_tagline_color' );
		$content_link_color        = cream_blog_get_option( 'cream_blog_content_link_color' );

		$body_font = cream_blog_get_option( 'cream_blog_body_font' );
		$body_font = json_decode( $body_font, true );

		$headings_font = cream_blog_get_option( 'cream_blog_headings_font' );
		$headings_font = json_decode( $headings_font, true );

		$css = '<style>';

		// Dynamic CSS for body typography.
		$css .= 'body, .cb-entry, .widget .widget-title h3, .cb-post-widget .post-title h4 {';

		if (
			isset( $body_font['font_family'] ) &&
			! empty( $body_font['font_family'] )
		) {
			$css .= 'font-family: ' . esc_attr( $body_font['font_family'] ) . ';';
		}

		if (
			isset( $body_font['font_weight'] ) &&
			! empty( $body_font['font_weight'] )
		) {
			$css .= 'font-weight: ' . esc_attr( $body_font['font_weight'] ) . ';';
		}

		$css .= '}';

		// Dynamic CSS for headings typography.
		$css .= 'h1, h2, h3, h4, h5, h6 {';

		if (
			isset( $headings_font['font_family'] ) &&
			! empty( $headings_font['font_family'] )
		) {
			$css .= 'font-family: ' . esc_attr( $headings_font['font_family'] ) . ';';
		}

		if (
			isset( $headings_font['font_weight'] ) &&
			! empty( $headings_font['font_weight'] )
		) {
			$css .= 'font-weight: ' . esc_attr( $headings_font['font_weight'] ) . ';';
		}

		$css .= '}';

		if ( $tagline_color ) {
			$css .= '.header-style-3 .site-identity .site-description, .header-style-5 .site-identity .site-description {';
			$css .= "color: {$tagline_color};";
			$css .= '}';
		}

		if ( false === $show_toggled_sidebar_icon || 0 === $show_toggled_sidebar_icon ) {
			$css .= '#canvas-toggle {';
			$css .= 'display: none;';
			$css .= '}';
		}

		if ( false === $show_search_icon || 0 === $show_search_icon ) {
			$css .= '#search-toggle {';
			$css .= 'display: none;';
			$css .= '}';
		}

		if ( has_header_image() ) {
			$css .= '.header-style-3 .cb-header-top {';
			$css .= 'background-image: url(' . esc_url( get_header_image() ) . ');';
			$css .= '}';
		}

		if ( $theme_color ) {
			$css .= 'body .edit-link a,
				.metas-list li span, 
				.metas-list li a,
				.widget_rss ul li a,
				.cb-topfooter .social-icons-list li a,
				.breadcrumb-style-2 ul li.trail-end span,
				.cb-bottomfooter a, 
				.header-style-5 .social-icons li a,
				.secondary-nav ul li a,
				.woocommerce ul.products li.product .price,
				.woocommerce div.product p.price ins, 
				.woocommerce div.product span.price ins, 
				.woocommerce div.product p.price, 
				.woocommerce div.product span.price,
				.woocommerce-form-coupon-toggle .woocommerce-info a,
				.woocommerce-message:before, 
				.woocommerce-info:before, 
				.woocommerce-error:before,
				.woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active a,
				.star-rating span:before,
				.section-title h2:after, 
				form.mc4wp-form-theme .cb-newsleter input[type="submit"],
				.metas-list li span, 
				.metas-list li a,
				.cb-bottomfooter a,
				.author-box .author-name h3,
				.search-page-entry .page-title h1 span, 
				.search-page-entry .page-title h2 span, 
				.search-page-entry .page-title h3 span,
				.page-links .post-page-numbers.current {';
			$css .= "color: {$theme_color};";
			$css .= '}';

			$css .= '#toTop,
				button, 
				.button, 
				.btn-general, 
				input[type="button"], 
				input[type="reset"], 
				input[type="submit"],
				.post-tags a,
				body .edit-link a:after,
				.header-style-5 .cb-navigation-main-outer,
				.header-style-3 .cb-navigation-main-outer,
				.is-sticky #cb-stickhead,
				ul.post-categories li a,
				.widget .widget-title h3,
				.calendar_wrap caption,
				#header-search input[type="submit"], 
				.search-box input[type="submit"], 
				.widget_product_search input[type="submit"], 
				.widget_search input[type="submit"],
				.cb-pagination .pagi-style-1 .nav-links span.current, 
				.cb-pagination .pagi-style-2 .nav-links span.current,
				.metas-list li.posted-date::before,
				.woocommerce #respond input#submit, 
				.woocommerce a.button, 
				.woocommerce button.button, 
				.woocommerce input.button, 
				.woocommerce .wc-forward, 
				.woocommerce a.added_to_cart, 
				.woocommerce #respond input#submit.alt, 
				.woocommerce a.button.alt, 
				.woocommerce button.button.alt, 
				.woocommerce input.button.alt,
				.woocommerce nav.woocommerce-pagination ul li span.current,
				.widget_product_search button,
				.cb-author-widget .author-bio a:after,
				form.mc4wp-form-theme .cb-newsleter input[type="submit"],
				.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-range {';
			$css .= "background-color: {$theme_color};";
			$css .= '}';

			$css .= '#header-search, 
				.search-box form, 
				.woocommerce-error, 
				.woocommerce-info, 
				.woocommerce-message {';
			$css .= "border-top-color: {$theme_color};";
			$css .= '}';

			$css .= '.page-links .post-page-numbers,
				.cb-pagination .pagi-style-1 .nav-links span.current,
				form.mc4wp-form-theme .cb-newsleter input[type="submit"] {';
			$css .= "border-color: {$theme_color};";
			$css .= '}';

			$css .= '.section-title {';
			$css .= "border-left-color: {$theme_color};";
			$css .= '}';
		}

		if ( $content_link_color ) {
			$css .= '.cb-editor-contents-entry a {';
			$css .= "color: {$content_link_color};";
			$css .= '}';
		}

		$css .= '</style>';

		echo $this->minify_css( $css ); // phpcs:ignore
	}

	/**
	 * Simple minification of CSS codes.
	 *
	 * @since 2.1.4
	 *
	 * @param string $css CSS codes.
	 * @return string
	 */
	public function minify_css( $css ) {

		$css = preg_replace( '/\s+/', ' ', $css );
		$css = preg_replace( '/\/\*[^\!](.*?)\*\//', '', $css );
		$css = preg_replace( '/(,|:|;|\{|}) /', '$1', $css );
		$css = preg_replace( '/ (,|;|\{|})/', '$1', $css );
		$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );
		$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

		return trim( (string) $css );
	}
}
