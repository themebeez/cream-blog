<?php
/**
 * Constant definition and call theme's main file and run it.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package    Cream_Blog
 * @author     Themebeez <themebeez@gmail.com>
 * @copyright  Copyright (c) 2018, Themebeez
 * @link       http://themebeez.com/themes/cream-blog/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if ( ! defined( 'CREAM_BLOG_VERSION' ) ) {
	define( 'CREAM_BLOG_VERSION', '2.1.7' );
}


require get_template_directory() . '/inc/class-cream-blog.php';

/**
 * Theme's main function.
 *
 * @since 1.0.0
 */
function cream_blog_run() {

	$cream_blog = new Cream_Blog();
}

cream_blog_run();

add_action(
	'init',
	function () {
		new Cream_Blog_Theme_Welcome_Notice(
			'Cream Blog',
			admin_url( 'admin.php?page=cream-blog' ),
			array(
				'themebeez-toolkit/themebeez-toolkit.php' => 'https://downloads.wordpress.org/plugin/themebeez-toolkit.zip',
			)
		);
	}
);
