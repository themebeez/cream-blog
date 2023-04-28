<?php
/**
 * Collection of helper functions, and action hook functions.
 *
 * @package Cream_Blog
 */

if ( ! function_exists( 'cream_blog_navigation_fallback' ) ) {
	/**
	 * Callback function for 'fallback_cb' in argument of 'wp_nav_menu'.
	 *
	 * @since 1.0.0
	 */
	function cream_blog_navigation_fallback() {
		?>
		<ul>
			<?php
				wp_list_pages(
					array(
						'title_li' => '',
						'depth'    => 3,
					)
				);
			?>
		</ul>
		<?php
	}
}


if ( ! function_exists( 'cream_blog_banner_query' ) ) {
	/**
	 * Queries posts for banner/slider and returns the post
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function cream_blog_banner_query() {

		$banner_post_no   = '';
		$banner_post_cats = cream_blog_get_option( 'cream_blog_banner_categories' );
		$banner_layout    = cream_blog_get_option( 'cream_blog_select_banner_layout' );

		if ( 'banner_8' === $banner_layout ) {
			$banner_post_no = absint( cream_blog_get_option( 'cream_blog_banner_posts_no' ) ) + 1;
		} else {
			$banner_post_no = absint( cream_blog_get_option( 'cream_blog_banner_posts_no' ) );
		}

		$banner_query_args = array(
			'post_type' => 'post',
		);

		if ( absint( $banner_post_no ) > 0 ) {
			$banner_query_args['posts_per_page'] = absint( $banner_post_no );
		} else {
			if ( 'banner_8' === $banner_layout ) {
				$banner_post_no = 3;
			} else {
				$banner_post_no = 5;
			}
		}
		if ( ! empty( $banner_post_cats ) ) {
			$banner_query_args['cat'] = $banner_post_cats;
		}

		$banner_query = new WP_Query( $banner_query_args );

		return $banner_query;
	}
}

/*
 * Post Metas: Author, Date and Comments Number
 */
if ( ! function_exists( 'cream_blog_post_meta' ) ) {
	/**
	 * Renders post meta.
	 *
	 * @since 1.0.0
	 *
	 * @param boolean $show_author Show author meta.
	 * @param boolean $show_date Show date meta.
	 * @param boolean $show_comments_no Show comments number meta.
	 */
	function cream_blog_post_meta( $show_author, $show_date, $show_comments_no ) {

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		$enable_date        = cream_blog_get_option( 'cream_blog_enable_date_meta' );
		$enable_author      = cream_blog_get_option( 'cream_blog_enable_author_meta' );
		$enable_comments_no = cream_blog_get_option( 'cream_blog_enable_comment_meta' );

		if ( 'post' === get_post_type() ) {
			?>
			<div class="metas">
				<ul class="metas-list">
					<?php
					if (
						(
							true === $enable_author ||
							1 === $enable_author
						) &&
						(
							true === $show_author ||
							1 === $show_author
						)
					) {
						?>
						<li class="posted-by">
							<?php
							printf(
								/* translators: %1$s: span tag open, %2$s: span tag close, %3$s: post author. */
								esc_html_x( '%1$s By: %2$s %3$s', 'post author', 'cream-blog' ),
								'<span class="meta-name">',
								'</span>',
								'<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
							);
							?>
						</li><!-- .posted-by -->
						<?php
					}

					if (
						(
							true === $enable_date ||
							1 === $enable_date
						) &&
						(
							true === $show_date ||
							1 === $show_date
						)
					) {
						?>
						<li class="posted-date">
							<?php
							printf(
								/* translators: %1$s: span tag open, %2$s: span tag close, %3$s: post date. */
								esc_html_x( '%1$s On: %1$s %3$s', 'post date', 'cream-blog' ),
								'<span class="meta-name">',
								'</span>',
								'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>' // phpcs:ignore
							);
							?>
						</li><!-- .posted-date -->
						<?php
					}

					if (
						(
							true === $enable_comments_no ||
							1 === $enable_comments_no
						) &&
						(
							true === $show_comments_no ||
							1 === $show_comments_no
						) &&
						( comments_open() || get_comments_number() )
					) {
						?>
						<li class="comment">
							<a href="<?php the_permalink(); ?>">
								<?php
								if ( get_comments_number() > 0 ) {
									/* translators: %1$s: comments number */
									printf( esc_html__( '%1$s Comments', 'cream-blog' ), get_comments_number() ); // phpcs:ignore
								} else {
									/* translators: %1$s: comments number */
									printf( esc_html__( '%1$s Comment', 'cream-blog' ), get_comments_number() ); // phpcs:ignore
								}
								?>
							</a>
						</li><!-- .comments -->
						<?php
					}
					?>
				</ul><!-- .post_meta -->
			</div><!-- .meta -->
			<?php
		}
	}
}


if ( ! function_exists( 'cream_blog_post_categories_meta' ) ) {
	/**
	 * Renders post categories meta.
	 *
	 * @since 1.0.0
	 */
	function cream_blog_post_categories_meta() {

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			$enable_categories_meta = cream_blog_get_option( 'cream_blog_enable_category_meta' );

			if ( true === $enable_categories_meta || 1 === $enable_categories_meta ) {
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list();
				if ( $categories_list ) {
					?>
					<div class="entry-cats">
						<?php echo $categories_list; // phpcs:ignore ?>
					</div><!-- entry-cats -->
					<?php
				}
			}
		}
	}
}


if ( ! function_exists( 'cream_blog_post_tags_meta' ) ) {
	/**
	 * Renders post tags meta.
	 *
	 * @since 1.0.0
	 */
	function cream_blog_post_tags_meta() {

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			$enable_tags_meta = cream_blog_get_option( 'cream_blog_enable_tag_meta' );

			if ( true === $enable_tags_meta || 1 === $enable_tags_meta ) {
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list();
				if ( $tags_list ) {
					?>
					<div class="entry-tags">
						<div class="post-tags">
							<?php echo $tags_list; // phpcs:ignore  ?>
						</div><!-- .post-tags -->
					</div><!-- .entry-tags -->
					<?php
				}
			}
		}
	}
}


if ( ! function_exists( 'cream_blog_main_class' ) ) {
	/**
	 * Sets CSS class for main container.
	 *
	 * @since 1.0.0
	 */
	function cream_blog_main_class() {

		$sidebar_position = cream_blog_sidebar_position();
		$is_sticky        = cream_blog_check_sticky_sidebar();
		$main_class       = '';

		if ( class_exists( 'WooCommerce' ) ) {
			if (
				is_woocommerce() ||
				is_shop() ||
				is_cart() ||
				is_checkout() ||
				is_account_page()
			) {
				if (
					'none' !== $sidebar_position &&
					is_active_sidebar( 'woocommerce-sidebar' )
				) {
					if ( 'left' === $sidebar_position ) {
						if ( true === $is_sticky || 1 === $is_sticky ) {
							$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1 cd-stickysidebar';
						} else {
							$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1';
						}
					} else {
						if ( true === $is_sticky || 1 === $is_sticky ) {
							$main_class = 'col-lg-8 col-md-12 col-sm-12 col-12 cd-stickysidebar';
						} else {
							$main_class = 'col-lg-8 col-md-12 col-sm-12 col-12';
						}
					}
				} else {
					$main_class = 'col-lg-12 col-md-12 col-sm-12 col-12';
				}
			} else {
				if (
					is_archive() ||
					is_search() ||
					is_home() ||
					is_single() ||
					is_page()
				) {
					if (
						'none' !== $sidebar_position &&
						is_active_sidebar( 'sidebar' )
					) {
						if ( 'left' === $sidebar_position ) {
							if ( true === $is_sticky || 1 === $is_sticky ) {
								$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1 cd-stickysidebar';
							} else {
								$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1';
							}
						} else {
							if ( true === $is_sticky || 1 === $is_sticky ) {
								$main_class = 'col-lg-8 col-md-12 col-sm-12 col-12 cd-stickysidebar';
							} else {
								$main_class = 'col-lg-8 col-md-12 col-sm-12 col-12';
							}
						}
					} else {
						$main_class = 'col-lg-12 col-md-12 col-sm-12 col-12';
					}
				}
			}
		} else {
			if (
				is_archive() ||
				is_search() ||
				is_home() ||
				is_single() ||
				is_page()
			) {
				if (
					'none' !== $sidebar_position &&
					is_active_sidebar( 'sidebar' )
				) {
					if ( 'left' === $sidebar_position ) {
						if ( true === $is_sticky || 1 === $is_sticky ) {
							$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1 cd-stickysidebar';
						} else {
							$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1';
						}
					} else {
						if ( true === $is_sticky || 1 === $is_sticky ) {
							$main_class = 'col-lg-8 col-md-12 col-sm-12 col-12 cd-stickysidebar';
						} else {
							$main_class = 'col-lg-8 col-md-12 col-sm-12 col-12';
						}
					}
				} else {
					$main_class = 'col-lg-12 col-md-12 col-sm-12 col-12';
				}
			}
		}

		return $main_class;
	}
}


if ( ! function_exists( 'cream_blog_sidebar_class' ) ) {
	/**
	 * Sets CSS class for sidebar container.
	 *
	 * @since 1.0.0
	 */
	function cream_blog_sidebar_class() {

		$sidebar_position = cream_blog_sidebar_position();
		$is_sticky        = cream_blog_check_sticky_sidebar();
		$sidebar_class    = '';

		if (
			'none' !== $sidebar_position &&
			is_active_sidebar( 'sidebar' )
		) {
			if ( 'left' === $sidebar_position ) {
				if ( true === $is_sticky || 1 === $is_sticky ) {
					$sidebar_class = 'col-lg-4 col-md-12 order-lg-1 order-md-12 order-sm-12 order-12 cd-stickysidebar';
				} else {
					$sidebar_class = 'col-lg-4 col-md-12 order-lg-1 order-md-12 order-sm-12 order-12';
				}
			} else {
				if ( true === $is_sticky || 1 === $is_sticky ) {
					$sidebar_class = 'col-lg-4 col-md-12 col-sm-12 col-12 cd-stickysidebar';
				} else {
					$sidebar_class = 'col-lg-4 col-md-12 col-sm-12 col-12';
				}
			}
		}

		return $sidebar_class;
	}
}


if ( ! function_exists( 'cream_blog_post_thumbnail' ) ) {
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 * @since 1.0.0
	 */
	function cream_blog_post_thumbnail() {

		if ( post_password_required() || is_attachment() ) {

			return;
		}

		if ( is_home() ) {

			$thumbnail        = '';
			$thumbnail_url    = '';
			$blog_list_layout = cream_blog_get_option( 'cream_blog_select_blog_post_list_layout' );

			if ( 'list_1' === $blog_list_layout ) {
				$thumbnail = 'cream-blog-thumbnail-two';
			} elseif ( 'list_3' === $blog_list_layout ) {
				$thumbnail = 'cream-blog-thumbnail-one';
			} else {
				$thumbnail = 'full';
			}

			if ( has_post_thumbnail() ) {

				$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), $thumbnail );
				?>
				<div class="thumb">
					<?php
					if ( 'list_5' === $blog_list_layout ) {
						?>
						<a class="bricks-gallery vbox-item" data-gall="myGallery" href="<?php echo esc_url( $thumbnail_url ); ?>">
						<?php
					} else {
						?>
						<a href="<?php the_permalink(); ?>">
						<?php
					}
					?>
					<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
					</a>
				</div>
				<?php
			}
		}

		if ( is_archive() ) {

			$thumbnail     = 'full';
			$thumbnail_url = '';

			if ( has_post_thumbnail() ) {

				$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), $thumbnail );
				?>
				<div class="thumb">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
					</a>
				</div>
				<?php
			}
		}

		if ( is_search() ) {

			$thumbnail_url = '';

			if ( has_post_thumbnail() ) {

				$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				?>
				<div class="thumb">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
					</a>
				</div>
				<?php
			}
		}

		if ( is_single() || is_page() ) {

			if ( has_post_thumbnail() ) {

				$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				?>
				<div class="single-thumbnail">
					<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
				</div><!-- .thumb -->
				<?php
			}
		}
	}
}


if ( ! function_exists( 'cream_blog_main_menu_sticky_id' ) ) {
	/**
	 * Sets ID to main navigation menu element for sticky menu.
	 *
	 * @since 1.0.0
	 */
	function cream_blog_main_menu_sticky_id() {

		$is_sticky_menu_bar = cream_blog_get_option( 'cream_blog_enable_sticky_menu' );
		$stick_menu_id      = '';

		if ( true === $is_sticky_menu_bar || 1 === $is_sticky_menu_bar ) {

			$stick_menu_id = 'cb-stickhead';
		}

		return $stick_menu_id;
	}
}


if ( ! function_exists( 'cream_blog_woocommerce_sidebar' ) ) {
	/**
	 * Renders WooCommerce sidebar.
	 *
	 * @since 1.0.0
	 */
	function cream_blog_woocommerce_sidebar() {

		if ( class_exists( 'WooCommerce' ) ) {

			if ( is_active_sidebar( 'woocommerce-sidebar' ) ) {

				$sidebar_class = cream_blog_sidebar_class();
				?>
				<div class="<?php echo esc_attr( $sidebar_class ); ?> woocommerce-sidebar">
					<aside class="secondary">
						<?php dynamic_sidebar( 'woocommerce-sidebar' ); ?>
					</aside><!-- #secondary -->
				</div>
				<?php
			}
		}
	}
}


if ( ! function_exists( 'cream_blog_default_archive_widget' ) ) {
	/**
	 * Adds a span around post counts in the archive widget.
	 *
	 * @param string $links The comment fields.
	 * @return string
	 */
	function cream_blog_default_archive_widget( $links ) {

		$links = str_replace( '</a>&nbsp;(', '</a> <span class="count">(', $links );
		$links = str_replace( ')', ')</span>', $links );
		return $links;
	}

	add_filter( 'get_archives_link', 'cream_blog_default_archive_widget' );
}


if ( ! function_exists( 'cream_blog_cat_count_span' ) ) {
	/**
	 * Modifies the HTML output of a taxonomy list. Adds a span around post counts.
	 *
	 * @param string $links The comment fields.
	 * @return string
	 */
	function cream_blog_cat_count_span( $links ) {

		$links = str_replace( '</a> (', '</a><span class="count">(', $links );
		$links = str_replace( ')', ')</span>', $links );
		return $links;
	}
	add_filter( 'wp_list_categories', 'cream_blog_cat_count_span' );
}


if ( ! function_exists( 'cream_blog_has_google_fonts' ) ) {
	/**
	 * Checks if Google font is used.
	 *
	 * @since 2.1.4
	 */
	function cream_blog_has_google_fonts() {

		$body_font = cream_blog_get_option( 'cream_blog_body_font' );
		$body_font = json_decode( $body_font, true );

		$headings_font = cream_blog_get_option( 'cream_blog_headings_font' );
		$headings_font = json_decode( $headings_font, true );

		return ( ( isset( $body_font['source'] ) && 'google' === $body_font['source'] ) || ( isset( $headings_font['source'] ) && 'google' === $headings_font['source'] ) ) ? true : false;
	}
}


if ( ! function_exists( 'cream_blog_google_fonts_urls' ) ) {
	/**
	 * Returns the array of Google fonts URL.
	 *
	 * @since 2.1.4
	 *
	 * @return array $fonts_urls Fonts URLs.
	 */
	function cream_blog_google_fonts_urls() {

		if ( ! cream_blog_has_google_fonts() ) {
			return false;
		}

		$fonts_urls = array();

		$body_font = cream_blog_get_option( 'cream_blog_body_font' );
		$body_font = json_decode( $body_font, true );

		$headings_font = cream_blog_get_option( 'cream_blog_headings_font' );
		$headings_font = json_decode( $headings_font, true );

		if ( isset( $body_font['source'] ) && 'google' === $body_font['source'] ) {
			$fonts_urls[] = $body_font['font_url'];
		}

		if ( isset( $headings_font['source'] ) && 'google' === $headings_font['source'] ) {
			$fonts_urls[] = $headings_font['font_url'];
		}

		return $fonts_urls;
	}
}


if ( ! function_exists( 'cream_blog_render_google_fonts_header' ) ) {
	/**
	 * Renders <link> tags for Google fonts embedd in the <head> tag.
	 *
	 * @since 2.1.4
	 */
	function cream_blog_render_google_fonts_header() {

		if ( ! cream_blog_has_google_fonts() ) {
			return;
		}
		?>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
		<?php
	}

	add_action( 'wp_head', 'cream_blog_render_google_fonts_header', 5 );
}


if ( ! function_exists( 'cream_blog_get_google_fonts_url' ) ) {
	/**
	 * Returns the URL of Google fonts.
	 *
	 * @since 2.1.4
	 *
	 * @return string $google_fonts_url Google Fonts URL.
	 */
	function cream_blog_get_google_fonts_url() {

		$google_fonts_urls = cream_blog_google_fonts_urls();

		if ( empty( $google_fonts_urls ) ) {

			return false;
		}

		$google_fonts_url = add_query_arg(
			array(
				'family'  => implode( '&family=', $google_fonts_urls ),
				'display' => 'swap',
			),
			'https://fonts.googleapis.com/css2'
		);

		return esc_url( $google_fonts_url );
	}
}
