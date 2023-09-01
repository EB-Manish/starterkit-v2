<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */

 add_action('acf/init','acf_init_block_types');
 function acf_init_block_types(){
add_filter('wp_graphql_blocks_process_attributes',function($attributes, $data,$post_id){
if($data['blockName'] == 'acf/propertyfeatures'){
	$attributes['price']= get_field('price',$post_id) ?? "";
	$attributes['bedrooms']= get_field('bedrooms',$post_id) ?? "";
	$attributes['bathrooms']= get_field('bathrooms',$post_id) ?? "";
	$attributes['has_parking']= get_field('has_parking',$post_id) ?? "";
	$attributes['pet_friendly']= get_field('pet_friendly',$post_id) ?? "";
}
return $attributes;
},0,3);

	wp_enqueue_script('fontawesome',get_template_directory_uri() . "/template-parts/fontawesome/all.min.js");
	if(function_exists('acf_register_block_type')){
		acf_register_block_type(array(
			'name'				=> 'ctabutton',
			'title'				=> 'CTA Button',
			'description'		=> 'CTA Button block.',
			'category'			=> 'design',
			'render_template'   => 'template-parts/blocks/ctaButton/ctaButton.php',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('cta', 'button'),
			'show_in_graphql'   => true,
		));

		acf_register_block_type(array(
			'name'				=> 'propertysearch',
			'title'				=> 'Property Search',
			'description'		=> 'A widget to search for properties',
			'category'			=> 'widge',
			'render_template'   => 'template-parts/blocks/propertySearch/propertySearch.php',
			'icon'				=> 'search',
			'keywords'			=> array('cta', 'button'),
			'show_in_graphql'   => true,
		));
		acf_register_block_type(array(
			'name'				=> 'formspreeform',
			'title'				=> 'Formspree Form',
			'description'		=> 'A block to render form',
			'category'			=> 'widge',
			'render_template'   => 'template-parts/blocks/formspreeForm/formspreeForm.php',
			'icon'				=> 'format-aside',
			'keywords'			=> array('form', 'contact'),
			'show_in_graphql'   => true,
		));
		acf_register_block_type(array(
			'name'				=> 'propertyfeatures',
			'title'				=> 'Property Features',
			'description'		=> 'A block to render form',
			'category'			=> 'design',
			'render_template'   => 'template-parts/blocks/propertyFeature/propertyFeature.php',
			'icon'				=> 'format-aside',
			'keywords'			=> array('property', 'contact'),
			'show_in_graphql'   => true,
			"postTypes"         => ["property"]
		));
		acf_register_block_type(array(
			'name'				=> 'tickitem',
			'title'				=> 'Tick Item',
			'description'		=> 'A block to render tick',
			'category'			=> 'design',
			'render_template'   => 'template-parts/blocks/tickitem/tickitem.php',
			'icon'				=> 'format-aside',
			'keywords'			=> array('property', 'contact'),
			'show_in_graphql'   => true,
			'supports'          =>array('jsx' => true),
		));
	}
}

if(function_exists('acf_add_options_page')){
	acf_add_options_page(array(
		'page_title' => 'Main menu',
		'menu_title' => 'Main menu',
		'show_in_graphql' => true,
		'icon_urls' => 'dashicons-menu',
	));
}


if ( ! function_exists( 'twentytwentytwo_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_support() {

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

	}

endif;

add_action( 'after_setup_theme', 'twentytwentytwo_support' );

if ( ! function_exists( 'twentytwentytwo_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Twenty Twenty-Two 1.0
	 *
	 * @return void
	 */
	function twentytwentytwo_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'twentytwentytwo-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'twentytwentytwo-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles' );

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';
