<?php
/*
*   View: Promote Page All
*/

$page_id = get_the_ID();
$page_header = get_field( "header", $page_id );
$page_plans = get_field( "plans", $page_id );
?>
<div class="promote">
	<h1 class="title"><?php echo $page_header; ?></h1>
	<div class="plans">
		<div class="row">
		<?php
		$plan_count = 0;
		foreach ( $page_plans as $plan_id ) {
			$plan_background = get_field( "plan_background", $plan_id );
			$plan_title = get_the_title( $plan_id );
			$plan_description = get_field( "plan_description", $plan_id );
			$plan_price = get_field( "plan_price", $plan_id );
			?>

			<div class="plan" style="background-image: url(<?php echo $plan_background; ?>);">
				<h1 class="plan-title"><?php echo $plan_title; ?></h1>
				<div class="plan-description"><?php echo $plan_description; ?></div>
				<button id="buy-controller" class="button buy-button" promotion-id="<?php echo $plan_id; ?>">Buy &euro;<?php echo $plan_price; ?></button>
			</div>

			<?php
			$plan_count += 1;

			if ( $plan_count == 2 ) {
				$plan_count = 0;
				?>

				</div>
				<div class="row">

				<?php
			}
		}
		?>
		</div>
	</div>
</div>
