<?php
/**
 * Active Callback functions for this theme
 *
 * @package Cream_Blog
 */

/*
 *	Active Callback Functions for Top Header
 */
if( ! function_exists( 'cream_blog_is_active_header_four_five' ) ) {

	function cream_blog_is_active_header_four_five( $control ) {
		if( $control->manager->get_setting( 'cream_blog_select_header_layout' )->value() == 'header_5' || $control->manager->get_setting( 'cream_blog_select_header_layout' )->value() == 'header_4') {
			return true;
		} else {
			return false;
		}
	}
}


/*
 *	Active Callback Functions for Banner Six
 */
if( ! function_exists( 'cream_blog_is_not_active_banner_six' ) ) {

	function cream_blog_is_not_active_banner_six( $control ) {
		if( $control->manager->get_setting( 'cream_blog_select_banner_layout' )->value() != 'banner_6' ) {
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