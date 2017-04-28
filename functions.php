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
