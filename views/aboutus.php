<?php
/*
*   View: About Us All
*/

$page_id = get_the_ID();
$page_ = get_post( $page_id );
$page_featured_image = get_the_post_thumbnail_url( $page_id, "full" );
?>

<div class="page-featured-image" style="background-image: url(<?php echo $page_featured_image; ?>);">
	<h1 class="page-title"><?php echo $page_->post_title; ?></h1>
</div>
<div class="page-content">
	<?php echo $page_->post_content; ?>
</div>
<div class="founders-section">
	<?php
	$args = array(
		"role" => "administrator"
	);
	$administrators_ = get_users( $args );

	foreach ( $administrators_ as $administrator_ ) {
		$administrator_url = get_author_posts_url( $administrator_->ID );
		$administrator_bio = get_the_author_meta( "description", $administrator_->ID );
		$administrator_avatar = get_avatar( $administrator_->ID, 128 );
		?>

		<a href="<?php echo $administrator_url; ?>" class="administrator-anchor">
			<div id="administrator-<?php echo $administrator_->ID; ?>" class="administrator">
				<div class="header">
					<h1 class="name"><?php echo $administrator_->display_name; ?></h1>
					<?php echo $administrator_avatar; ?>
				</div>
				<div class="content"><?php echo $administrator_bio; ?></div>
			</div>
		</a>

		<?php
	}
	?>
</div>
