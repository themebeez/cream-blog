<?php
/**
 * Template part for displaying banner layout eight
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cream_Blog
 */

$cream_blog_banner_query = cream_blog_banner_query();

if ( $cream_blog_banner_query->have_posts() ) {
	?>
	<div class="cb-banner cb-banner-style-6">
		<div class="banner-inner">
			<div class="cb-container">
				<div class="row">
					<?php
					$count = 0;

					while ( $cream_blog_banner_query->have_posts() ) {

						$cream_blog_banner_query->the_post();

						if ( $count < 1 ) {

							$thumbnail_url = '';

							if ( has_post_thumbnail() ) {

								$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'cream-blog-thumbnail-four' );
								?>
								<div class="col-lg-8 col-md-8 col-sm-12 left-gutter">
									<div
										class="thumb"
										style="background-image: url(<?php echo esc_url( $thumbnail_url ); ?>);"
									>
										<div class="post-contents">
											<?php cream_blog_post_categories_meta(); ?>
											<div class="post-title">
												<h2>
													<a href="<?php the_permalink(); ?>">
														<?php the_title(); ?>
													</a>
												</h2>
											</div><!-- .post-title -->
											<?php cream_blog_post_meta( true, true, false ); ?>
										</div><!-- .post-contents -->
										<div class="mask"></div><!-- .mask -->
									</div><!-- .thumb.lazyload -->
								</div><!-- .col-* -->
								<?php
							}
						}
						$count++;
					}
					wp_reset_postdata();
					?>
					<div class="col-lg-4 col-md-4 col-sm-12 right-gutter">
						<div class="owl-carousel" id="cb-slider-style-6">
							<?php
							$count = 0;

							while ( $cream_blog_banner_query->have_posts() ) {

								$cream_blog_banner_query->the_post();

								if ( $count >= 1 ) {

									$thumbnail_url = '';

									if ( has_post_thumbnail() ) {

										$thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'cream-blog-thumbnail-five' );
										?>
										<div class="item">
											<div
												class="thumb"
												style="background-image: url(<?php echo esc_url( $thumbnail_url ); ?>);"
											>
												<div class="post-contents">
													<?php cream_blog_post_categories_meta(); ?>
													<div class="post-title">
														<h2>
															<a href="<?php the_permalink(); ?>">
																<?php the_title(); ?>
															</a>
														</h2>
													</div><!-- .post-title -->
													<?php cream_blog_post_meta( true, true, false ); ?>
												</div><!-- .post-contents -->
												<div class="mask"></div><!-- .mask -->
											</div><!-- .thumb.lazyload -->
										</div><!-- .item -->
										<?php
									}
								}
								$count++;
							}
							wp_reset_postdata();
							?>
						</div><!-- #cb-slider-style-6.owl-carousel -->
					</div><!-- .col-* -->
				</div><!-- .row -->
			</div><!-- .cb-container -->
		</div><!-- .banner-inner -->
	</div><!-- .cb-banner.cb-banner-style-6 -->
	<?php
}
