<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Starter_Kit
 */

get_header();
?>

<main id="primary" class="site-main">
	<section class="section section-blog-listing">
		<div class="container">
			<?php if (have_posts()) { ?>

				<header class="page-header section p-small pt-0">
						<?php
						the_archive_title('<h1 class="page-title">', '</h1>');
						the_archive_description('<div class="archive-description">', '</div>');
						?>

				</header><!-- .page-header -->
				<div class="blog-posts">
					<div class="row">
						<?php
						/* Start the Loop */
						while (have_posts()) :
							the_post();
						?>
							<div class="col-md-4">
								<?php get_template_part('template-parts/content', get_post_type()); ?>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			<?php
				
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
			} else {

				get_template_part('template-parts/content', 'none');
			}
			?>
		</div>
	</section>
</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
