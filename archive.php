<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Reactive_Magazine
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div id="posts-list" class="posts-list">
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				$post_id = get_the_ID();
				$post_featured_image = get_the_post_thumbnail_url( $post_id );
				?>

				<a href="<?php echo the_permalink(); ?>" class="post-anchor">
					<div id="post-<?php echo $post_id; ?>" class="animated fadeInUp post-container" style="background-image: url( <?php echo $post_featured_image; ?> );">
						<h1 class="post-title"><?php echo the_title(); ?></h1>
					</div>
				</a>

				<?php
			endwhile;
			?>
			</div>

			<?php
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
