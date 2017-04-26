<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Reactive_Magazine
 */

get_header();

$post_id = get_the_ID();
$post_featured_image = get_the_post_thumbnail_url( $post_id, "url" );
$post_categories = wp_get_post_categories( $post_id );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main post-area" role="main">
			<?php if ( $post_featured_image !== false ) { ?><div id="featured-image" class="featured-image" style="background-image: url(<?php echo $post_featured_image ?>);"></div><?php } ?>

			<?php
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/content', get_post_format() );

				get_related_posts( $post_id, $post_categories, true );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
