<?php
/*
*   View: Contact Us All
*/

$page_id = get_the_ID();
$page_ = get_post( $page_id );
?>
<div class="contact-us">
	<h1 class="title"><?php echo $page_->post_title; ?></h1>
	<div class="content">
		<?php echo do_shortcode( $page_->post_content ); ?>
	</div>
</div>
