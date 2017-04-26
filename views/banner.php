<?php
/*
*   View: Homepage banner
*/

$page_id = get_the_ID();
$slider_elements = get_field( "slider_posts", $page_id );
?>
<div class="banner">
    <div class="owl-carousel owl-theme owl-loaded">
        <?php
        foreach ( $slider_elements as $element_ ) {
            $post_title = $element_->post_title;
            $post_url = get_permalink( $element_->ID );
            $post_featured_image = get_the_post_thumbnail_url( $element_->ID, "full" );
        ?>
        <div class="owl-item" style="background-image: url(<?php echo $post_featured_image; ?>);">
            <div class="content">
                <h1 class="header"><?php echo $post_title; ?></h1>
                <a href="<?php echo $post_url; ?>" class="post-anchor">Read it!</a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
