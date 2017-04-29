<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Reactive_Magazine
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title">Whooah... There's nothing here!</h1>
					<h2 class="page-subtitle">Take a look at these fine posts instead:</h2>
				</header><!-- .page-header -->

				<div class="page-content">
					<div class="featured-posts">
						<?php
						$args = array(
							"posts_per_page" => 10,
							"post_type" => "post",
							"post_status" => "publish",
							"orderby" => "ID",
							"order" => "DESC",
						);
						$posts_ = get_posts( $args );

						foreach ( $posts_ as $post_ ) {
							$post_url = get_permalink( $post_->ID );
							$post_featured_image = get_the_post_thumbnail_url( $post_->ID, "full" );
							?>

							<a href="<?php echo $post_url; ?>" class="post-anchor">
								<div id="post-<?php echo $post_->ID; ?>" class="post-container" style="background-image: url(<?php echo $post_featured_image; ?>);">
									<h1 class="post-title"><?php echo $post_->post_title; ?></h1>
								</div>
							</a>

							<?php
						}
						?>
					</div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
