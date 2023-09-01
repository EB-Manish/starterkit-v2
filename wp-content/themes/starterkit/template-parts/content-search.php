<?php

/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Starter_Kit
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<span class="badge text-bg-info"><?php echo get_post_type(); ?></span>
	<div class="d-flex flex-md-row flex-column">
		<?php if (get_the_post_thumbnail()) { ?>
			<div class="post-thumb me-4">
				<?php the_post_thumbnail('blog-thumb-small'); ?>
			</div>
		<?php } ?>
		<div class="post-content">
			<header class="entry-header">
				<?php the_title(sprintf('<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h4>'); ?>
			</header><!-- .entry-header -->
			<div class="entry-summary">
				<?php echo wp_trim_words(get_the_excerpt(), 10); ?>
			</div><!-- .entry-summary -->
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->