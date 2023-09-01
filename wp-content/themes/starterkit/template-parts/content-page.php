<?php

/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Starter_Kit
 */

$content = get_the_content();
if (get_the_content() != '') {
	the_content();
} else { ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header section">
			<div class="container">
				<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			</div>
		</header><!-- .entry-header -->

		<?php starterkit_post_thumbnail(); ?>

		<?php
		the_content();
		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__('Pages:', 'starterkit'),
				'after'  => '</div>',
			)
		);
		?>

		<?php if (get_edit_post_link()) : ?>
			<footer class="  py-3">
				<div class="container">
					<?php
					edit_post_link(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__('Edit <span class="screen-reader-text">%s</span>', 'starterkit'),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							wp_kses_post(get_the_title())
						),
						'<span class="edit-link">',
						'</span>'
					);
					?>
				</div>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</article><!-- #post-<?php the_ID(); ?> -->
<?php }
?>