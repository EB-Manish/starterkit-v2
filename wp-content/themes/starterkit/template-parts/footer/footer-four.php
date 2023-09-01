<?php

/**
 * File Name: Footer Four
 *
 * This is the template that displays the header veriation (Header with accessibility).
 * @param array       $args Additional arguments passed to the template.
 */
$footer_logo = $args['footer_logo'];
$social_network = $args['social_network'];
$copyright_text = $args['copyright_text'];
$footer_4 = get_field('footer_4', 'option');
$newsletter_form = $footer_4['footer_4_newsletter_form'];
$form_title = $footer_4['footer_4_form_title'];
?>
<footer id="site-footer" class="site-footer site-footer--four">
	<div class="site-footer__top">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="news-letter-form m-auto">
						<?php if (!empty($newsletter_form) || $form_title) {
							$shortcode = '[gravityform id="' . $newsletter_form['id'] . '" title="false" description="false" ajax="true" tabindex="49"]';
						?>
							<div class="form-wrapper">
								<?php if ($form_title) { ?>
									<div class="form-wrapper__heading text-center">
										<h4><?php echo $form_title; ?></h4>
									</div>
								<?php
								}
								?>
								<?php echo do_shortcode($shortcode, false); ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="site-footer__mid">
		<div class="container">
			<div class="row">
				<div class="col site-footer__mid__item">
					<div class="site-footer-widget">
						<?php if (!empty($footer_logo)) { ?>
							<div class="site-footer-logo">
								<img src="<?php echo $footer_logo['url']; ?>" alt="<?php starterkit_alt($footer_logo); ?>">
							</div>
						<?php } ?>
						<?php
						if ($social_network) {
							get_template_part('template-parts/content', 'social-network');
						}
						?>
					</div>
				</div>
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
			</div>
		</div>
	</div>
	<hr>
	<div class="site-footer__bottom">
		<div class="container">
			<div class="row">
				<div class="col-12 d-md-none">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'footer-bottom-menu',
						'menu_id'        => 'footer-bottom-menu',
						'container_class' => 'footer-bottom-menu'
					));
					?>
				</div>
				<div class="col-12 text-center">
					<div class="copyright small text-light text-left">
						<?php if ($copyright_text) {
							echo $copyright_text;
						} else { ?>
							&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer><!-- #colophon -->