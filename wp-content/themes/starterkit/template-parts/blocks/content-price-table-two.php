<?php

/**
 * Block Name: Price Table Two
 *
 * This is the template that displays the Price Table Two block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// Create id attribute allowing for custom "anchor" value.
$id = 'price-table-two-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}
//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');

$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $section_title = get_field('starter_kit_section_title');
?>
    <section id="<?php echo $id; ?>" class="section section-price-table section-price-table-two <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container">
            <?php if ($section_title != '') { ?>
                <h2 class="section-heading__title text-center"><?php echo $section_title; ?></h2>
            <?php } ?>
            <div class="row section-content justify-content-center">
                <?php if (have_rows('starter_kit_price_planning')) { ?>
                    <?php while (have_rows('starter_kit_price_planning')) {
                        the_row();
                        $plan_title = get_sub_field('starter_kit_plan_title');
                        $plan_button = get_sub_field('starter_kit_plan_button');
                        $plan_price = get_sub_field('starter_kit_price');
                        $feature_section = get_sub_field('starter_kit_feature_section');
                        $custom_pricing = get_sub_field('starter_kit_custom_pricing');
                        $custom_text = get_sub_field('starter_kit_custom_text');
                        $feature_class = ($feature_section) ? ' feature-section' : '';
                        $link_class = ($feature_section) ? ' btn-primary' : ' btn-outline-primary';
                        $custom_class = ($custom_pricing) ? ' custom-section' : "";
                    ?>
                        <div class="plan-card text-center col-12 col-md-6 <?php echo $feature_class . ' ' . $custom_class; ?>">
                            <?php if ($plan_title || $custom_text) { ?>
                                <div class="plan-card__title">
                                    <h3><?php echo $plan_title; ?></h3>
                                    <?php if ($custom_pricing && $custom_text) { ?>
                                        <div class="plan-card__customtitle">
                                            <h3><?php echo $custom_text; ?></h3>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if ($plan_price) { ?>
                                <div class="plan-card__price">
                                    <hero><?php echo $plan_price; ?></hero>
                                </div>
                            <?php } ?>
                            <?php if ($plan_button) { ?>
                                <div class="plan-card__btn">
                                    <a href="<?php echo $plan_button['url']; ?>" class="btn <?php echo $link_class; ?>" <?php starterkit_target($plan_button); ?>><?php echo $plan_button["title"]; ?>
                                    </a>
                                </div>
                            <?php }
                            ?>
                            <ul class="plan-card__list">
                                <?php
                                if (have_rows('starter_kit_plan_service_list')) { ?>
                                    <?php while (have_rows('starter_kit_plan_service_list')) {
                                        the_row();
                                        $enable_service = get_sub_field('starter_kit_enable_service');
                                        $service_list_item = get_sub_field('starter_kit_service_list_item');
                                        $list_class = ($enable_service) ? '' : 'disabled';
                                    ?>
                                        <li class="<?php echo $list_class; ?>"><?php echo $service_list_item; ?></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>