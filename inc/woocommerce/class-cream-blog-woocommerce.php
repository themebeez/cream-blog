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

/**
 * Cream Blog Woocommerce Class
 */
class Cream_Blog_Woocommerce {

	/**
	 * Setup class.
	 *
	 * @return  void
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'remove_breadcrumbs' ), 10 );
		add_action( 'after_setup_theme', array( $this, 'setup' ), 10 );		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );

		add_filter( 'body_class', array( $this, 'active_body_class' ), 10, 1 );
		add_filter( 'loop_shop_per_page', array( $this, 'products_per_page' ), 10, 1 );
		add_filter( 'woocommerce_product_thumbnails_columns', array( $this, 'thumbnail_columns' ), 10, 1 );

		/**
		 * Disable the default WooCommerce stylesheet.
		 *
		 * Removing the default WooCommerce stylesheet and enqueing your own will
		 * protect you during WooCommerce core updates.
		 *
		 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
		 */
		// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
	}

	/**
	 * WooCommerce setup function.
	 *
	 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
	 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
	 *
	 * @return void
	 */
	public function setup() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * WooCommerce specific scripts & stylesheets.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {

		$font_path   = WC()->plugin_url() . '/assets/fonts/';
		$inline_font = '@font-face {
				font-family: "star";
				src: url("' . $font_path . 'star.eot");
				src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
					url("' . $font_path . 'star.woff") format("woff"),
					url("' . $font_path . 'star.ttf") format("truetype"),
					url("' . $font_path . 'star.svg#star") format("svg");
				font-weight: normal;
				font-style: normal;
			}';

		wp_add_inline_style( 'cream-blog-woocommerce-style', $inline_font );
	}

	/**
	 * Add 'woocommerce-active' class to the body tag.
	 *
	 * @param  array $classes CSS classes applied to the body tag.
	 * @return array $classes modified to include 'woocommerce-active' class.
	 */
	public function active_body_class( $classes ) {
		$classes[] = 'woocommerce-active';

		return $classes;
	}


	/**
	 * Products per page.
	 *
	 * @return integer number of products.
	 */
	public function products_per_page() {
		return 12;
	}
	

	/**
	 * Product gallery thumnbail columns.
	 *
	 * @return integer number of columns.
	 */
	public function thumbnail_columns() {
		return 3;
	}
	/**
	 * Removes default woocommerce breadcrumb.
	 *
	 * @return void.
	 */
	function remove_breadcrumbs() {
	    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}
}