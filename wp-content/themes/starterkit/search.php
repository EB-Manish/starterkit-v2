<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Starter_Kit
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="section section-search-result">
		<div class="container">

			<?php if (have_posts()) : ?>

				<header class="page-header section p-small pt-0">
					<h1 class="page-title h2">
						<?php
						/* translators: %s: search query. */
						printf(esc_html__('Search Results for: %s', 'starterkit'), '<span>' . get_search_query() . '</span>');
						?>
					</h1>
				</header><!-- .page-header -->

			<?php
				/* Start the Loop */
				while (have_posts()) :
					the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part('template-parts/content', 'search');

				endwhile;

				$big = 999999999; // need an unlikely integer
				$pages = paginate_links(array(
					'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
					'format' => '/page/%#%',
					'current' => max(1, get_query_var('paged')),
					// 'total' => $wp_query->max_num_pages,
					'end_size' => 1,
					'mid_size' => 1,
					'next_text' => '<span class="next-icon"></span>',
					'prev_text' => '<span class="prev-icon"></span>',
					'type'     => 'array'
				));

				// print_r($pages);

				if (is_array($pages)) :
					$paged = (get_query_var('paged') == 0) ? 1 : get_query_var('paged');
					echo '<div class="col-12"><div class="pagination">';
					foreach ($pages as $page) :
						echo "$page";
					endforeach;
					echo '</div></div>';
				endif;

			else :

				get_template_part('template-parts/content', 'none');

			endif;
			?>
	</section>
	</div>
</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
