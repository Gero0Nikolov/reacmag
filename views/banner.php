<?php
/*
*   View: Homepage banner
*/

$page_id = get_the_ID();
$admin_elements = get_field( "slider_posts", $page_id );

$slider_elements = array();

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
			"value" => 681, // The slider promo plan
			"compare" => "="
		)
	)
);
$user_promo_plans = get_posts( $args );
$count_user_promo_plans = count( $user_promo_plans );

foreach ( $user_promo_plans as $plan_ ) {
	$promotion_post = get_post_meta( $plan_->ID, "promotion_post", true );
	$slider_elements[] = get_post( $promotion_post );
}

if ( $count_user_promo_plans < 10 ) {
	$count_slides = $count_user_promo_plans;
	$slider_pointer = 0;
	while ( $count_slides < 10 ) {
		if ( isset( $admin_elements[ $slider_pointer ] ) && !empty( $admin_elements[ $slider_pointer ] ) ) {
			$slider_elements[] = $admin_elements[ $slider_pointer ];
		}
		$slider_pointer += 1;
		$count_slides += 1;
	}
}

// Shuffle the slides
shuffle( $slider_elements );
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
			<a href="<?php echo $post_url; ?>" class="post-anchor">Read it!</a>
			<div class="content">
                <a href="<?php echo $post_url; ?>" class="inline-post-anchor">
					<h1 class="header"><?php echo $post_title; ?></h1>
				</a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
