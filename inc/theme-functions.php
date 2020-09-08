<?php
/**
 * Custom functions for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Cream_Blog
 */

/**
 * Fallback For Main Menu
 */
if ( !function_exists( 'cream_blog_navigation_fallback' ) ) {

    function cream_blog_navigation_fallback() {
        ?>
        <ul>
            <?php 
                wp_list_pages( array( 
                    'title_li' => '', 
                    'depth' => 3,
                ) ); 
            ?>
        </ul>
        <?php    
    }
}

/*
 * Banner Post Query
 */
if( ! function_exists( 'cream_blog_banner_query' ) ) {
	
	function cream_blog_banner_query() {

		$banner_post_no = '';
		$banner_post_cats = cream_blog_get_option( 'cream_blog_banner_categories' );
		$banner_layout = cream_blog_get_option( 'cream_blog_select_banner_layout' );

		if( $banner_layout == 'banner_8' ) {
			$banner_post_no = absint( cream_blog_get_option( 'cream_blog_banner_posts_no' ) ) + 1 ;
		} else {
			$banner_post_no = absint( cream_blog_get_option( 'cream_blog_banner_posts_no' ) );
		}
		
		$banner_args = array(
		    'post_type' => 'post',
		);

		if( absint( $banner_post_no ) > 0 ) {
		    $banner_args['posts_per_page'] = absint( $banner_post_no );
		} else {
			if( $banner_layout == 'banner_8' ) {
				$banner_post_no = 3;
			} else {
				$banner_post_no = 5;
			}
		}
		if( !empty( $banner_post_cats ) ) {
		    $banner_args['cat'] = $banner_post_cats;
		}  
		$banner_query = new WP_Query( $banner_args );

		return $banner_query;
	}
}

/*
 * Post Metas: Author, Date and Comments Number
 */
if( ! function_exists( 'cream_blog_post_meta' ) ) {

	function cream_blog_post_meta( $show_author, $show_date, $show_comments_no ) {

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);
		$enable_date = cream_blog_get_option( 'cream_blog_enable_date_meta' );
		$enable_author = cream_blog_get_option( 'cream_blog_enable_author_meta' );
		$enable_comments_no = cream_blog_get_option( 'cream_blog_enable_comment_meta' );
		if( get_post_type() == 'post' ) {
			?>
			<div class="metas">
				<ul class="metas-list">
					<?php 

					if( $enable_author == true ) {
				        if( $show_author == true ) {
				        	?>
				        	<li class="posted-by">
				            	<?php
				            	printf(
									/* translators: %1$s: span tag open, %2$s: span tag close, %3$s: post author. */
									esc_html_x( '%1$s By: %2$s %3$s', 'post author', 'cream-blog' ),
									'<span class="meta-name">', '</span>', '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>'
								);
				            	?>
				            </li><!-- .posted-by -->
				        	<?php
				        }
			        }

					if( $enable_date == true ) {
						if( $show_date == true ) { 
							?>
				            <li class="posted-date">
				            	<?php
				            	printf(
									/* translators: %1$s: span tag open, %2$s: span tag close, %3$s: post date. */
									esc_html_x( '%1$s On: %1$s %3$s', 'post date', 'cream-blog' ), '<span class="meta-name">', '</span>', '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
								);
				            	?>
				           	</li><!-- .posted-date -->
				           	<?php 
				        } 
			        }

			        if( $enable_comments_no == true ) {
				        if( $show_comments_no == true ) {
				        	if( ( comments_open() || get_comments_number() ) ) {
				        		?>
					            <li class="comment">
					            	<a href="<?php the_permalink(); ?>">
					            		<?php 
					            		if( get_comments_number() > 0 ) {
					            			/* translators: %1$s: comments number */
					            			printf( esc_html__( '%1$s Comments', 'cream-blog' ), get_comments_number() );
					            		} else {
					            			/* translators: %1$s: comments number */
					            			printf( esc_html__( '%1$s Comment', 'cream-blog' ), get_comments_number() );
					            		} 
					            		?>
					            	</a>
					            </li><!-- .comments -->
					          	<?php
					        }
				        }
				    }
			        ?>
		        </ul><!-- .post_meta -->
		    </div><!-- .meta -->
			<?php
		}
	}
}

/*
 * Post Meta: Categories
 */
if( ! function_exists( 'cream_blog_post_categories_meta' ) ) {

	function cream_blog_post_categories_meta() {

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$enable_categories_meta = cream_blog_get_option( 'cream_blog_enable_category_meta' ); 
			if( $enable_categories_meta == true ) {
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

/*
 * Post Meta: Tags
 */
if( ! function_exists( 'cream_blog_post_tags_meta' ) ) {

	function cream_blog_post_tags_meta() {

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$enable_tags_meta = cream_blog_get_option( 'cream_blog_enable_tag_meta' ); 
			if( $enable_tags_meta == true ) {
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

/*
 * Function to define container class
 */
if( ! function_exists( 'cream_blog_main_class' ) ) {

	function cream_blog_main_class() {

		$sidebar_position = cream_blog_sidebar_position();
		$is_sticky = cream_blog_check_sticky_sidebar();
		$main_class = '';
		
		if( class_exists( 'Woocommerce' ) ) {
			if( is_woocommerce() || is_shop() || is_cart() || is_checkout() || is_account_page() ) {
				if( $sidebar_position != 'none' && is_active_sidebar( 'woocommerce-sidebar' ) ) {
					if( $sidebar_position == 'left' ) {
						if( $is_sticky == true ) {
							$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1 cd-stickysidebar';
						} else {
							$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1';	
						}
					} else {
						if( $is_sticky == true ) {
							$main_class = 'col-lg-8 col-md-12 col-sm-12 col-12 cd-stickysidebar';
						} else {
							$main_class = 'col-lg-8 col-md-12 col-sm-12 col-12';	
						}
					}				
				} else {
					$main_class = 'col-lg-12 col-md-12 col-sm-12 col-12';
				}
			} else {
				if( is_archive() || is_search() || is_home() || is_single() || is_page() ) {
					if( $sidebar_position != 'none' && is_active_sidebar( 'sidebar' ) ) {
						if( $sidebar_position == 'left' ) {
							if( $is_sticky == true ) {
								$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1 cd-stickysidebar';
							} else {
								$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1';	
							}
						} else {
							if( $is_sticky == true ) {
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
			if( is_archive() || is_search() || is_home() || is_single() || is_page() ) {
				if( $sidebar_position != 'none' && is_active_sidebar( 'sidebar' ) ) {
					if( $sidebar_position == 'left' ) {
						if( $is_sticky == true ) {
							$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1 cd-stickysidebar';
						} else {
							$main_class = 'col-lg-8 col-md-12 order-lg-12 order-md-1 order-sm-1 order-1';	
						}
					} else {
						if( $is_sticky == true ) {
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


/*
 * Function to define sidebar class
 */
if( ! function_exists( 'cream_blog_sidebar_class' ) ) {

	function cream_blog_sidebar_class() {

		$sidebar_position = cream_blog_sidebar_position();
		$is_sticky = cream_blog_check_sticky_sidebar();
		$sidebar_class = '';

		if( $sidebar_position != 'none' && is_active_sidebar( 'sidebar' ) ) {
			if( $sidebar_position == 'left' ) {
				if( $is_sticky == true ) {
					$sidebar_class = 'col-lg-4 col-md-12 order-lg-1 order-md-12 order-sm-12 order-12 cd-stickysidebar';
				} else {
					$sidebar_class = 'col-lg-4 col-md-12 order-lg-1 order-md-12 order-sm-12 order-12';
				}
			} else {
				if( $is_sticky == true ) {
					$sidebar_class = 'col-lg-4 col-md-12 col-sm-12 col-12 cd-stickysidebar';
				} else {
					$sidebar_class = 'col-lg-4 col-md-12 col-sm-12 col-12';
				}
			}
		}

		return $sidebar_class;
	}
}

/*
 * Function for post thumbnail
 */
if ( ! function_exists( 'cream_blog_post_thumbnail' ) ) {
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function cream_blog_post_thumbnail() {
		
		if ( post_password_required() || is_attachment() ) {
			return;
		}

		if( is_home() ) {
			$thumbnail = '';
			$thumbnail_url = '';
			$blog_list_layout = cream_blog_get_option( 'cream_blog_select_blog_post_list_layout' );
			if( $blog_list_layout == 'list_1' ) {
				$thumbnail = 'cream-blog-thumbnail-two';
			} else if( $blog_list_layout == 'list_3' ) {
				$thumbnail = 'cream-blog-thumbnail-one';
			} else {
				$thumbnail = 'full';
			}
			if( has_post_thumbnail() ) {

				$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), $thumbnail );
				?>
				<div class="thumb <?php cream_blog_parent_lazyload_class(); ?>">
					<?php
			
					if( $blog_list_layout == 'list_5' ) {
						?>
						<a class="bricks-gallery vbox-item" data-gall="myGallery" href="<?php echo esc_url( $thumbnail_url ); ?>">
						<?php
					} else {
						?>
						<a href="<?php the_permalink(); ?>">
						<?php
					}

					if( cream_blog_get_option( 'cream_blog_enable_lazyload' ) == true ) {
						?>
			            <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo esc_url( $thumbnail_url ); ?>" data-srcset="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
			            <noscript>
			                <img src="<?php echo esc_url( $thumbnail_url ); ?>" srcset="<?php echo esc_url( $thumbnail_url ); ?>" class="image-fallback" alt="<?php the_title_attribute(); ?>">
			            </noscript>
			            <?php
			        } else {
			        	?>
			        	<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
			        	<?php
			        }
			        ?>
			        </a>
			    </div>
				<?php
			}
		}

		if( is_archive() ) {
			$thumbnail = 'full';
			$thumbnail_url = '';
			
			if( has_post_thumbnail() ) {

				$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), $thumbnail );			
				?>
				<div class="thumb <?php cream_blog_parent_lazyload_class(); ?>">
					<a href="<?php the_permalink(); ?>">
						<?php
						if( cream_blog_get_option( 'cream_blog_enable_lazyload' ) == true ) {
							?>
				            <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo esc_url( $thumbnail_url ); ?>" data-srcset="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
				            <noscript>
				                <img src="<?php echo esc_url( $thumbnail_url ); ?>" srcset="<?php echo esc_url( $thumbnail_url ); ?>" class="image-fallback" alt="<?php the_title_attribute(); ?>">
				            </noscript>
				            <?php
				        } else {
				        	?>
				        	<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
				        	<?php
				        }
				        ?>
			        </a>
			    </div>
				<?php
			}
		}

		if( is_search() ) {
			$thumbnail_url = '';
			if( has_post_thumbnail() ) {
				$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				?>
				<div class="thumb <?php cream_blog_parent_lazyload_class(); ?>">
					<a href="<?php the_permalink(); ?>">
						<?php
						if( cream_blog_get_option( 'cream_blog_enable_lazyload' ) == true ) {
							?>
				            <img class="lazyload" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo esc_url( $thumbnail_url ); ?>" data-srcset="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
				            <noscript>
				                <img src="<?php echo esc_url( $thumbnail_url ); ?>" srcset="<?php echo esc_url( $thumbnail_url ); ?>" class="image-fallback" alt="<?php the_title_attribute(); ?>">
				            </noscript>
				            <?php
				        } else {
				        	?>
				        	<img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
				        	<?php
				        }
				        ?>
			        </a>
			    </div>
				<?php
			}
		}

		if( is_single() || is_page() ) {
			if( has_post_thumbnail() ) {
				$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				?>
				<div class="single-thumbnail">
                    <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php the_title_attribute(); ?>">
                </div><!-- .thumb.lazyloading -->
				<?php
			}
		}
	}
}


/**
 * Function to define element lazyload class
 */
if( ! function_exists( 'cream_blog_lazyload_class' ) ) {

	function cream_blog_lazyload_class() {

		$lazyload_class = '';

		if( cream_blog_get_option( 'cream_blog_enable_lazyload' ) == true ) {
			$lazyload_class = 'lazyload';
		}

		if( !empty( $lazyload_class ) ) {

			echo esc_attr( $lazyload_class );
		}
	} 
}


/**
 * Function to define parent element lazyload class
 */
if( ! function_exists( 'cream_blog_parent_lazyload_class' ) ) {

	function cream_blog_parent_lazyload_class() {

		$parent_lazyload_class = '';

		if( cream_blog_get_option( 'cream_blog_enable_lazyload' ) == true ) {
			$parent_lazyload_class = 'lazyloading';
		}

		if( !empty( $parent_lazyload_class ) ) {

			echo esc_attr( $parent_lazyload_class );
		}
	} 
}


/*
 * Function to define main navigation menu id for stikcy menu bar
 */
if( ! function_exists( 'cream_blog_main_menu_sticky_id' ) ) {

	function cream_blog_main_menu_sticky_id() {

		$is_sticky_menu_bar = cream_blog_get_option( 'cream_blog_enable_sticky_menu' );
		$stick_menu_id = '';
		if( $is_sticky_menu_bar == true ) {
			$stick_menu_id = 'cb-stickhead';
		}

		return $stick_menu_id;
	}
}


/*
 * Function to get sidebar for woocommerce pages.
 */
if( ! function_exists( 'cream_blog_woocommerce_sidebar' ) ) {

	function cream_blog_woocommerce_sidebar() {

		if( class_exists( 'Woocommerce' ) ) {
			if( is_active_sidebar( 'woocommerce-sidebar' ) ) {
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



/**
* Filter for default archive widget
*/

function cream_blog_default_archive_widget($links) {

    $links = str_replace('</a>&nbsp;(', '</a> <span class="count">(', $links);
    $links = str_replace(')', ')</span>', $links);
    return $links;
}

add_filter('get_archives_link', 'cream_blog_default_archive_widget');


/**
 * Filter the default categories widget
 */

function cream_blog_cat_count_span( $links ) {

    $links = str_replace( '</a> (', '</a><span class="count">(', $links );
    $links = str_replace( ')', ')</span>', $links );
    return $links;
}
add_filter( 'wp_list_categories', 'cream_blog_cat_count_span' );