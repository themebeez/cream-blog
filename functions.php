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

$cream_blog_theme = wp_get_theme( 'cream-blog' );

define( 'CREAM_BLOG_VERSION', $cream_blog_theme->get( 'Version' ) );

require get_template_directory() . '/inc/class-cream-blog.php';


function cream_blog_run() {

	$cream_blog = new Cream_Blog();
}

cream_blog_run();