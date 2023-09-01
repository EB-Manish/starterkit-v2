<?php

/**
 * File Name: Footer Five
 *
 * This is the template that displays the header veriation (Header with accessibility).
 * @param array       $args Additional arguments passed to the template.
 */
$footer_logo = $args['footer_logo'];
$small_paragraph = $args['small_paragraph'];
$social_network = $args['social_network'];
$copyright_text = $args['copyright_text'];
$footer_5 = get_field('footer_5', 'option');
$widget_title = $footer_5['widget_title'];
$contact_list = $footer_5['contact_list'];
?>
<footer id="site-footer" class="site-footer site-footer--five">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="site-footer-widget">
					<?php if (!empty($footer_logo)) { ?>
						<div class="site-footer-logo">
							<img src="<?php echo $footer_logo['url']; ?>" alt="<?php starterkit_alt($footer_logo); ?>" class="w-100">
						</div>
					<?php } ?>
					<?php if ($small_paragraph) { ?>
						<div class="site-footer-desc">
							<?php echo $small_paragraph; ?>
						</div>
					<?php } ?>
					<?php
					if ($social_network) {
						get_template_part('template-parts/content', 'social-network');
					}
					?>
				</div>
			</div>
			<div class="col-md-6">
				<?php if ($widget_title) { ?>
					<div class="widget-title">
						<h5><?php echo $widget_title; ?></h5>
					</div>
				<?php } ?>
				<?php
				if (!empty($contact_list)) {
				?>
					<ul class="contact-list">
						<?php foreach ($contact_list as $list_item) {
							$title = $list_item['contact_list_title'];
							$details = $list_item['contact_list_details'];
						?>
							<li class="contact-list__item">
								<?php if ($title) { ?>
									<p><strong><?php echo $title; ?></strong></p>
								<?php } ?>
								<?php if ($details) { ?>
									<div class="desc"><?php echo $details; ?></strong></div>
								<?php } ?>
							</li>
						<?php
						}
						?>
					</ul>
				<?php

				}
				?>
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
				<div class="col-12">
					<div class="copyright small text-light text-center text-md-left">
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