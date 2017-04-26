<?php
/*
*   View: Homepage content
*/

$page_id = get_the_ID();
$featured_posts = get_field( "featured_posts", $page_id );
$featured_post = get_field( "featured_post", $page_id )[0];
$featured_category = get_field( "featured_category", $page_id );
?>
<div class="homepage-content">
    <div id="featured-posts" class="small-boxes">
        <?php
        foreach ( $featured_posts as $post_ ) {
            $post_url = get_permalink( $post_->ID );
            $post_title = $post_->post_title;
            $post_excerpt = wp_trim_words( $post_->post_content, "20", "..." );
            $post_featured_image = get_the_post_thumbnail_url( $post_->ID, "full" );
        ?>
        <a href="<?php echo $post_url; ?>" class="post-anchor">
            <div class="box" style="background-image: url(<?php echo $post_featured_image; ?>);">
                <h1 class="box-header"><?php echo $post_title; ?></h1>
                <div class="content"><?php echo $post_excerpt; ?></div>
            </div>
        </a>
        <?php } ?>
    </div>
    <div id="last-post" class="full-width-box">
        <?php
        $featured_post_url = get_permalink( $featured_post->ID );
        $featured_post_excerpt = wp_trim_words( $featured_post->post_content, "35", "..." );
        $featured_post_featured_image = get_the_post_thumbnail_url( $featured_post->ID, "full" );
        ?>
        <div class="content">
            <h1 class="header"><?php echo $featured_post->post_title; ?></h1>
            <div class="text">
                <p><?php echo $featured_post_excerpt; ?></p>
            </div>
            <a href="<?php echo $featured_post_url; ?>" class="read-more">Read it!</a>
        </div>
        <div class="featured-image" style="background-image: url(<?php echo $featured_post_featured_image; ?>);">
        </div>
    </div>
    <div id="featured-category" class="featured-category">
        <?php
        $featured_category_name = get_cat_name( $featured_category );

        $args = array(
            "posts_per_page" => 4,
            "post_type" => "post",
            "post_status" => "publish",
            "orderby" => "ID",
            "order" => "DESC",
            "category" => $featured_category
        );
        $posts_ = get_posts( $args );
        ?>
        <h1 class="header"><?php echo $featured_category_name; ?>:</h1>
        <div class="tiny-boxes">
            <?php
            foreach ( $posts_ as $post_ ) {
                $post_url = get_permalink( $post_->ID );
                $post_featured_image = get_the_post_thumbnail_url( $post_->ID, "full" );
            ?>
            <a href="<?php echo $post_url; ?>" class="post-anchor" style="background-image: url(<?php echo $post_featured_image; ?>);">
                <div class="box">
                    <h1 class="box-header"><?php echo $post_->post_title; ?></h1>
                </div>
            </a>
            <?php } ?>            
        </div>
    </div>
</div>
