<?php

/**
 * File Name: Footer Three
 *
 * This is the template that displays the header veriation (Header with accessibility).
 * @param array       $args Additional arguments passed to the template.
 */
$footer_logo = $args['footer_logo'];
$social_network = $args['social_network'];
$copyright_text = $args['copyright_text'];
$footer_3 = get_field('footer_3', 'option');
$newsletter_form = $footer_3['newsletter_form'];
?>
<footer id="site-footer" class=" site-footer site-footer--three">
	<div class="site-footer__top">
		<div class="container">
			<div class="row align-items-center ">
				<div class="col-lg-6">
					<div class="site-footer-widget">
						<?php if (!empty($footer_logo)) { ?>
							<div class="site-footer-logo">
								<img src="<?php echo $footer_logo['url']; ?>" alt="<?php starterkit_alt($footer_logo); ?>">
							</div>
						<?php } ?>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="news-letter-form">
						<?php if (!empty($newsletter_form)) {
							$shortcode = '[gravityform id="' . $newsletter_form['id'] . '" title="false" description="false" ajax="true" tabindex="49"]';
						?>
							<?php echo do_shortcode($shortcode, false); ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="site-footer__mid">
		<div class="container">
			<div class="row d-flex">
				<?php if (is_active_sidebar('footer-widget-1')) : ?>
					<div class="col site-footer__mid__item">
						<div class="footer-widget"><?php dynamic_sidebar('footer-widget-1'); ?></div>
					</div>
				<?php endif; ?>
				<?php if (is_active_sidebar('footer-widget-2')) : ?>
					<div class="col site-footer__mid__item">
						<div class="footer-widget"><?php dynamic_sidebar('footer-widget-2'); ?></div>
					</div>
				<?php endif; ?>
				<?php if (is_active_sidebar('footer-widget-3')) : ?>
					<div class="col site-footer__mid__item">
						<div class="footer-widget"><?php dynamic_sidebar('footer-widget-3'); ?></div>
					</div>
				<?php endif; ?>
				<?php if (is_active_sidebar('footer-widget-4')) : ?>
					<div class="col site-footer__mid__item">
						<div class="footer-widget"><?php dynamic_sidebar('footer-widget-4'); ?></div>
					</div>
				<?php endif; ?>
				<?php if (is_active_sidebar('footer-widget-5')) : ?>
					<div class="col site-footer__mid__item">
						<div class="footer-widget"><?php dynamic_sidebar('footer-widget-5'); ?></div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<hr>
	<div class="site-footer__bottom">
		<div class="container">
			<div class="row">
				<div class="col-md-4 order-2 order-lg-1 d-none d-md-block">
					<?php
					if ($social_network) {
						get_template_part('template-parts/content', 'social-network');
					}
					?>
				</div>
				<div class="col-md-4 order-3 order-lg-2 ">
					<div class="copyright small text-light text-center text-md-left">
						<?php if ($copyright_text) {
							echo $copyright_text;
						} else { ?>
							&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>
						<?php } ?>
					</div>
				</div>
				<div class="col-lg-4 order-1 d-md-none">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'footer-bottom-menu',
						'menu_id'        => 'footer-bottom-menu',
						'container_class' => 'footer-bottom-menu'
					));
					?>
				</div>
			</div>
		</div>
	</div>
</footer><!-- #colophon -->