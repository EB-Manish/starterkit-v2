<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Starter_Kit
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="error-404 not-found section bg-gray">
		<div class="container">

			<header class="page-header text-center">
				<h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'starterkit'); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content text-center">
				<p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'starterkit'); ?></p>

				<?php get_search_form(); ?>

			</div><!-- .page-content -->
		</div>
	</section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();
