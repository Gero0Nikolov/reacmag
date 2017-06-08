<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Reactive_Magazine
 */
 $device_ = wp_is_mobile() ? "mobile" : "desktop" ;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Yellowtail" rel="stylesheet">

<script type="text/javascript">
var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>

<?php wp_head(); ?>
</head>

<body <?php body_class( $device_ ); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'reacmag' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div id="sticky-bar" class="sticky-bar">
			<div class="left">
				<button id="search-controller" class="button simple-button">Search</button>
			</div>
			<div class="middle">
				<?php if ( !is_user_logged_in() ) { ?>
				<a href="<?php echo get_site_url(); ?>" class="logo-anchor">
					<img src="<?php echo get_site_icon_url(); ?>" class="logo" />
				</a>
				<?php } else {
					$user_ = get_currentuserinfo();
					?>
				<a href="<?php echo get_site_url(); ?>/my-profile" class='logo-anchor username'><?php echo $user_->user_login; ?></a>
				<?php } ?>
			</div>
			<div class="right">
				<button id="menu-controller" class="button simple-button menu-controller">
					<span class="bar"></span>
					<span class="bar"></span>
					<span class="bar"></span>
				</button>
			</div>
		</div>
	</header><!-- #masthead -->

	<div id="global-menu" class="global-menu">
		<button id="menu-closer" class="close-button">
			<span class="bar"></span>
			<span class="bar"></span>
		</button>
		<div id="menu" class="menu-holder">
			<?php
			if ( is_user_logged_in() ) { wp_nav_menu( array( "menu" => "57" ) ); }
			else { wp_nav_menu( array( "menu" => "2" ) ); }
			?>
		</div>
	</div>

	<div id="global-search" class="global-search">
		<button id="search-closer" class="close-button">
			<span class="bar"></span>
			<span class="bar"></span>
		</button>
		<?php get_search_form( true ); ?>
	</div>

	<div id="content" class="site-content animated fadeIn">
