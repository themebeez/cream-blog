<?php
/**
 * The template for displaying related posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Cream_Blog
 */

$cream_blog_enable_related_posts = cream_blog_get_option( 'cream_blog_enable_related_section' );
$cream_blog_section_title        = cream_blog_get_option( 'cream_blog_related_cream_blog_section_title' );
$cream_blog_related_posts_no     = (int) cream_blog_get_option( 'cream_blog_related_section_posts_number' );
$cream_blog_related_posts_by     = cream_blog_get_option( 'cream_blog_related_posts_by' );

$cream_blog_related_posts_query_args = array(
	'no_found_rows'       => true,
	'ignore_sticky_posts' => true,
	'posts_per_page'      => ( $cream_blog_related_posts_no > 0 ) ? $cream_blog_related_posts_no : 6,
);

$current_object = get_queried_object();

if ( $current_object instanceof WP_Post ) {

	$current_id = $current_object->ID;

	if ( absint( $current_id ) > 0 ) {
		// Exclude current post.
		$cream_blog_related_posts_query_args['post__not_in'] = array( absint( $current_id ) );

		if ( 'category' === $cream_blog_related_posts_by ) {
			// Include current posts categories.
			$categories = wp_get_post_categories( $current_id );
			if ( ! empty( $categories ) ) {
				$cream_blog_related_posts_query_args['tax_query'] = array( // phpcs:ignore
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $categories,
						'operator' => 'IN',
					),
				);
			}
		}

		if ( 'tag' === $cream_blog_related_posts_by ) {
			// Include current posts tags.
			$tags = wp_get_post_tags( $current_id );

			$post_tags = array();

			foreach ( $tags as $post_tag ) {
				$post_tags[] = $post_tag->term_id;
			}

			if ( ! empty( $tags ) ) {
				$cream_blog_related_posts_query_args['tax_query'] = array( // phpcs:ignore
					array(
						'taxonomy' => 'post_tag',
						'field'    => 'term_id',
						'terms'    => $post_tags,
						'operator' => 'IN',
					),
				);
			}
		}

		if (
			'both_and' === $cream_blog_related_posts_by ||
			'both_or' === $cream_blog_related_posts_by
		) {
			// Include current posts categories.
			$categories = wp_get_post_categories( $current_id );
			// Include current posts tags.
			$tags = wp_get_post_tags( $current_id );

			$post_tags = array();

			foreach ( $tags as $post_tag ) {
				$post_tags[] = $post_tag->term_id;
			}

			$relation = 'AND';

			if ( 'both_and' === $cream_blog_related_posts_by ) {
				$relation = 'AND';
			}

			if ( 'both_or' === $cream_blog_related_posts_by ) {
				$relation = 'OR';
			}

			if ( ! empty( $tags ) ) {
				$cream_blog_related_posts_query_args['tax_query'] = array( // phpcs:ignore
					'relation' => $relation,
					array(
						'taxonomy' => 'post_tag',
						'field'    => 'term_id',
						'terms'    => $post_tags,
						'operator' => 'IN',
					),
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $categories,
						'operator' => 'IN',
					),
				);
			}
		}
	}
}

$cream_blog_related_posts = new WP_Query( $cream_blog_related_posts_query_args );

if (
	$cream_blog_related_posts->have_posts() &&
	true === $cream_blog_enable_related_posts
) {
	?>
	<div class="related-posts">
		<?php
		if ( ! empty( $cream_blog_section_title ) ) {
			?>
			<div class="block-title">
				<h3><?php echo esc_html( $cream_blog_section_title ); ?></h3>
			</div><!-- .block-title -->
			<?php
		}
		?>
		<div class="cb-recent-posts cb-grid-style-4">
			<div class="section-contants">
				<div class="row">
					<?php
					while ( $cream_blog_related_posts->have_posts() ) {

						$cream_blog_related_posts->the_post();

						$sidebar_position     = cream_blog_sidebar_position();
						$post_container_class = '';
						if (
							'none' !== $sidebar_position &&
							is_active_sidebar( 'sidebar' )
						) {
							$post_container_class = 'col-lg-6 col-md-6 col-sm-12 col-12';
						} else {
							$post_container_class = 'col-lg-4 col-md-4 col-sm-12 col-12';
						}
						?>
						<div class="<?php echo esc_attr( $post_container_class ); ?>">
							<article class="cb-post-box">
								<?php
								$thumbnail     = 'cream-blog-thumbnail-three';
								$thumbnail_url = '';
								if ( has_post_thumbnail() ) {
									$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), $thumbnail );
									?>
									<div class="thumb">
										<a href="<?php the_permalink(); ?>">
											<img
												src="<?php echo esc_url( $thumbnail_url ); ?>"
												alt="<?php the_title_attribute(); ?>"
											>
										</a>
									</div><!-- .thumb.lazyloading -->
									<?php
								}
								?>
								<div class="post-contents">
									<?php cream_blog_post_categories_meta(); ?>
									<div class="post-title">
										<h3>
											<a href="<?php the_permalink(); ?>">
												<?php the_title(); ?>
											</a>
										</h3>
									</div><!-- .post-title -->
								</div><!-- .post-contents -->
							</article><!-- .cb-post-box -->
						</div>
						<?php
					}
					wp_reset_postdata();
					?>
				</div><!-- .row -->
			</div><!-- .section-contants -->
		</div><!-- .cb-recent-posts.cb-grid-style-4 -->
	</div><!-- .related-posts -->
	<?php
}
