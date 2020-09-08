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
		}
		else {
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

    	$defaults = array();

        $defaults['cream_blog_theme_color'] = '#fb5975';

    	$defaults['cream_blog_enable_banner'] = false;
    	$defaults['cream_blog_banner_posts_no'] = 5;
    	$defaults['cream_blog_select_banner_layout'] = 'banner_2';

        $defaults['cream_blog_select_blog_post_list_layout'] = 'list_3';
    	$defaults['cream_blog_homepage_sidebar'] = 'right';

        $defaults['cream_blog_enable_sticky_menu'] = false;
    	$defaults['cream_blog_enable_top_header'] = true; 
    	$defaults['cream_blog_enable_sidebar_toggle_button'] = false;
    	$defaults['cream_blog_enable_search_button'] = false;
        $defaults['cream_blog_select_header_layout'] = 'header_1';

        $defaults['cream_blog_enable_footer_social_links'] = true;
    	$defaults['cream_blog_copyright_credit'] = '';
        $defaults['cream_blog_enable_scroll_top_button'] = true;

    	$defaults['cream_blog_select_archive_sidebar_position'] = 'right';

    	$defaults['cream_blog_select_search_sidebar_position'] = 'right';

    	$defaults['cream_blog_display_featured_image_post'] = true;
        $defaults['cream_blog_enable_author_section'] = false;

    	$defaults['cream_blog_enable_related_section'] = false;
    	$defaults['cream_blog_related_section_title'] = '';
    	$defaults['cream_blog_related_section_posts_number'] = 6;

        $defaults['cream_blog_display_featured_image_page'] = true;

    	$defaults['cream_blog_enable_category_meta'] = true;
    	$defaults['cream_blog_enable_date_meta'] = true;
    	$defaults['cream_blog_enable_author_meta'] = true;
    	$defaults['cream_blog_enable_tag_meta'] = true;
    	$defaults['cream_blog_enable_comment_meta'] = true;

    	$defaults['cream_blog_post_excerpt_length'] = 25;

        $defaults['cream_blog_facebook_link'] = '';
        $defaults['cream_blog_twitter_link'] = '';
        $defaults['cream_blog_instagram_link'] = '';
        $defaults['cream_blog_youtube_link'] = '';
        $defaults['cream_blog_google_plus_link'] = '';
        $defaults['cream_blog_linkedin_link'] = '';
        $defaults['cream_blog_pinterest_link'] = '';

        $defaults['cream_blog_enable_breadcrumb'] = true;

        $defaults['cream_blog_enable_lazyload'] = true;

        $defaults['cream_blog_enable_sticky_sidebar'] = true; 

        if( class_exists( 'Woocommerce' ) ) {
            $defaults['cream_blog_select_woocommerce_sidebar_position'] = 'right';
        }

        // Since v-2.1.1
        $defaults['cream_blog_tagline_color'] = '#000';
        $defaults['cream_blog_hide_pages_on_search_result'] = false;
        $defaults['cream_blog_display_footer_widgets'] = true;
        $defaults['cream_blog_content_link_color'] = '#fb5975';
        $defaults['cream_blog_related_posts_by'] = 'category';

    	return $defaults;

	}
}


/**
 * Funtion To Get Google Fonts
 */
if ( !function_exists( 'cream_blog_fonts_url' ) ) :

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
        if ('off' !== _x('on', 'DM Sans font: on or off', 'cream-blog')) {

            $fonts[] = 'DM+Sans:400,400i,700,700i';
        }

        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */

        if ('off' !== _x('on', 'Inter font: on or off', 'cream-blog')) {

            $fonts[] = 'Inter:400,500,600,700';
        }

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => urlencode( implode( '|', $fonts ) ),
                'subset' => urlencode( $subsets ),
            ), '//fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }
endif;


/**
 * Funtion To Get Sidebar Position
 */
if ( !function_exists( 'cream_blog_sidebar_position' ) ) :

    /**
     * Return Position of Sidebar.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function cream_blog_sidebar_position() {

        $sidebar_position = '';

        if( class_exists( 'Woocommerce' ) ) {

            if( is_shop() || is_product() || is_cart() || is_checkout() || is_account_page() ) {
                $sidebar_position = cream_blog_get_option( 'cream_blog_select_woocommerce_sidebar_position' );
            } else {
                if( is_home() ) {
                    $sidebar_position = cream_blog_get_option( 'cream_blog_homepage_sidebar' );
                }

                if( is_archive() ) {
                    $sidebar_position = cream_blog_get_option( 'cream_blog_select_archive_sidebar_position' );
                }

                if( is_search() ) {
                    $sidebar_position = cream_blog_get_option( 'cream_blog_select_search_sidebar_position' );
                }

                if( is_single() || is_page() ) {
                    $sidebar_position = get_post_meta( get_the_ID(), 'cream_blog_sidebar_position', true );
                    if( empty( $sidebar_position ) ) {
                        $sidebar_position = 'right';
                    }
                }
            }
        } else {

            if( is_home() ) {
                $sidebar_position = cream_blog_get_option( 'cream_blog_homepage_sidebar' );
            }

            if( is_archive() ) {
                $sidebar_position = cream_blog_get_option( 'cream_blog_select_archive_sidebar_position' );
            }

            if( is_search() ) {
                $sidebar_position = cream_blog_get_option( 'cream_blog_select_search_sidebar_position' );
            }

            if( is_single() || is_page() ) {
                $sidebar_position = get_post_meta( get_the_ID(), 'cream_blog_sidebar_position', true );
                if( empty( $sidebar_position ) ) {
                    $sidebar_position = 'right';
                }
            }
        }
        
        return $sidebar_position;
    }
endif;


/**
 * Funtion To Check Sidebar Sticky
 */
if ( !function_exists( 'cream_blog_check_sticky_sidebar' ) ) :

    /**
     * Return True or False
     *
     * @since 1.0.0
     * @return boolean.
     */
    function cream_blog_check_sticky_sidebar() {

        $is_sticky_sidebar = cream_blog_get_option( 'cream_blog_enable_sticky_sidebar' );

        if( $is_sticky_sidebar == true ) {
            return true;
        } else {
            return false;
        }
    }
endif;


/**
 * Filter For Main Query
 */
if( ! function_exists( 'cream_blog_main_query_filter' ) ) :

    function cream_blog_main_query_filter( $query ) {

        if ( is_admin() ) {

            return $query;
        }

        if ( $query->is_search && ( cream_blog_get_option( 'cream_blog_hide_pages_on_search_result' ) == true ) ) {
            
            $query->set('post_type', 'post');
        }

        return $query;
    }
endif;
add_filter( 'pre_get_posts', 'cream_blog_main_query_filter' );

/*
 * Hook - Plugin Recommendation
 */


if ( ! function_exists( 'cream_blog_recommended_plugins' ) ) :
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

endif;
add_action( 'tgmpa_register', 'cream_blog_recommended_plugins' );