<?php 
//For theme settings
if( function_exists('acf_add_options_page') ) {
	$option_page = acf_add_options_page(array(
		'page_title' 	=> 'Theme Options',
		'menu_title' 	=> 'Theme Option',
		'menu_slug' 	=> 'theme-options',
		'capability' 	=> 'edit_posts',
		'redirect' 	=> false
	));
}