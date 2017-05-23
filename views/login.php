<?php
/*
*   View: About Us All
*/

$page_id = get_the_ID();
$page_ = get_post( $page_id );
$featured_posts = get_field( "featured_posts", $page_id );
?>
<div class="account-options">
	<div id="login-form" class="login">
		<h1 class="form-title">Login</h1>
		<input type="email" id="email" placeholder="Email">
		<input type="password" id="password" placeholder="Password">
		<button id="login-button" class="login-button button simple-button animated infinite">Login</button>
	</div>
	<div id="registration-form" class="register">
		<h1 class="form-title">Register</h1>
		<input type="email" id="email" placeholder="Email">
		<input type="text" id="username" placeholder="Username">
		<input type="password" id="password" placeholder="Password">
		<button id="register-button" class="register-button button simple-button animated infinite">Register</button>
	</div>
</div>
<div class="quote"><?php echo html_entity_decode( $page_->post_content ); ?></div>
