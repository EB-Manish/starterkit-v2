<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Starter_Kit
 */
?>
<?php if (is_singular()) : ?>
	<section class="section section-blog-details">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="blog-heading mx-auto">
						<?php the_title('<h1 class="blog__title">', '</h1>'); ?>
						<div class="entry-meta">
							<?php starterkit_posted_by(); ?>
						</div><!-- .entry-meta -->
					</div>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-12">
					<div class="blog-thumbnail text-center">
						<?php starterkit_post_thumbnail(); ?>
					</div>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="blog-content mx-auto">
						<?php the_content(); ?>
					</div>
					<footer class="entry-footer">
						<?php starterkit_entry_footer(); ?>
					</footer><!-- .entry-footer -->
				</div>
			</div>
		</div>
	</section>
<?php else : ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
		<div class="blog-post__thumb">
			<?php if (!has_post_thumbnail()) { ?>
				<div class="ph-picture"></div>
			<?php } else the_post_thumbnail('blog-thumb'); ?>
		</div>
		<div class="blog-post__content">
			<div>

				<?php the_title('<h5 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h5>'); ?>
				<div class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 22); ?></div>
			</div>
			<div class="entry-meta">
				<?php
				starterkit_posted_by();
				?>
			</div><!-- .entry-meta -->
		</div>
	</article>
<?php endif; ?>