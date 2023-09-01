<?php

/**
 * Block Name: Ecommerce One
 *
 * This is the template that displays the Ecommerce One
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// Check if woocommerce is active
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) :
	// create id attribute for specific styling
	$id = 'ecommerce-one-' . $block['id'];

	// Check for section padding
	$section_padding  = get_field('starter_kit_section_padding');
	$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
	$padding_type  = get_field('starter_kit_padding_type');

	// Check if section is enable or disable
	$section_enable = get_field('starter_kit_enable_section');
	if ($section_enable) {
		$select_products = get_field('starter_kit_select_products');
?>
		<section id="<?php echo $id; ?>" class="section section-ecommerce-one <?php echo $padding_type . ' ' . $padding; ?>">
			<div class="container">
				<?php if ($select_products) { ?>
					<div class="row">
						<?php
						foreach ($select_products as $post) {
							setup_postdata($post);

							$product_id = $post->ID;
							$image = get_the_post_thumbnail_url($product_id);
							$image_alt = get_post_meta(get_post_thumbnail_id($product_id), '_wp_attachment_image_alt', TRUE);
							$link = get_the_permalink($product_id);
							$title = get_the_title($product_id);
							$price = get_post_meta($product_id, '_price', true);
							$product_cats = wp_get_post_terms($product_id, 'product_cat');
						?>
							<div class="col-md-6 col-xl-4 product-wrap">
								<div class="product h-100">
									<div class="product-img">
										<a href="<?= $link; ?>">
											<?php if (has_post_thumbnail($product_id)) { ?>
												<img src="<?= $image; ?>" alt="<?= $image_alt; ?>" class="w-100 h-100 object-fit-cover">
											<?php } else { ?>
												<img src="<?= STARTERKIT_IMAGES_DIR; ?>woocommerce-placeholder.png" alt="placeholder image">
											<?php } ?>
										</a>
									</div>
									<div class="product-desc">
										<h2 class="h6 product-desc__title"><a href="<?= $link; ?>"><?= $title; ?></a></h2>
										<?php if ($product_cats) { ?>
											<div class="product-desc__categories">
												<?php foreach ($product_cats as $product_cat) { ?>
													<span><?= $product_cat->name; ?></span>
												<?php } ?>
											</div>
										<?php } ?>
										<span class="product-desc__price"><?= wc_price($price); ?></span>
									</div>
									<div class="btn-wrap">
										<?php woocommerce_template_loop_add_to_cart(); ?>
									</div>
								</div>
							</div>
						<?php
						}
						wp_reset_postdata();
						?>
					</div>
				<?php } ?>
			</div>
		</section>
	<?php } ?>
<?php else : ?>
	<div class="container ecommerce-block-error mb-3">
		<div class="bg-danger text-white p-3">
			Please install and activate WooCommerce to use this block (Ecommerce One).
		</div>
	</div>
<?php endif; ?>