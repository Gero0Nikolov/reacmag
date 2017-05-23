<?php
/*
*   Template name: My Profile Page
*/

if ( is_user_logged_in() ) {
	get_header();

	require_once get_view( "my-profile.php" );

	get_footer();
} else { wp_redirect( get_site_url() ."/login" ); }
?>
