<?php
/**
 * Active Callback functions for this theme
 *
 * @package Cream_Blog
 */

/*
 *	Active Callback Functions Banner/Slider
 */
if( ! function_exists( 'cream_blog_is_banner_active' ) ) {

	function cream_blog_is_banner_active( $control ) {
		if( $control->manager->get_setting( 'cream_blog_enable_banner' )->value() == true ) {
			return true;
		} else {
			return false;
		}
	}
}


/*
 *	Active Callback Functions for Top Header
 */
if( ! function_exists( 'cream_blog_is_header_layout_2_active' ) ) {

	function cream_blog_is_header_layout_2_active( $control ) {
		if( $control->manager->get_setting( 'cream_blog_select_header_layout' )->value() == 'header_2') {
			return true;
		} else {
			return false;
		}
	}
}


/*
 *	Active Callback Functions for Related Post
 */
if( ! function_exists( 'cream_blog_is_active_related_post' ) ) {

	function cream_blog_is_active_related_post( $control ) {
		if( $control->manager->get_setting( 'cream_blog_enable_related_section' )->value() == true ) {
			return true;
		} else {
			return false;
		}
	}
}