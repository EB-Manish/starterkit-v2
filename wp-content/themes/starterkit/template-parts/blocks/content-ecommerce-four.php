<?php

/**
 * Block Name: Ecommerce Four
 *
 * This is the template that displays the Ecommerce Four
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// Check if woocommerce is active
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) :

    // create id attribute for specific styling
    $id = 'ecommerce-four-' . $block['id'];

    // Check for section padding
    $section_padding  = get_field('starter_kit_section_padding');
    $padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
    $padding_type  = get_field('starter_kit_padding_type');

    // Check if section is enable or disable
    $section_enable = get_field('starter_kit_enable_section');
    if ($section_enable) {
        // Get product categories
        $products_categories_args = array(
            'taxonomy'   => "product_cat",
            'hide_empty' => false,
        );
        $products_categories = get_terms($products_categories_args);

        // Get an array of product attribute taxonomies
        $attributes_taxonomies = wc_get_attribute_taxonomy_labels();

        // Posts per page
        $posts_per_page = 12;

        $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

        // Post Data
        $post_data = ($_POST);

        $tax_query = '';

        $id_array = [];

        if ($post_data) {
            $tax_query = array('relation' => 'AND');
            foreach ($post_data as $Key => $Data) {
                $tax_query_in = array('relation' => 'OR');
                if (count($Data)) {
                    foreach ($Data as $Inkey => $Indata) {
                        array_push($tax_query_in, array('taxonomy' => $Key, 'field' => 'term_id', 'terms' => (int)$Indata, 'operator' => 'IN'));
                        array_push($id_array, $Indata);
                    }
                }
                array_push($tax_query, $tax_query_in);
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

        // Products query
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'tax_query' => $tax_query,
        );

        $products_query = new WP_Query($args);

        // Get page url
        global $wp;
        $current_url = home_url(add_query_arg(array(), $wp->request));
        $pos = strpos($current_url, '/page');
        $finalurl = substr($current_url, 0, $pos);
?>
        <section id="<?php echo $id; ?>" class="section section-ecommerce-four <?php echo $padding_type . ' ' . $padding; ?>">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3">
                        <form method="POST" action="<?= $finalurl; ?>" id="product-filter-normal" class="accordion filter">
                            <div class="accordion-item categories ">
                                <h2 class="accordion-header h6">
                                    <span class="h6 accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $id; ?>-collapse1" aria-expanded="true">Categories</span>
                                </h2>
                                <div id="<?= $id; ?>-collapse1" class="accordion-collapse collapse show" aria-labelledby="<?= $id; ?>-heading1">
                                    <div class="accordion-body ">
                                        <?php
                                        foreach ($products_categories as $products_cat) {
                                            $checked = in_array($products_cat->term_id, $id_array) ? ' checked' : '';
                                        ?>
                                            <div class="form-check">
                                                <input type="checkbox" class="checkbox form-check-input" id="ecommerce-four-<?= $products_cat->term_id; ?>" name="product_cat[]" value="<?= $products_cat->term_id; ?>" <?= $checked; ?>>
                                                <label class="form-check-label" for="ecommerce-four-<?= $products_cat->term_id; ?>"><?= $products_cat->name; ?></label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $count = 2;
                            foreach ($attributes_taxonomies as $key => $attributes_taxonomy) {
                                $slug = 'pa_' . $key;
                                $terms = get_terms($slug);
                            ?>
                                <div class="accordion-item  attributes  <?= $slug; ?>" data-attribute-slug="<?= $slug; ?>">
                                    <h2 class="accordion-header">
                                        <span class="h6 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $id . '-collapse' . $count; ?>" aria-expanded="true"><?= $attributes_taxonomy; ?></span>
                                    </h2>
                                    <div id="<?= $id . '-collapse' . $count; ?>" class="accordion-collapse collapse" aria-labelledby="<?= $id . '-heading' . $count; ?>">
                                        <div class="accordion-body">
                                            <?php
                                            foreach ($terms as $term) {
                                                $checked = in_array($term->term_id, $id_array) ? ' checked' : '';
                                            ?>
                                                <div class="form-check">
                                                    <input type="checkbox" class="checkbox form-check-input" id="ecommerce-four-<?= $term->term_id; ?>" name="<?= $slug; ?>[]" value="<?= $term->term_id; ?>" <?= $checked; ?>>
                                                    <label class="form-check-label" for="ecommerce-four-<?= $term->term_id; ?>"><?= $term->name; ?></label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $count++;
                            }
                            ?>

                            <button class="mt-4 btn btn-primary" id="filter-product-btn" type="submit">Filter</button>
                        </form>
                    </div>

                    <div class="col-xl-9 filter-output">
                        <?php if ($products_query->have_posts()) { ?>
                            <div class="row">
                                <?php
                                while ($products_query->have_posts()) {
                                    $products_query->the_post();

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
                                    wp_reset_postdata();
                                }
                                ?>
                            </div>
                            <?php if ($total_product > $posts_per_page) { ?>
                                <div class="pagination pagination-two">
                                    <?php echo ecommerce_four_pagination($products_query); ?>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <span class="no-result">No Products Found</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
<?php else : ?>
    <div class="container ecommerce-block-error mb-3">
        <div class="bg-danger text-white p-3">
            Please install and activate WooCommerce to use this block (Ecommerce Four).
        </div>
    </div>
<?php endif; ?>