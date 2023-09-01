<?php

/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Starter_Kit
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function starterkit_woocommerce_setup()
{
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support('wc-product-gallery-zoom');
	add_theme_support('wc-product-gallery-lightbox');
	add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'starterkit_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function starterkit_woocommerce_scripts()
{
	// wp_enqueue_style('starterkit-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _STARTERKIT_VERSION);

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style('starterkit-woocommerce-style', $inline_font);
}
add_action('wp_enqueue_scripts', 'starterkit_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function starterkit_woocommerce_active_body_class($classes)
{
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter('body_class', 'starterkit_woocommerce_active_body_class');

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function starterkit_woocommerce_related_products_args($args)
{
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args($defaults, $args);

	return $args;
}
add_filter('woocommerce_output_related_products_args', 'starterkit_woocommerce_related_products_args');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('starterkit_woocommerce_wrapper_before')) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function starterkit_woocommerce_wrapper_before()
	{
?>
		<main id="primary" class="site-main">
		<?php
	}
}
add_action('woocommerce_before_main_content', 'starterkit_woocommerce_wrapper_before');

if (!function_exists('starterkit_woocommerce_wrapper_after')) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function starterkit_woocommerce_wrapper_after()
	{
		?>
		</main><!-- #main -->
	<?php
	}
}
add_action('woocommerce_after_main_content', 'starterkit_woocommerce_wrapper_after');

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'starterkit_woocommerce_header_cart' ) ) {
			starterkit_woocommerce_header_cart();
		}
	?>
 */

if (!function_exists('starterkit_woocommerce_cart_link_fragment')) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function starterkit_woocommerce_cart_link_fragment($fragments)
	{
		ob_start();
		starterkit_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter('woocommerce_add_to_cart_fragments', 'starterkit_woocommerce_cart_link_fragment');

if (!function_exists('starterkit_woocommerce_cart_link')) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function starterkit_woocommerce_cart_link()
	{
	?>
		<a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'starterkit'); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n('%d item', '%d', WC()->cart->get_cart_contents_count(), 'starterkit'),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data(WC()->cart->get_cart_subtotal()); ?></span> <span class="count"><?php echo esc_html($item_count_text); ?></span>
		</a>
	<?php
	}
}

if (!function_exists('starterkit_woocommerce_header_cart')) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function starterkit_woocommerce_header_cart()
	{
		if (is_cart()) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
	?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr($class); ?>">
				<?php starterkit_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget('WC_Widget_Cart', $instance);
				?>
			</li>
		</ul>
		<?php
	}
}

// Ecommerce three filter products 
add_action('wp_ajax_ecommerce_three_filter_products', 'ecommerce_three_filter_products');
add_action('wp_ajax_nopriv_ecommerce_three_filter_products', 'ecommerce_three_filter_products');

function ecommerce_three_filter_products()
{
	if (isset($_POST['nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'starterkit_ajax_nonce')) {
		$categoriesChoices = $_POST['categoriesChoices'];
		$attributeChoices = $_POST['attributesChoices'];

		// Current page
		$currentPage = (int)$_POST['pageNo'];

		// Posts per page
		$posts_per_page = 12;

		// Offset
		$offset = ($currentPage - 1) * $posts_per_page;

		// Tax query
		$tax_query = array('relation' => 'AND');
		if ($categoriesChoices) {
			foreach ($categoriesChoices as $Key => $Value) {
				$tax_queryin_1 = array('relation' => 'OR');
				if (count($Value)) {
					foreach ($Value as $Inkey => $Invalue) {
						array_push($tax_queryin_1, array('taxonomy' => $Key, 'field' => 'term_id', 'terms' => (int)$Invalue, 'operator' => 'IN'));
					}
				}
			}
			array_push($tax_query, $tax_queryin_1);
		}

		if ($attributeChoices) {
			foreach ($attributeChoices as $Key => $Value) {
				$tax_queryin_2 = array('relation' => 'OR');
				if (count($Value)) {
					foreach ($Value as $Inkey => $Invalue) {
						$tax_queryin_2[] = array('taxonomy' => $Key, 'field' => 'term_id', 'terms' => (int)$Invalue, 'operator' => 'IN');
					};
				}
				array_push($tax_query, $tax_queryin_2);
			}
		}

		// Total products query
		$total_query_args = array(
			'post_type' => 'product',
			'posts_per_page' => -1,
			'tax_query' => $tax_query,
		);
		$total_query = new WP_Query($total_query_args);
		$total_product = 0;
		if ($total_query->have_posts()) {
			while ($total_query->have_posts()) {
				$total_query->the_post();
				$total_product++;
			}
		}

		// Products Filter query
		$filter_args = array(
			'post_type' => 'product',
			'posts_per_page' => $posts_per_page,
			'offset' => $offset,
			'tax_query' => $tax_query,
		);

		$filter_query = new WP_Query($filter_args);

		if ($filter_query->have_posts()) :
		?>
			<div class="row">
				<?php
				while ($filter_query->have_posts()) :
					$filter_query->the_post();
					$product_id = get_the_ID();

					$image = get_the_post_thumbnail_url();
					$image_alt = get_post_meta(get_post_thumbnail_id($product_id), '_wp_attachment_image_alt', TRUE);
					$link = get_the_permalink();
					$title = get_the_title();
					$price = get_post_meta($product_id, '_price', true);
					$product_cats = wp_get_post_terms($product_id, 'product_cat');
				?>
					<div class="col-md-6 col-xl-3 product-wrap">
						<div class="product">
							<div class="product-img">
								<a href="<?= $link; ?>">
									<?php if (has_post_thumbnail()) { ?>
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
										<?php
										}
										?>
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
				endwhile;
				wp_reset_query();
				?>
			</div>
			<?php
			// Pagination
			$totalPages = ceil($total_product / $posts_per_page);
			if ($totalPages > 1) {
				$pageCounter = 1;
			?>
				<div class="ecommerce-three-pagination">
					<nav>
						<ul class="pagination">
							<li class="page-item <?php if ($currentPage == 1) echo 'disabled'; ?>">
								<a class="page-link <?php if ($currentPage != 1) echo 'changePage'; ?>" href="javascript:void(0)" data-pageno="<?php echo ($currentPage - 1); ?>">
									<svg width=" 20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5892 4.7559C10.9146 4.43047 10.9146 3.90283 10.5892 3.57739C10.2637 3.25195 9.7361 3.25195 9.41066 3.57739L3.57733 9.41072C3.25189 9.73616 3.25189 10.2638 3.57733 10.5892L9.41066 16.4226C9.7361 16.748 10.2637 16.748 10.5892 16.4226C10.9146 16.0971 10.9146 15.5695 10.5892 15.2441L6.17843 10.8333H15.8333C16.2935 10.8333 16.6666 10.4602 16.6666 9.99998C16.6666 9.53974 16.2935 9.16665 15.8333 9.16665H6.17843L10.5892 4.7559Z" fill="#E0E0E0" />
									</svg>
								</a>
							</li>
							<?php while ($pageCounter <= $totalPages) { ?>
								<li class="page-item <?php if ($currentPage == $pageCounter) echo 'active'; ?>">
									<a class="page-link <?php
														if ($currentPage != $pageCounter) echo 'changePage';
														if ($currentPage > $pageCounter) echo ' prev-link';
														?>" href="javascript:void(0)" data-pageno="<?php echo $pageCounter; ?>">
										<?php echo $pageCounter; ?>
									</a>
								</li>
							<?php $pageCounter++;
							} ?>
							<li class=" page-item <?php if ($currentPage == $totalPages) echo 'disabled'; ?>">
								<a class="page-link <?php if ($currentPage != $totalPages) echo 'changePage'; ?>" href="javascript:void(0)" data-pageno="<?php echo ($currentPage + 1); ?>">
									<svg width=" 20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5892 3.57739C10.2637 3.25195 9.7361 3.25195 9.41066 3.57739C9.08523 3.90283 9.08523 4.43047 9.41066 4.7559L13.8214 9.16665H4.16659C3.70635 9.16665 3.33325 9.53974 3.33325 9.99998C3.33325 10.4602 3.70635 10.8333 4.16659 10.8333H13.8214L9.41066 15.2441C9.08523 15.5695 9.08523 16.0971 9.41066 16.4226C9.7361 16.748 10.2637 16.748 10.5892 16.4226L16.4225 10.5892C16.7479 10.2638 16.7479 9.73616 16.4225 9.41072L10.5892 3.57739Z" fill="#E0E0E0" />
									</svg>
								</a>
							</li>
						</ul>
					</nav>
				</div>
			<?php } ?>
<?php
		else :
			echo '<span class="no-result">No Products Found</span>';
		endif;
	}

	die();
}

// Ecommerce four pagination
function ecommerce_four_pagination($query)
{
	$big = 999999999; // need an unlikely integer

	return paginate_links(array(
		'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		'format' => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total' => $query->max_num_pages,
		'end_size' => 5,
		'next_text' => '<span class="next-icon"></span>',
		'prev_text' => '<span class="prev-icon"></span>',
	));
}


// Woocommerce product details
/**
 * Remove related products output
 */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

/**
 * Remove product meta output
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

/**
 * Remove reset variation button
 */
add_filter('woocommerce_reset_variations_link', '__return_empty_string');

/**
 * Remove the breadcrumbs 
 */
add_action('init', 'remove_wc_breadcrumbs');
function remove_wc_breadcrumbs()
{
	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
}

/**
 * Add html element before_single_product
 */
add_action('woocommerce_before_single_product', 'before_single_product_open_div');
function before_single_product_open_div()
{
	echo '<section class="section product-detail__section"><div class="container">';
}

/**
 * Add html element after_single_product
 */
add_action('woocommerce_after_single_product', 'after_single_product_close_div');
function after_single_product_close_div()
{
	echo '</div></section>';
}

/**
 * Remove the sidebar
 */
add_action('init', 'remove_wc_sidebar');
function remove_wc_sidebar()
{
	remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
}

// Variation Radio buttons
function variation_radio_buttons($html, $args)
{
	$args = wp_parse_args(apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args), array(
		'options'          => false,
		'attribute'        => false,
		'product'          => false,
		'selected'         => false,
		'name'             => '',
		'id'               => '',
		'class'            => '',
		'show_option_none' => __('Choose an option', 'woocommerce'),
	));

	if (false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
		$selected_key     = 'attribute_' . sanitize_title($args['attribute']);
		$args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
	}

	$options               = $args['options'];
	$product               = $args['product'];
	$attribute             = $args['attribute'];
	$name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title($attribute);
	$id                    = $args['id'] ? $args['id'] : sanitize_title($attribute);
	$class                 = $args['class'];
	$show_option_none      = (bool)$args['show_option_none'];
	$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'woocommerce');

	if (empty($options) && !empty($product) && !empty($attribute)) {
		$attributes = $product->get_variation_attributes();
		$options    = $attributes[$attribute];
	}

	$radios = '<div class="variation-radios">';

	if (!empty($options)) {
		if ($product && taxonomy_exists($attribute)) {
			$terms = wc_get_product_terms($product->get_id(), $attribute, array(
				'fields' => 'all',
			));

			foreach ($terms as $term) {
				if (in_array($term->slug, $options, true)) {
					$id = $name . '-' . $term->slug;
					$radios .= '<input type="radio" id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" value="' . esc_attr($term->slug) . '" ' . checked(sanitize_title($args['selected']), $term->slug, false) . '><label for="' . esc_attr($id) . '">' . esc_html(apply_filters('woocommerce_variation_option_name', $term->name)) . '</label>';
				}
			}
		} else {
			foreach ($options as $option) {
				$id = $name . '-' . $option;
				$checked    = sanitize_title($args['selected']) === $args['selected'] ? checked($args['selected'], sanitize_title($option), false) : checked($args['selected'], $option, false);
				$radios    .= '<input type="radio" id="' . esc_attr($id) . '" name="' . esc_attr($name) . '" value="' . esc_attr($option) . '" id="' . sanitize_title($option) . '" ' . $checked . '><label for="' . esc_attr($id) . '">' . esc_html(apply_filters('woocommerce_variation_option_name', $option)) . '</label>';
			}
		}
	}

	$radios .= '</div>';

	return $html . $radios;
}
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'variation_radio_buttons', 20, 2);

function variation_check($active, $variation)
{
	if (!$variation->is_in_stock() && !$variation->backorders_allowed()) {
		return false;
	}
	return $active;
}
add_filter('woocommerce_variation_is_active', 'variation_check', 10, 2);


// Woocommerce cart page
/**
 * Add html element before_cart
 */
add_action('woocommerce_before_cart', 'before_cart_open_div');
function before_cart_open_div()
{
	echo '<div class="cart-page">';
}

/**
 * Add html element after_cart
 */
add_action('woocommerce_after_cart', 'after_cart_close_div');
function after_cart_close_div()
{
	echo '</div>';
}

/**
 * Add html element before_cart_totals
 */
add_action('woocommerce_before_cart_totals', 'before_cart_totals_div');
function before_cart_totals_div()
{
	global $woocommerce;
	$items = $woocommerce->cart->get_cart();

	echo '<h2>Order summary</h2><table class="order-summary"><tbody>';

	foreach ($items as $item => $values) {
		$_product =  wc_get_product($values['data']->get_id());
		$total = $values['line_total'];
		// pr($values);

		if ($_product->is_type('variation')) {
			$attributes = $_product->get_attributes();
			$variation_array = [];

			if ($attributes) {
				foreach ($attributes as $key => $value) {
					$variation_array[] = ucfirst($value);
				}
			}
			$variation_names = implode(', ', $variation_array);

			echo '<tr><th>' . $_product->get_title() . ' - ' . $variation_names . '</th><td>' . get_woocommerce_currency_symbol() . $total . '</td></tr>';
		} else {
			echo '<tr><th>' . $_product->get_title() . '</th><td>' . get_woocommerce_currency_symbol() . $total . '</td></tr>';
		}
	}

	echo '</tbody></table>';
}

//Changed the position of woocommerce notice
remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10);

add_action('woocommerce_login_form_end', 'woocommerce_output_all_notices', 10);


remove_action('woocommerce_before_lost_password_form', 'woocommerce_output_all_notices', 10);

add_action('woocommerce_after_lost_password_form', 'woocommerce_output_all_notices', 10);

// Checkout page
/**
 * Add html element checkout_after_customer_details
 */
add_action('woocommerce_checkout_after_customer_details', 'checkout_after_customer_details_open_div');
function checkout_after_customer_details_open_div()
{
	echo '<div class="order-wrapper">';
}

/**
 * Add html element checkout_after_customer_details
 */
add_action('woocommerce_review_order_after_payment', 'review_order_after_payment_close_div');
function review_order_after_payment_close_div()
{
	echo '</div>';
}

//shop page
/**
 * Add html element woocommerce_before_main_content
 */
add_action('woocommerce_before_main_content', 'woocommerce_before_main_content_open_div');
function woocommerce_before_main_content_open_div()
{
	if (is_shop()) {
		echo '<div class="shop-wrapper"><div class="container">';
	}
}

/**
 * Add html element woocommerce_before_main_content
 */
add_action('woocommerce_after_main_content', 'woocommerce_after_main_content_close_div');
function woocommerce_after_main_content_close_div()
{
	if (is_shop()) {
		echo '</div></div>';
	}
}

/**
 * Add html element woocommerce_before_main_content
 */
function starterkit_remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'starterkit_remove_image_zoom_support', 100 );