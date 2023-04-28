<?php
/**
 * Collection of active callback functions.
 *
 * @package Cream_Blog
 */

if ( ! function_exists( 'cream_blog_is_banner_active' ) ) {
	/**
	 * Checks if banner is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @param  object $control WP Customize Control.
	 * @return boolean
	 */
	function cream_blog_is_banner_active( $control ) {

		return $control->manager->get_setting( 'cream_blog_enable_banner' )->value();
	}
}


if ( ! function_exists( 'cream_blog_is_header_layout_2_active' ) ) {
	/**
	 * Checks if header layout two is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @param  object $control WP Customize Control.
	 * @return boolean
	 */
	function cream_blog_is_header_layout_2_active( $control ) {

		return ( 'header_2' === $control->manager->get_setting( 'cream_blog_select_header_layout' )->value() ) ? true : false;
	}
}


if ( ! function_exists( 'cream_blog_is_active_related_post' ) ) {
	/**
	 * Checks if related section is enabled.
	 *
	 * @since 1.0.0
	 *
	 * @param  object $control WP Customize Control.
	 * @return boolean
	 */
	function cream_blog_is_active_related_post( $control ) {

		return $control->manager->get_setting( 'cream_blog_enable_related_section' )->value();
	}
}
