<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Starter_Kit
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="theme-color" content="#2196f3">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head();
	$fixed_header_on_scroll = get_field('fixed_header_on_scroll', 'option');
	$mobile_navigation = get_field('mobile_navigation', 'option');
	$fixed_header_class = '';
	if ($fixed_header_on_scroll === true) {
		$fixed_header_class = ' page-with-fixed-header';
	}
	?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="main<?php echo $fixed_header_class . $mobile_navigation ? ' ' . $mobile_navigation : ''; ?>">
		<?php get_template_part('template-parts/header/header'); ?>