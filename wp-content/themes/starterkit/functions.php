<?php

/**
 * Starter Kit functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Starter_Kit
 */

if (!defined('_STARTERKIT_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_STARTERKIT_VERSION', '2.0.0');
}
define('STARTERKIT_PARENT_URL', get_template_directory_uri());
define('STARTERKIT_IMAGES_DIR', STARTERKIT_PARENT_URL . '/assets/images/');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function starterkit_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Starter Kit, use a find and replace
		* to change 'starterkit' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('starterkit', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	$locations = array(
		'header-menu' => esc_html__('Primary', 'starterkit'),
	);
	if (function_exists('get_field')) {
		$footer_type = get_field('footer_type', 'option');
		if ($footer_type === 'footer_one') {
			$locations['footer-top-menu'] = esc_html__('Footer Top Menu', 'starterkit');
		}
		if ($footer_type === 'footer_one') {
			$locations['footer-bottom-menu'] = esc_html__('Footer Bottom Menu', 'starterkit');
		}
	}
	register_nav_menus($locations);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'starterkit_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	/**
	 * Add Image sizes
	 */
	add_image_size('blog-thumb', 386, 250, array('center', 'center'));
	add_image_size('featured-thumb', 802, 515, array('center', 'center'));
	add_image_size('blog-thumb-small', 184, 184, array('center', 'center'));
	add_image_size('blog-thumb-grid-large', 698, 480, array('center', 'center'));
	add_image_size('background-image', 1920, 1080, false);
}
add_action('after_setup_theme', 'starterkit_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function starterkit_content_width()
{
	$GLOBALS['content_width'] = apply_filters('starterkit_content_width', 640);
}
add_action('after_setup_theme', 'starterkit_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
require get_template_directory() . '/inc/register-widget.php';

/**
 * Enqueue scripts and styles.
 */
function starterkit_scripts()
{
	wp_enqueue_style('starterkit-style', get_stylesheet_uri(), array(), _STARTERKIT_VERSION);
	wp_style_add_data('starterkit-style', 'rtl', 'replace');

	wp_enqueue_script('starterkit-app', get_template_directory_uri() . '/assets/dist/app.js', array(), _STARTERKIT_VERSION, true);
	// wp_enqueue_script( 'starterkit-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _STARTERKIT_VERSION, true );

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	$ajax_nonce = wp_create_nonce('starterkit_ajax_nonce');

	$array = array(
		'ajax_url'   => esc_url(admin_url('admin-ajax.php')),
		'ajax_nonce' => $ajax_nonce,
		'home_url' => home_url(),
	);

	wp_localize_script('starterkit-app', 'starterkit_custom_data', $array);
}
add_action('wp_enqueue_scripts', 'starterkit_scripts');


add_action('wp_head', function () {
	global $wp_scripts;
	
	foreach ($wp_scripts->queue as $handle) {
		$script = $wp_scripts->registered[$handle];

		// This script's doesn't belong in my theme; don't preload.
		//   if (strpos($script->src, "/themes/starterkit/") === false) {
		// 	continue;
		//   }

		if (isset($script->extra['group']) && $script->extra['group'] === 1) {
			$source = $script->src . ($script->ver ? "?ver={$script->ver}" : "");
			echo "<link rel='preload' href='{$source}' as='script'/>\n";
		}
	}
}, 1);

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Library that allows you to easily require or recommend plugins.
 */
require get_template_directory() . '/inc/required-plugins.php';


/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Starterkit custom fuctions.
 */
require get_template_directory() . '/inc/custom-function.php';

/**
 * Starterkit register theme options.
 */
require get_template_directory() . '/inc/theme-options.php';

/**
 * Custom AFC filters.
 */
require get_template_directory() . '/inc/acf-filters/nav-mega-menu.php';

/**
 * Custom AFC Gutenberg block category.
 */
require get_template_directory() . '/inc/acf-blocks/starterkit-register-block-category.php';

/**
 * Custom AFC Gutenberg blocks.
 */
require get_template_directory() . '/inc/acf-blocks/starterkit-register-acf-blocks.php';

/**
 * Custom render callback function for AFC Gutenberg blocks.
 */
require get_template_directory() . '/inc/acf-blocks/starterkit-render-callback.php';
