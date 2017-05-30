<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Reactive_Magazine
 */

get_header();

$admin_featured_posts = get_field( "featured_posts", 655 ); // Featured posts from Search page controller

$featured_posts = array();

// Get promotions
$args = array(
	"posts_per_page" => 8,
	"post_type" => "user_plan",
	"post_status" => "publish",
	"orderby" => "rand",
	"order" => "ASC",
	"meta_query" => array(
		"relation" => "AND",
		array(
			"key" => "promotion_active_period",
			"value" => strtotime( date( "Y-m-d" ) ),
			"compare" => ">"
		),
		array(
			"key" => "promotion_plan",
			"value" => 676, // The slider promo plan
			"compare" => "="
		),
		array(
			"key" => "promotion_post",
			"value" => "",
			"compare" => "!="
		)
	)
);
$user_promo_plans = get_posts( $args );
$count_user_promo_plans = count( $user_promo_plans );

foreach ( $user_promo_plans as $plan_ ) {
	$promotion_post = get_post_meta( $plan_->ID, "promotion_post", true );
	$featured_posts[] = get_post( $promotion_post );
}

if ( $count_user_promo_plans < 10 ) {
	$count_slides = $count_user_promo_plans;
	$posts_pointer = 0;
	while ( $count_posts < 10 ) {
		if ( isset( $admin_featured_posts[ $posts_pointer ] ) && !empty( $admin_featured_posts[ $posts_pointer ] ) ) {
			$featured_posts[] = $admin_featured_posts[ $posts_pointer ];
		}
		$posts_pointer += 1;
		$count_posts += 1;
	}
}

// Shuffle the slides
shuffle( $featured_posts );
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<div class='owl-carousel owl-theme'>

			<?php
			foreach ( $featured_posts as $post_ ) {
				$post_url = get_permalink( $post_->ID );
				$post_featured_image = get_the_post_thumbnail_url( $post_->ID, "full" );
				?>

				<div class='related-item' style='background-image: url(<?php echo $post_featured_image; ?>);'>
					<a href='<?php echo $post_url; ?>' class='post-anchor'>
						<h1 class='post-title'><?php echo $post_->post_title; ?></h1>
					</a>
				</div>

				<?php
			}
			?>

			</div>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'reacmag' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				$post_id = get_the_ID();
				$post_url = get_permalink( $post_id );
				$post_featured_image = get_the_post_thumbnail_url( $post_id, "full" );
				$post_content = get_the_content();
				$post_excerpt = wp_trim_words( $post_content, "55", "..." );
				$post_title = get_the_title();

				?>

				<a href="<?php echo $post_url; ?>" class="post-anchor">
					<div id="post-<?php echo $post_id; ?>" class="post-container">
						<div class="content">
							<h1 class="title"><?php echo $post_title; ?></h1>
							<div class="text"><?php echo $post_excerpt; ?></div>
						</div>
						<div class="featured-image" style="background-image: url(<?php echo $post_featured_image; ?>);"></div>
					</div>
				</a>

				<?php

			endwhile;

		else :

			get_template_part( 'template-parts/content', 'none' );

			?>

			<h1 class="page-title">Read also:</h1>
			<div id="featured-posts" class="featured-posts">

			<?php
			foreach ( $featured_posts as $post_ ) {
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

			<?php
		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
