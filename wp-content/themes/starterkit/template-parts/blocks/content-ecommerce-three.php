<?php

/**
 * Block Name: Ecommerce Three
 *
 * This is the template that displays the Ecommerce Three
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// Check if woocommerce is active
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) :

    // create id attribute for specific styling
    $id = 'ecommerce-three-' . $block['id'];

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

        // Total products query
        $total_query_args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        );
        $total_query = new WP_Query($total_query_args);
        $total_product = 0;
        if ($total_query->have_posts()) {
            while ($total_query->have_posts()) {
                $total_query->the_post();
                $total_product++;
            }
        }

        // Current page
        $currentPage = 1;

        // Posts per page
        $posts_per_page = 12;

        // Products query
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $posts_per_page,
        );
        $products_query = new WP_Query($args);
?>
        <section id="<?php echo $id; ?>" class="section section-ecommerce-three <?php echo $padding_type . ' ' . $padding; ?>">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-xl-3">
                        <div class="loader-wrap d-lg-none">
                            <button id="open-filter" class="filter-toggle ">Filters</button>
                        </div>

                        <form id="product-filter" class="accordion filter">
                            <div class="accordion-item categories ">
                                <h2 class="accordion-header h6">
                                    <span class="h6 accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $id; ?>-collapse1" aria-expanded="true">Categories</span>
                                </h2>
                                <div id="<?= $id; ?>-collapse1" class="accordion-collapse collapse show" aria-labelledby="<?= $id; ?>-heading1">
                                    <div class="accordion-body ">
                                        <?php foreach ($products_categories as $products_cat) { ?>
                                            <div class="form-check">
                                                <input class="checkbox form-check-input" type="checkbox" id="ecommerce-three-<?= $products_cat->term_id; ?>" name="product_cat" value="<?= $products_cat->term_id; ?>">
                                                <label class="form-check-label" for="ecommerce-three-<?= $products_cat->term_id; ?>"><?= $products_cat->name; ?></label>
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
                                            <?php foreach ($terms as $term) { ?>
                                                <div class="form-check">
                                                    <input class="checkbox form-check-input" type="checkbox" id="ecommerce-three-<?= $term->term_id; ?>" name="<?= $slug; ?>" value="<?= $term->term_id; ?>">
                                                    <label class="form-check-label" for="ecommerce-three-<?= $term->term_id; ?>"><?= $term->name; ?></label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $count++;
                            }
                            ?>
                        </form>
                    </div>

                    <div id="filter-output" class="col-lg-8 col-xl-9 filter-output">
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
                                }
                                wp_reset_postdata();
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
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
<?php else : ?>
    <div class="container ecommerce-block-error mb-3">
        <div class="bg-danger text-white p-3">
            Please install and activate WooCommerce to use this block (Ecommerce Three).
        </div>
    </div>
<?php endif; ?>