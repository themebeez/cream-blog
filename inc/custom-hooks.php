<?php
/**
 * Custom hooks for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Cream_Blog
 */

/**
 * Doctype declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_doctype_action' ) ) :
	function cream_blog_doctype_action() {
	?>
		<!doctype html>
		<html <?php language_attributes(); ?>>
	<?php		
	}
endif;
add_action( 'cream_blog_doctype', 'cream_blog_doctype_action', 10 );


/**
 * Head declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_head_action' ) ) :
 	function cream_blog_head_action() {
 	?>
 	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes"> 
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
 	<?php	
 	}
endif;
add_action( 'cream_blog_head', 'cream_blog_head_action', 10 );


/**
 * Body Before declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_body_before_action' ) ) :
 	function cream_blog_body_before_action() {
 	?>
 		<body <?php body_class(); ?>>
 			<?php 
			if( function_exists( 'wp_body_open' ) ) { 
				wp_body_open(); 
			} 
			?>
 	<?php
 	}
endif;
add_action( 'cream_blog_body_before', 'cream_blog_body_before_action', 10 );


/**
 * Page Wapper Start declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_page_wrapper_start_action' ) ) :
 	function cream_blog_page_wrapper_start_action() {
 	?>
 		<div class="page-wrap">
 			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'cream-blog' ); ?></a>
 	<?php
 	}
endif;
add_action( 'cream_blog_page_wrapper_start', 'cream_blog_page_wrapper_start_action', 10 );


/**
 * Page Wapper End declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_page_wrapper_end_action' ) ) :
 	function cream_blog_page_wrapper_end_action() {
 	?>
 		</div><!-- .page-wrap -->
 	<?php
 	}
endif;
add_action( 'cream_blog_page_wrapper_end', 'cream_blog_page_wrapper_end_action', 10 );


/**
 * Header layout selection declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_header_section_action' ) ) :
 	function cream_blog_header_section_action() {
 		$header_layout = cream_blog_get_option( 'cream_blog_select_header_layout' );
 		if( $header_layout == 'header_1' ) {
 			get_template_part( 'template-parts/header/header', 'one' );
 		} else {
 			get_template_part( 'template-parts/header/header', 'two' );
 		}
 	?>
 	<?php
 	}
endif;
add_action( 'cream_blog_header_section', 'cream_blog_header_section_action', 10 );


/**
 * Header top menu declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_header_top_menu_action' ) ) :
 	function cream_blog_header_top_menu_action() {
 		if( has_nav_menu( 'menu-2' ) ) {
 			wp_nav_menu( array( 
 				'theme_location' => 'menu-2',
 				'container' => '', 
 				'depth' => 1,
 			) );
 		}
 	}
endif;
add_action( 'cream_blog_header_top_menu', 'cream_blog_header_top_menu_action', 10 );


/**
 * Main menu declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_main_menu_action' ) ) :
 	function cream_blog_main_menu_action() {
 		$menu_args = array(
 			'theme_location' => 'menu-1',
 			'container' => '',
 			'menu_class' => '',
			'menu_id' => '',
			'fallback_cb' => 'cream_blog_navigation_fallback',
 		);
		wp_nav_menu( $menu_args );
 	}
endif;
add_action( 'cream_blog_main_menu', 'cream_blog_main_menu_action', 10 );


/**
 * Site identity declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_site_identity_action' ) ) :
 	function cream_blog_site_identity_action() {
 		?>
 		<div class="site-branding">
 			<?php 
			if( has_custom_logo() ) { 
				
				if( is_home() || is_front_page() ) {
					?>
					<h1 class="site-logo">
					<?php
				}

				the_custom_logo(); 

				if( is_home() || is_front_page() ) {
					?>
					</h1>
					<?php
				}
			} else { 
				?>
	            <div class="site-identity">
	            	<?php
	            	if( is_home() || is_front_page() ) {
	            		?>
	            		<h1 class="site-title">
	            		<?php
	            	} else {
	            		?>
	            		<span class="site-title">
	            		<?php
	            	}
	            	?>
	                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					<?php 
					if( is_home() || is_front_page() ) {
	            		?>
	            		</h1>
	            		<?php
	            	} else {
	            		?>
	            		</span>
	            		<?php
	            	}
	            	
	                $site_description = get_bloginfo( 'description', 'display' );
	                if ( $site_description || is_customize_preview() ) {
		                ?>
		                <p class="site-description"><?php echo esc_html( $site_description ); /* phpcs:ignore */ ?></p>
						<?php
					}
					?>
	            </div><!-- .site-identity -->
	            <?php
	        }
	        ?>
        </div><!-- .site-branding -->
 		<?php
 	}
endif;
add_action( 'cream_blog_site_identity', 'cream_blog_site_identity_action', 10 );


/**
 * Header Ad Area declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_header_ad_area_action' ) ) :
 	function cream_blog_header_ad_area_action() {
 		if( is_active_sidebar( 'header-advertisement' ) ) {
	 		?>
	 		<div class="header-ads">
	            <?php dynamic_sidebar( 'header-advertisement' ); ?>
	        </div><!-- .header-ads -->
	 		<?php
	 	}
 	}
endif;
add_action( 'cream_blog_header_ad_area', 'cream_blog_header_ad_area_action', 10 );


/**
 * Social links declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_social_links_action' ) ) :
 	function cream_blog_social_links_action() {
 		?>
 		<div class="social-icons">
            <ul class="social-icons-list">
            	<?php
	 			$facebook_link = cream_blog_get_option( 'cream_blog_facebook_link' );
	 			if( !empty( $facebook_link ) ) {
	 				?>
                	<li><a href="<?php echo esc_url( $facebook_link); ?>"><i class="cb cb-facebook"></i></a></li>
                	<?php
	 			}
	 			$twitter_link = cream_blog_get_option( 'cream_blog_twitter_link' );
	 			if( !empty( $twitter_link ) ) {
	 				?>  
                	<li><a href="<?php echo esc_url( $twitter_link ); ?>"><i class="cb cb-twitter"></i></a></li>
                	<?php
	 			}
	 			$instagram_link = cream_blog_get_option( 'cream_blog_instagram_link' );
	 			if( !empty( $instagram_link ) ) {
	 				?>
                	<li><a href="<?php echo esc_url( $instagram_link ); ?>"><i class="cb cb-instagram"></i></a></li>
                	<?php
	 			}
	 			$linkedin_link = cream_blog_get_option( 'cream_blog_linkedin_link' );
	 			if( !empty( $linkedin_link ) ) {
	 				?> 
                	<li><a href="<?php echo esc_url( $linkedin_link ); ?>"><i class="cb cb-linkedin"></i></a></li>
                	<?php
	 			}
	 			$pinterest_link = cream_blog_get_option( 'cream_blog_pinterest_link' );
	 			if( !empty( $pinterest_link ) ) {
	 				?> 
                	<li><a href="<?php echo esc_url( $pinterest_link ); ?>"><i class="cb cb-pinterest"></i></a></li>
                	<?php
	 			}
	 			$youtube_link = cream_blog_get_option( 'cream_blog_youtube_link' );
	 			if( !empty( $youtube_link ) ) {
	 				?>
                	<li><a href="<?php echo esc_url( $youtube_link ); ?>"><i class="cb cb-youtube"></i></a></li>
                	<?php
	 			}
                ?>
            </ul><!-- .social-icons-list -->
        </div><!-- .social-icons -->
 		<?php
 	}
endif;
add_action( 'cream_blog_social_links', 'cream_blog_social_links_action', 10 );


/**
 * Sidebar Toggle Button declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_sidebar_toggle_button_action' ) ) :
 	function cream_blog_sidebar_toggle_button_action() {
 		if( is_active_sidebar( 'off-canvas-sidebar' ) ) {
	 		?>
	 		<a id="canvas-toggle" href="javascript:;">
	 			<i class="cb cb-menu"></i>
	 		</a><!-- #canvas-toogle -->
	 		<?php
	 	}
 	}
endif;
add_action( 'cream_blog_sidebar_toggle_button', 'cream_blog_sidebar_toggle_button_action', 10 );


/**
 * Toggle Sidebar declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_toggle_sidebar_action' ) ) :
 	function cream_blog_toggle_sidebar_action() {
 		$is_enable_toggle_sidebar = cream_blog_get_option( 'cream_blog_enable_sidebar_toggle_button' );
 		if( is_active_sidebar( 'off-canvas-sidebar' ) && ( $is_enable_toggle_sidebar == true ) ) {
	 		?>
	 		<div id="canvas-aside">
	            <div class="canvas-inner">
	            	<?php dynamic_sidebar( 'off-canvas-sidebar' ); ?>
	            </div><!-- .canvas-inner -->
	        </div><!-- .canvas-aside -->
	        <div id="canvas-aside-mask"></div><!-- #canvas-aside-mask -->
	 		<?php
	 	}
 	}
endif;
add_action( 'cream_blog_toggle_sidebar', 'cream_blog_toggle_sidebar_action', 10 );


/**
 * Search Button declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_search_button_action' ) ) :
 	function cream_blog_search_button_action() {
 		$show_toggled_sidebar_icon = cream_blog_get_option( 'cream_blog_enable_sidebar_toggle_button' );
 		if( is_active_sidebar( 'off-canvas-sidebar' ) && $show_toggled_sidebar_icon == true ) {
	 		?>
	 		<a id="search-toggle" href="javascript:;">
	 			<i class="cb cb-search"></i>
	 		</a><!-- #search-toggle -->
	 		<?php
	 	}
 	}
endif;
add_action( 'cream_blog_search_button', 'cream_blog_search_button_action', 10 );


/**
 * Toggle Search Form declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_toogle_search_form_action' ) ) :
 	function cream_blog_toogle_search_form_action() {
 		?>
 		<div id="header-search">
            <?php get_search_form(); ?>
        </div><!-- .header_search -->
 		<?php
 	}
endif;
add_action( 'cream_blog_toogle_search_form', 'cream_blog_toogle_search_form_action', 10 );


/**
 * Content Start Wrapper.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_content_start_action' ) ) :
 	function cream_blog_content_start_action() {
 		?>
 		<div id="content" class="site-content">
 		<?php
 	}
endif;
add_action( 'cream_blog_content_start', 'cream_blog_content_start_action', 10 );


/**
 * Breadcrumb declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_breadcrumb_action' ) ) :
 	function cream_blog_breadcrumb_action() {
 		$enable_breadcrumb = cream_blog_get_option( 'cream_blog_enable_breadcrumb' ); 
 		if( $enable_breadcrumb == true ) {
 			?>
 			<div class="cb-breadcrumb breadcrumb-style-2">
			    <?php
			    $breadcrumb_args = array(
			        'show_browse' => false,
			    );
			    cream_blog_breadcrumb_trail( $breadcrumb_args );
			    ?>
			</div><!-- .cb-breadcrumb.breadcrumb-style-2 -->
 			<?php
 		}
 	}
endif;
add_action( 'cream_blog_breadcrumb', 'cream_blog_breadcrumb_action', 10 );


/**
 * Pagination declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_pagination_action' ) ) :
 	function cream_blog_pagination_action() {
 		?>
 		<div class="cb-pagination">
		    <div class="pagi-style-1">
		        <?php
		        the_posts_pagination( array(
		            'mid_size' => 3,
		            'prev_text' => esc_html__( 'Prev', 'cream-blog' ),
		            'next_text' => esc_html__( 'Next', 'cream-blog' ),
		        ) );
		        ?>
		    </div><!-- .pagi-style-1 -->
		</div><!-- .cb-pagination -->
 		<?php
 	}
endif;
add_action( 'cream_blog_pagination', 'cream_blog_pagination_action', 10 );


/**
 * Post navigation declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_post_navigation_action' ) ) :
 	function cream_blog_post_navigation_action() {
 		the_post_navigation( array(
			'prev_text'	=> esc_html__( 'Prev Post', 'cream-blog' ),
			'next_text'	=> esc_html__( 'Next Post', 'cream-blog' ),
		) );
 	}
endif;
add_action( 'cream_blog_post_navigation', 'cream_blog_post_navigation_action', 10 );

/**
 * Banner/Slider layout selection declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_banner_slider_action' ) ) :
 	function cream_blog_banner_slider_action() {
 		$show_banner = cream_blog_get_option( 'cream_blog_enable_banner' );
 		$banner_layout = cream_blog_get_option( 'cream_blog_select_banner_layout' );
 		if( $show_banner == true ) {
 			if( $banner_layout == 'banner_1' ) {
 				get_template_part( 'template-parts/banner/banner', 'one' );
 			} else {
				get_template_part( 'template-parts/banner/banner', 'two' );
 			}
 		}
 	?>
 	<?php
 	}
endif;
add_action( 'cream_blog_banner_slider', 'cream_blog_banner_slider_action', 10 );

/**
 * Homepage widget area top declaration.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_homepage_widget_area_top_action' ) ) :
 	function cream_blog_homepage_widget_area_top_action() {
 		if( is_active_sidebar( 'home-widget-area-top' ) ) {
 			dynamic_sidebar( 'home-widget-area-top' );
 		}
 	?>
 	<?php
 	}
endif;
add_action( 'cream_blog_homepage_widget_area_top', 'cream_blog_homepage_widget_area_top_action', 10 );

/**
 * Homepage widget area bottom declaration.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_homepage_widget_area_bottom_action' ) ) :
 	function cream_blog_homepage_widget_area_bottom_action() {
 		if( is_active_sidebar( 'home-widget-area-bottom' ) ) {
 			dynamic_sidebar( 'home-widget-area-bottom' );
 		}
 	?>
 	<?php
 	}
endif;
add_action( 'cream_blog_homepage_widget_area_bottom', 'cream_blog_homepage_widget_area_bottom_action', 10 );


/**
 * Content End Wrapper.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_content_end_action' ) ) :
 	function cream_blog_content_end_action() {
 		?>
 		</div><!-- #content.site-content -->
 		<?php
 	}
endif;
add_action( 'cream_blog_content_end', 'cream_blog_content_end_action', 10 );



/**
 * Footer Wapper Start declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_footer_wrapper_start_action' ) ) :
	
 	function cream_blog_footer_wrapper_start_action() {
 		?>
 		<footer class="cb-footer">
            <div class="footer-inner">
                <div class="cb-container">
 		<?php
 	}
endif;
add_action( 'cream_blog_footer_wrapper_start', 'cream_blog_footer_wrapper_start_action', 10 );


/**
 * Footer Top declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_footer_top_action' ) ) :
 	function cream_blog_footer_top_action() {
 		$enable_footer_links = cream_blog_get_option( 'cream_blog_enable_footer_social_links' );
 		if( $enable_footer_links == true ) {
 			?>
 			<div class="cb-topfooter">
	            <div class="social-icons">
	                <ul class="social-icons-list">
	                	<?php
	                	$facebook_link = cream_blog_get_option( 'cream_blog_facebook_link' );
			 			if( !empty( $facebook_link ) ) {
			 				?>
	                    	<li><a href="<?php echo esc_url( $facebook_link ); ?>"><i class="cb cb-facebook-square"></i> <?php esc_html_e( 'Facebook', 'cream-blog' ); ?></a></li>
	                    	<?php
	                    }
			 			$twitter_link = cream_blog_get_option( 'cream_blog_twitter_link' );
			 			if( !empty( $twitter_link ) ) {
			 				?>  
	                    	<li><a href="<?php echo esc_url( $twitter_link ); ?>"><i class="cb cb-twitter"></i> <?php esc_html_e( 'Twitter', 'cream-blog' ); ?></a></li>
	                    	<?php
	                    }
	                    $instagram_link = cream_blog_get_option( 'cream_blog_instagram_link' );
			 			if( !empty( $instagram_link ) ) {
			 				?>
	                    	<li><a href="<?php echo esc_url( $instagram_link ); ?>"><i class="cb cb-instagram-alt"></i> <?php esc_html_e( 'Instagram', 'cream-blog' ); ?></a></li>
	                    	<?php
	                    }
	                    $linkedin_link = cream_blog_get_option( 'cream_blog_linkedin_link' );
			 			if( !empty( $linkedin_link ) ) {
			 				?> 
	                    	<li><a href="<?php echo esc_url( $linkedin_link ); ?>"><i class="cb cb-linkedin"></i> <?php esc_html_e( 'Linkedin', 'cream-blog' ); ?></a></li>
		                    <?php
				 		}
			 			$pinterest_link = cream_blog_get_option( 'cream_blog_pinterest_link' );
			 			if( !empty( $pinterest_link ) ) {
			 				?> 
		                    <li><a href="<?php echo esc_url( $pinterest_link ); ?>"><i class="cb cb-pinterest-alt"></i> <?php esc_html_e( 'Pinterest', 'cream-blog' ); ?></a></li>
		                    <?php
			 			}
			 			$youtube_link = cream_blog_get_option( 'cream_blog_youtube_link' );
			 			if( !empty( $youtube_link ) ) {
			 				?>
		                    <li><a href="<?php echo esc_url( $youtube_link ); ?>"><i class="cb cb-youtube"></i> <?php esc_html_e( 'Youtube', 'cream-blog' ); ?></a></li>
		                    <?php
			 			}
	                    ?>
	                </ul><!-- .social-icons-list -->
	            </div><!-- .social-icons -->
	        </div><!-- .cb-topfooter -->
 			<?php
 		}
 	}
endif;
add_action( 'cream_blog_footer_top', 'cream_blog_footer_top_action', 10 );



/**
 * Footer Middle declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_footer_middle_action' ) ) :

 	function cream_blog_footer_middle_action() {

 		if( is_active_sidebar( 'footer' ) && cream_blog_get_option( 'cream_blog_display_footer_widgets' ) ==  true ) {
 			?>
 			<div class="cb-midfooter">
                <div class="row">
                	<?php dynamic_sidebar( 'footer' ); ?>
                </div><!-- .row -->
            </div><!-- .cb-midfooter -->
 			<?php
 		}
 	}
endif;
add_action( 'cream_blog_footer_middle', 'cream_blog_footer_middle_action', 10 );


/**
 * Footer Bottom declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_footer_bottom_action' ) ) :

 	function cream_blog_footer_bottom_action() {

 		$copyright_text = cream_blog_get_option( 'cream_blog_copyright_credit' );
 		?>
 		<div class="cb-bottomfooter">
            <div class="copyrights-info">
            	<?php
 				if( !empty( $copyright_text ) ) {
					/* translators: 1: Copyright Text 2: Theme name, 3: Theme author. */
					printf( esc_html__( '%1$s %2$s by %3$s', 'cream-blog' ), esc_html( $copyright_text ), 'Cream Blog', '<a href="'. esc_url( 'https://themebeez.com' ) . '">' . esc_html__( 'Themebeez', 'cream-blog' ) . '</a>' );
 				} else {
 					/* translators: 1: Theme name, 2: Theme author. */
					printf( esc_html__( '%1$s by %2$s', 'cream-blog' ), 'Cream Blog', '<a href="'. esc_url( 'https://themebeez.com' ) . '">' . esc_html__( 'Themebeez', 'cream-blog' ) . '</a>' );
 				}
 				?>
            </div><!-- .copyrights-info -->
        </div><!-- .cb-bottomfooter -->
 		<?php
 	}
endif;
add_action( 'cream_blog_footer_bottom', 'cream_blog_footer_bottom_action', 10 );

/**
 * Footer Wapper End declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_footer_wrapper_end_action' ) ) :

 	function cream_blog_footer_wrapper_end_action() {
 		?>
 				</div><!-- .cb-container -->
 			</div><!-- .footer-inner -->
 		</footer><!-- .cb-footer -->
 		<?php
 	}
endif;
add_action( 'cream_blog_footer_wrapper_end', 'cream_blog_footer_wrapper_end_action', 10 );


/**
 * Footer Declaration of the theme.
 *
 * @since 1.0.0
 */
if( ! function_exists( 'cream_blog_footer_action' ) ) :
    function cream_blog_footer_action() {
        wp_footer();
    	?>
            </body>
        </html>
    	<?php
    }
endif;
add_action( 'cream_blog_footer', 'cream_blog_footer_action', 10 );