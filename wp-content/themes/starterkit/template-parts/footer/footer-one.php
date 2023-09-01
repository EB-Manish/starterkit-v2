<?php

/**
 * File Name: Footer One
 *
 * This is the template that displays the header veriation (Header with accessibility).
 * @param array       $args Additional arguments passed to the template.
 */
$footer_logo = $args['footer_logo'];
$social_network = $args['social_network'];
$copyright_text = $args['copyright_text'];
?>
<footer id="site-footer" class=" site-footer site-footer--one">
	<div class="site-footer__top">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-xl-6">
					<?php if (!empty($footer_logo)) { ?>
						<div class="site-footer-logo">
							<img src="<?php echo $footer_logo['url']; ?>" alt="<?php starterkit_alt($footer_logo); ?>">
						</div>
					<?php } ?>
				</div>
				<div class="col-lg-8 col-xl-6">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'footer-top-menu',
						'menu_id'        => 'footer-top-menu',
						'container_class' => 'footer-top-menu'
					));
					?>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="site-footer__bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 order-2 order-lg-1">
					<?php
					wp_nav_menu(array(
						'theme_location' => 'footer-bottom-menu',
						'menu_id'        => 'footer-bottom-menu',
						'container_class' => 'footer-bottom-menu'
					));
					?>
				</div>
				<div class="col-lg-4 order-3 order-lg-2 ">
					<div class="copyright small text-light text-center ">
						<?php if ($copyright_text) {
							echo $copyright_text;
						} else { ?>
							&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>
						<?php } ?>
					</div>
				</div>
				<div class="col-lg-4 order-1 order-lg-3">
					<?php
					if( $social_network ) {
						get_template_part('template-parts/content', 'social-network');
					}
					?>
				</div>
			</div>
		</div>
	</div>
</footer>