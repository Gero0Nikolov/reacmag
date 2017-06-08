<?php
/**
 * Reactive Magazine functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Reactive_Magazine
 */

if ( ! function_exists( 'reacmag_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function reacmag_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Reactive Magazine, use a find and replace
	 * to change 'reacmag' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'reacmag', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'reacmag' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'reacmag_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'reacmag_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function reacmag_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'reacmag_content_width', 640 );
}
add_action( 'after_setup_theme', 'reacmag_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function reacmag_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'reacmag' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'reacmag' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'reacmag_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function reacmag_scripts() {
	wp_enqueue_style( 'reacmag-style', get_stylesheet_uri() );
	wp_enqueue_style( 'reacmag-animate', get_template_directory_uri() . "/animate.css" );
	wp_enqueue_style( 'reacmag-font-awesome', get_template_directory_uri() . "/css/font-awesome/css/font-awesome.min.css" );
	wp_enqueue_style( 'reacmag-owl-carousel', get_template_directory_uri() . "/js/owl-carousel/dist/assets/owl.carousel.min.css" );
	wp_enqueue_style( 'reacmag-owl-carousel-theme', get_template_directory_uri() . "/js/owl-carousel/dist/assets/owl.theme.default.min.css" );

	wp_enqueue_script( 'reacmag-initial', get_template_directory_uri() . '/js/initial.js', array( "jquery" ), "", true );
	wp_enqueue_script( 'reacmag-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'reacmag-owl-carousel-script', get_template_directory_uri() . '/js/owl-carousel/dist/owl.carousel.js', array( "jquery" ), "", true );

	wp_enqueue_script( 'reacmag-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'reacmag_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

function get_view( $view_name ) {
	return get_template_directory() . "/views/". $view_name;
}

function get_related_posts( $this_post, $categories_, $echo = false ) {
	$posts_ = array();
	foreach ( $categories_ as $category_id ) {
		$args = array(
			"posts_per_page" => 4,
			"post_type" => "post",
			"post_status" => "publish",
			"orderby" => "ID",
			"order" => "DESC",
			"post__not_in" => array( $this_post ),
			"category" => $category_id
		);
		$posts_ = array_merge( $posts_, get_posts( $args ) );
	}

	if ( !$echo ) { return $posts_; }
	else {
		if ( !empty( $posts_ ) ) {
			echo "<div class='owl-carousel owl-theme'>";
			foreach ( $posts_ as $post_ ) {
				if ( $post_->ID != $this_post ) {
					$post_url = get_permalink( $post_->ID );
					$post_featured_image = get_the_post_thumbnail_url( $post_->ID );

					echo "
					<div class='related-item' style='background-image: url($post_featured_image);'>
						<a href='$post_url' class='post-anchor'>
							<h1 class='post-title'>$post_->post_title</h1>
						</a>
					</div>
					";
				}
			}
			echo "</div>";
		}
	}
}

add_action( 'wp_ajax_nopriv_buy_promotion', 'buy_promotion' );
add_action( 'wp_ajax_buy_promotion', 'buy_promotion' );
function buy_promotion() {
	$promotion_id = isset( $_POST[ "promotion_id" ] ) && !empty( $_POST[ "promotion_id" ] ) ? intval( $_POST[ "promotion_id" ] ) : 0;

	if ( is_int( $promotion_id ) && $promotion_id > 0 ) {
		if ( is_user_logged_in() ) {
			$terms_conditions_page = get_page_by_path( "terms-conditions", OBJECT, "page" );
			$paypal_settings = get_page_by_path( "paypal-payments-controller", OBJECT, "page" );

			$response_ = new stdClass;
			$response_->terms_conditions = new stdClass;
			$response_->terms_conditions->title = $terms_conditions_page->post_title;
			$response_->terms_conditions->content = nl2br( $terms_conditions_page->post_content );
			$response_->paypal = new stdClass;
			$response_->paypal->environment = get_post_meta( $paypal_settings->ID, "paypal_environment", true );
			$response_->paypal->client_sandbox_id = get_post_meta( $paypal_settings->ID, "paypal_client_id_sandbox", true );
			$response_->paypal->client_production_id = get_post_meta( $paypal_settings->ID, "paypal_client_id_production", true );
			$response_->plan = new stdClass;
			$response_->plan->id = $promotion_id;
			$response_->plan->title = get_the_title( $promotion_id );
			$response_->plan->price = get_post_meta( $promotion_id, "plan_price", true );

			echo json_encode( $response_ );
		} else { echo json_encode( "login-action" ); }
	} else { echo json_encode( "Don't try to hack ;)" ); }

	die( "" );
}

add_action( 'wp_ajax_nopriv_add_promotion_to_user', 'add_promotion_to_user' );
add_action( 'wp_ajax_add_promotion_to_user', 'add_promotion_to_user' );
function add_promotion_to_user() {
	$promotion_id = isset( $_POST[ "promotion_id" ] ) && !empty( $_POST[ "promotion_id" ] ) ? intval( $_POST[ "promotion_id" ] ) : 0;

	if ( is_int( $promotion_id ) && $promotion_id > 0 ) {
		$user_id = get_current_user_id();

		$args = array(
			"posts_per_page" => 1,
			"post_type" => "user_plan",
			"post_status" => "publish",
			"author" => $user_id,
			"meta_key" => "promotion_plan",
			"meta_value" => $promotion_id,
			"meta_compare" => "="
		);
		$plans_ = get_posts( $args );

		$result_ = "saved";

		if ( count( $plans_ ) > 0 ) {
			$promotion_active_period = strtotime( "+7 day", strtotime( date( "Y-m-d" ) ) );
			update_post_meta( $plans_[ 0 ]->ID, "promotion_active_period", $promotion_active_period );
		} else {
			$title_ = get_the_title( $promotion_id ) ." ". get_user_meta( $user_id, "first_name", true ) ." ". $user_id;
			$post_arr = array(
				"ID" => 0,
				"post_type" => "user_plan",
				"post_status" => "publish",
				"post_title" => $title_,
				"post_name" => sanitize_text_field( $title_ ),
				"meta_input" => array(
					"promotion_plan" => $promotion_id,
					"promotion_active_period" => strtotime( "+7 day", strtotime( date( "Y-m-d" ) ) )
				)
			);
			$post_id = wp_insert_post( $post_arr );

			if ( is_wp_error( $post_id ) ) { $result_ = $post_id->get_error_message(); }
		}

		echo json_encode( $result_ );
	} else { echo json_encode( "Promotion ID is not set." ); }

	die( "" );
}

add_action( 'wp_ajax_nopriv_update_promotions', 'update_promotions' );
add_action( 'wp_ajax_update_promotions', 'update_promotions' );
function update_promotions() {
	if ( isset( $_POST[ "plans" ] ) && !empty( $_POST[ "plans" ] ) ) {
		$plans_ = $_POST[ "plans" ];

		foreach ( $plans_ as $plan_ ) {
			$plan_ = (object)$plan_;
			$plan_->plan_id = isset( $plan_->plan_id ) && !empty( $plan_->plan_id ) ? intval( $plan_->plan_id ) : 0;
			$plan_->post_id = isset( $plan_->post_id ) && !empty( $plan_->post_id ) ? intval( $plan_->post_id ) : 0;

			if ( is_int( $plan_->plan_id ) && $plan_->plan_id > 0 ) {
				update_post_meta( $plan_->plan_id, "promotion_post", $plan_->post_id );
			}
		}

		echo json_encode( "updated" );
	} else { echo json_encode( "Plans are not supplied!" ); }

	die( "" );
}

add_action( 'wp_ajax_nopriv_login_user', 'login_user' );
add_action( 'wp_ajax_login_user', 'login_user' );
function login_user() {
	if ( isset( $_POST[ "args" ] ) && !empty( $_POST[ "args" ] ) ) {
		$args_ = (object)$_POST[ "args" ];
		$args_->email = isset( $args_->email ) && !empty( $args_->email ) ? sanitize_text_field( $args_->email ) : "";
		$args_->password = isset( $args_->password ) && !empty( $args_->password ) ? sanitize_text_field( $args_->password ) : "";

		if ( isset( $args_->email ) && !empty( $args_->email ) && is_email( $args_->email ) ) {
			if ( isset( $args_->password ) && !empty( $args_->password ) ) {
				$result_ = "logged";

				$creds = array(
					"user_login" => $args_->email,
					"user_password" => $args_->password,
					"remember" => false
				);
				$user_ = wp_signon( $creds, false );
				if ( is_wp_error( $user_ ) ) { $result_ = "Your email or password is wrong!"; }

				echo json_encode( $result_ );
			} else { echo json_encode( "Password is not set properly!" ); }
		} else { echo json_encode( "Email is not set properly!" ); }
	} else { echo json_encode( "Arguments are not set!" ); }

	die( "" );
}

add_action( 'wp_ajax_nopriv_register_user', 'register_user' );
add_action( 'wp_ajax_register_user', 'register_user' );
function register_user() {
	if ( isset( $_POST[ "args" ] ) && !empty( $_POST[ "args" ] ) ) {
		$args_ = (object)$_POST[ "args" ];
		$args_->email = isset( $args_->email ) && !empty( $args_->email ) ? sanitize_text_field( $args_->email ) : "";
		$args_->username = isset( $args_->username ) && !empty( $args_->username ) ? sanitize_text_field( $args_->username ) : "";
		$args_->password = isset( $args_->password ) && !empty( $args_->password ) ? sanitize_text_field( $args_->password ) : "";

		if ( isset( $args_->email ) && !empty( $args_->email ) && is_email( $args_->email ) ) {
			if ( isset( $args_->username ) && !empty( $args_->username ) ) {
				if ( isset( $args_->password ) && !empty( $args_->password ) ) {
					$result_ = "registered";
					$registration_result = wp_create_user( $args_->username, $args_->password, $args_->email );

					if ( is_wp_error( $registration_result ) ) {
						$result_ = $registration_result->get_error_message();
					} else {
						$args = array(
							"ID" => $registration_result,
							"role" => "subscriber"
						);
						$update_results = wp_update_user( $args );
					}
					echo json_encode( $result_ );
				} else { echo json_encode( "Password is not correct!" ); }
			} else { echo json_encode( "Username is not correct!" ); }
		} else { echo json_encode( "Email address is not correct!" ); }
	} else { echo json_encode( "Arguments are not set!" ); }

	die( "" );
}

function remove_admin_bar() {
	if (
		!current_user_can('authors') &&
		!current_user_can('editors') &&
		!current_user_can('administrator') && !is_admin()
	) { show_admin_bar( false ); }
}
add_action('after_setup_theme', 'remove_admin_bar');

add_action( 'wp_ajax_nopriv_logout_user', 'logout_user' );
add_action( 'wp_ajax_logout_user', 'logout_user' );
function logout_user() {
	wp_logout();
	echo json_encode( "logout" );
	die( "" );
}

add_action( 'wp_ajax_nopriv_update_general_info', 'update_general_info' );
add_action( 'wp_ajax_update_general_info', 'update_general_info' );
function update_general_info() {
	if ( isset( $_POST[ "args" ] ) && !empty( $_POST[ "args" ] ) ) {
		$args_ = (object)$_POST[ "args" ];
		$args_->email = isset( $args_->email ) && !empty( $args_->email ) && is_email( $args_->email ) ? sanitize_text_field( $args_->email ) : "";
		$args_->password = isset( $args_->password ) && !empty( $args_->password ) ? sanitize_text_field( $args_->password ) : "";
		$args_->current_password = isset( $args_->current_password ) && !empty( $args_->current_password ) ? sanitize_text_field( $args_->current_password ) : "";

		$user_id = get_current_user_id();
		$user_ = get_user_by( "ID", $user_id );

		if ( $user_ && wp_check_password( $args_->current_password, $user_->data->user_pass, $user_id ) ) {
			$user_data = array();
			if ( is_email( $args_->email ) && !empty( $args_->email ) ) { $user_data[ "user_email" ] = $args_->email; }
			if ( !empty( $args_->password ) ) { $user_data[ "user_pass" ] = $args_->password; }

			$result_ = "updated";

			if ( !empty( $user_data ) ) {
				$user_data[ "ID" ] = $user_id;
				$user_id = wp_update_user( $user_data );

				if ( is_wp_error( $user_id ) ) { $result_ = $user_id->get_error_message(); }
			}

			echo json_encode( $result_ );
		} else { echo json_encode( "It seems like that's not your password!" ); }
	}

	die( "" );
}

add_action( 'wp_ajax_nopriv_add_content', 'add_content' );
add_action( 'wp_ajax_add_content', 'add_content' );
function add_content() {
	if ( isset( $_POST[ "args" ] ) && !empty( $_POST[ "args" ] ) ) {
		$args_ = (object)$_POST[ "args" ];
		$args_->content_id = isset( $args_->content_id ) && !empty( $args_->content_id ) ? intval( $args_->content_id ) : 0;
		$args_->post_title = isset( $args_->post_title ) && !empty( $args_->post_title ) ? sanitize_text_field( $args_->post_title ) : "";
		$args_->featured_image = isset( $args_->featured_image ) && !empty( $args_->featured_image ) ? sanitize_text_field( $args_->featured_image ) : "";
		$args_->content = isset( $args_->content ) && !empty( $args_->content ) ? sanitize_text_field( $args_->content ) : "";

		if ( !empty( $args_->post_title ) ) {
			if ( !empty( $args_->content ) ) {
				$result_ = "added";

				$post_arr = array(
					"ID" => $args_->content_id,
					"post_title" => $args_->post_title,
					"post_name" => sanitize_title_with_dashes( $args_->post_title ),
					"post_type" => "promotions",
					"post_status" => "draft",
					"meta_input" => array(
						"featured_image_link" => $args_->featured_image,
						"content_link" => $args_->content
					)
				);
				$post_id = wp_insert_post( $post_arr );

				if ( is_wp_error( $post_id ) ) { $result_ = $post_id->get_error_message(); }

				echo json_encode( $result_ );
			} else { echo json_encode( "Post content can't be empty!" ); }
		} else { echo json_encode( "Post title can't be empty!" ); }
	} else { echo json_encode( "Arguments are not supplied!" ); }

	die( "" );
}

add_action( 'wp_ajax_nopriv_reset_reactive_password', 'reset_reactive_password' );
add_action( 'wp_ajax_reset_reactive_password', 'reset_reactive_password' );
function reset_reactive_password() {
	$email_ = isset( $_POST[ "email" ] ) && !empty( $_POST[ "email" ] ) ? sanitize_text_field( $_POST[ "email" ] ) : "";

	if ( !empty( $email_ ) && is_email( $email_ ) ) {
		$user_ = get_user_by( "email", $email_ );
		if ( $user_ !== false ) {
			$new_password = uniqid();
			wp_set_password( $new_password, $user_->ID );
			generate_email_notification( $user_->ID, "Hello there!<br>Your password was changed.<br>Your new password is: ". $new_password );
			echo json_encode( "Check your email!" );
		} else { echo json_encode( "Email is wrong!" ); }
	} else { echo json_encode( "Email is not set properly!" ); }

	die( "" );
}

function generate_email_notification( $user_id, $email_text ) {
	$user_id = intval( $user_id );

	if ( is_int( $user_id ) && $user_id > 0 ) {
		$user_ = get_user_by( "ID", $user_id );

		$email_template = file_get_contents( get_template_directory() ."/email-templates/notification.html" );
		$email_template = str_replace( "[site-url]", get_site_url(), $email_template );
		$email_template = str_replace( "[date]", date( "d M Y" ), $email_template );
		$email_template = str_replace( "[message]", $email_text, $email_template );

		wp_mail(
			$user_->user_email,
			"Reactive Magazine Notification",
			$email_template,
			array( "Content-Type: text/html; charset=UTF-8" )
		);
	}
}

add_action( 'wp_ajax_nopriv_add_subscriber', 'add_subscriber' );
add_action( 'wp_ajax_add_subscriber', 'add_subscriber' );
function add_subscriber() {
	$email_ = isset( $_POST[ "email" ] ) && !empty( $_POST[ "email" ] ) ? sanitize_text_field( $_POST[ "email" ] ) : "";

	if ( !empty( $email_ ) && is_email( $email_ ) ) {
		$password = uniqid();
		$username = explode( "@", $email_ )[0] . uniqid();

		$wp_registration_result = wp_create_user( $username, $password, $email_ );
		$wp_update_result = wp_update_user( array( "ID" => $wp_registration_result, "role" => "subscriber" ) );

		generate_email_notification( $wp_registration_result, "Welcome to Reactive!<br><br>Now you can login in your account, using this email and your password: ". $password ."<br><br>Happy reading!" );

		echo json_encode( "Welcome to Reactive!" );
	} else { echo json_encode( "Email is not set properly!" ); }

	die( "" );
}
