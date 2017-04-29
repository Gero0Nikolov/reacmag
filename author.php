<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Reactive_Magazine
 */

get_header();

$author_ = get_user_by( 'slug', get_query_var( 'author_name' ) );
$author_avatar = get_avatar( $author_->ID, 148 );
$author_posts = count_user_posts( $author_->ID );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php echo $author_->display_name; ?></h1>
				<p class="user-meta">
					<span class="meta"><?php echo $author_posts ." "; echo $author_posts != 1 ? "posts" : "post"; ?></span>
					<span class="dotter">&bull;</span>
					<span class="meta">
						<a href="<?php echo $author_->user_url; ?>" target="_blank" class="meta-link"><?php echo $author_->user_url; ?></a>
					</span>
				</p>
				<?php echo $author_avatar; ?>
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
