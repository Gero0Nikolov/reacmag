<?php
/*
*   Template name: Login Page
*/

if ( !is_user_logged_in() ) {
get_header();

require_once get_view( "login.php" );

get_footer();
} else { wp_redirect( get_site_url() ."/my-profile" ); }
?>
