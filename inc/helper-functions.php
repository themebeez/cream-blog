<?php
/**
 * Helper functions for this theme.
 *
 * @package Cream_Blog
 */

if ( ! function_exists( 'cream_blog_get_option' ) ) {
	/**
	 * Get theme option.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed Option value.
	 */
	function cream_blog_get_option( $key ) {

		if ( empty( $key ) ) {
			return;
		}

		$value = '';

		$default = cream_blog_get_default_theme_options();

		$default_value = null;

		if ( is_array( $default ) && isset( $default[ $key ] ) ) {
			$default_value = $default[ $key ];
		}

		if ( null !== $default_value ) {
			$value = get_theme_mod( $key, $default_value );
		} else {
			$value = get_theme_mod( $key );
		}

		return $value;
	}
}


if ( ! function_exists( 'cream_blog_get_default_theme_options' ) ) {
	/**
	 * Get default theme options.
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function cream_blog_get_default_theme_options() {

		$defaults = array(
			'cream_blog_theme_color'                     => '#fb5975',
			'cream_blog_enable_banner'                   => false,
			'cream_blog_banner_posts_no'                 => 5,
			'cream_blog_select_banner_layout'            => 'banner_2',
			'cream_blog_select_blog_post_list_layout'    => 'list_3',
			'cream_blog_homepage_sidebar'                => 'right',
			'cream_blog_enable_sticky_menu'              => false,
			'cream_blog_enable_top_header'               => true,
			'cream_blog_enable_sidebar_toggle_button'    => false,
			'cream_blog_enable_search_button'            => false,
			'cream_blog_select_header_layout'            => 'header_1',
			'cream_blog_enable_footer_social_links'      => true,
			'cream_blog_copyright_credit'                => '',
			'cream_blog_enable_scroll_top_button'        => true,
			'cream_blog_select_archive_sidebar_position' => 'right',
			'cream_blog_select_search_sidebar_position'  => 'right',
			'cream_blog_display_featured_image_post'     => true,
			'cream_blog_enable_author_section'           => false,
			'cream_blog_enable_related_section'          => false,
			'cream_blog_related_section_title'           => '',
			'cream_blog_related_section_posts_number'    => 6,
			'cream_blog_display_featured_image_page'     => true,
			'cream_blog_enable_category_meta'            => true,
			'cream_blog_enable_date_meta'                => true,
			'cream_blog_enable_author_meta'              => true,
			'cream_blog_enable_tag_meta'                 => true,
			'cream_blog_enable_comment_meta'             => true,
			'cream_blog_post_excerpt_length'             => 25,
			'cream_blog_facebook_link'                   => '',
			'cream_blog_twitter_link'                    => '',
			'cream_blog_instagram_link'                  => '',
			'cream_blog_youtube_link'                    => '',
			'cream_blog_google_plus_link'                => '',
			'cream_blog_linkedin_link'                   => '',
			'cream_blog_pinterest_link'                  => '',
			'cream_blog_enable_breadcrumb'               => true,
			'cream_blog_enable_sticky_sidebar'           => true,
			'cream_blog_tagline_color'                   => '#000',
			'cream_blog_hide_pages_on_search_result'     => false,
			'cream_blog_display_footer_widgets'          => true,
			'cream_blog_content_link_color'              => '#fb5975',
			'cream_blog_related_posts_by'                => 'category',
			'cream_blog_body_font'                       => wp_json_encode(
				array(
					'source'        => 'google',
					'font_family'   => 'DM Sans',
					'font_variants' => '400,400italic',
					'font_url'      => 'DM+Sans:ital@0;1',
					'font_weight'   => '400',
				)
			),
			'cream_blog_headings_font'                   => wp_json_encode(
				array(
					'source'        => 'google',
					'font_family'   => 'Inter',
					'font_variants' => '700',
					'font_url'      => 'Inter:wght@700',
					'font_weight'   => '700',
				)
			),
		);

		if ( class_exists( 'WooCommerce' ) ) {

			$defaults['cream_blog_select_woocommerce_sidebar_position'] = 'right';
		}

		return $defaults;

	}
}

if ( ! function_exists( 'cream_blog_recursive_parse_args' ) ) {
	/**
	 * Recursively merge two arrays.
	 *
	 * @since 2.1.4
	 *
	 * @param array $args Target array.
	 * @param array $defaults Default array.
	 */
	function cream_blog_recursive_parse_args( $args, $defaults ) {

		$new_args = (array) $defaults;

		foreach ( $args as $key => $value ) {

			if ( is_array( $value ) && isset( $new_args[ $key ] ) ) {

				$new_args[ $key ] = cream_blog_recursive_parse_args( $value, $new_args[ $key ] );
			} else {

				$new_args[ $key ] = $value;
			}
		}

		return $new_args;
	}
}


/**
 * Funtion To Get Google Fonts
 */
if ( ! function_exists( 'cream_blog_fonts_url' ) ) {
	/**
	 * Return Font's URL.
	 *
	 * @since 1.0.0
	 * @return string Fonts URL.
	 */
	function cream_blog_fonts_url() {

		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'DM Sans font: on or off', 'cream-blog' ) ) {

			$fonts[] = 'DM+Sans:400,400i,700,700i';
		}

		/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */

		if ( 'off' !== _x( 'on', 'Inter font: on or off', 'cream-blog' ) ) {

			$fonts[] = 'Inter:400,500,600,700';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family' => urlencode( implode( '|', $fonts ) ), // phpcs:ignore
					'subset' => urlencode( $subsets ), // phpcs:ignore
				),
				'//fonts.googleapis.com/css'
			);
		}

		return $fonts_url;
	}
}


if ( ! function_exists( 'cream_blog_sidebar_position' ) ) {
	/**
	 * Return position of sidebar.
	 *
	 * @since 1.0.0
	 *
	 * @return string $sidebar_position Sidebar position.
	 */
	function cream_blog_sidebar_position() {

		$sidebar_position = '';

		if ( class_exists( 'WooCommerce' ) ) {

			if (
				is_shop() ||
				is_product() ||
				is_cart() ||
				is_checkout() ||
				is_account_page() ||
				is_product_category() ||
				is_product_tag()
			) {

				$sidebar_position = cream_blog_get_option( 'cream_blog_select_woocommerce_sidebar_position' );
			} else {

				if ( is_home() ) {
					$sidebar_position = cream_blog_get_option( 'cream_blog_homepage_sidebar' );
				}

				if ( is_archive() ) {
					$sidebar_position = cream_blog_get_option( 'cream_blog_select_archive_sidebar_position' );
				}

				if ( is_search() ) {
					$sidebar_position = cream_blog_get_option( 'cream_blog_select_search_sidebar_position' );
				}

				if ( is_single() || is_page() ) {

					$sidebar_position = get_post_meta( get_the_ID(), 'cream_blog_sidebar_position', true );

					if ( empty( $sidebar_position ) ) {

						$sidebar_position = 'right';
					}
				}
			}
		} else {

			if ( is_home() ) {
				$sidebar_position = cream_blog_get_option( 'cream_blog_homepage_sidebar' );
			}

			if ( is_archive() ) {
				$sidebar_position = cream_blog_get_option( 'cream_blog_select_archive_sidebar_position' );
			}

			if ( is_search() ) {
				$sidebar_position = cream_blog_get_option( 'cream_blog_select_search_sidebar_position' );
			}

			if ( is_single() || is_page() ) {

				$sidebar_position = get_post_meta( get_the_ID(), 'cream_blog_sidebar_position', true );

				if ( empty( $sidebar_position ) ) {

					$sidebar_position = 'right';
				}
			}
		}

		return $sidebar_position;
	}
}


if ( ! function_exists( 'cream_blog_check_sticky_sidebar' ) ) {
	/**
	 * Checks if sticky sidebar is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean
	 */
	function cream_blog_check_sticky_sidebar() {

		$is_sticky_sidebar = cream_blog_get_option( 'cream_blog_enable_sticky_sidebar' );

		if ( true === $is_sticky_sidebar || 1 === $is_sticky_sidebar ) {
			return true;
		} else {
			return false;
		}
	}
}


if ( ! function_exists( 'cream_blog_main_query_filter' ) ) {
	/**
	 * Modifies query variable object to exclude pages from search result.
	 *
	 * @since 1.0.0
	 *
	 * @param object $query The WP_Query instance.
	 */
	function cream_blog_main_query_filter( $query ) {

		if ( is_admin() ) {

			return $query;
		}

		$exclude_pages = cream_blog_get_option( 'cream_blog_hide_pages_on_search_result' );

		if (
			$query->is_search &&
			(
				true === $exclude_pages ||
				1 === $exclude_pages
			)
		) {

			$query->set( 'post_type', 'post' );
		}

		return $query;
	}

	add_filter( 'pre_get_posts', 'cream_blog_main_query_filter' );
}



if ( ! function_exists( 'cream_blog_recommended_plugins' ) ) {
	/**
	 * Recommend plugins.
	 *
	 * @since 1.0.0
	 */
	function cream_blog_recommended_plugins() {

		$plugins = array(
			array(
				'name'     => 'Themebeez Toolkit',
				'slug'     => 'themebeez-toolkit',
				'required' => false,
			),
		);

		tgmpa( $plugins );
	}

	add_action( 'tgmpa_register', 'cream_blog_recommended_plugins' );
}
