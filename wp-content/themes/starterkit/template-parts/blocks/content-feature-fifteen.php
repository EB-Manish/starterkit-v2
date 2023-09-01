<?php

/**
 * Block Name: Feature Fifteen
 *
 * This is the template that displays the Feature Fifteen.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'feature-fifteen-' . $block['id'];

//Check for section padding
$section_padding = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');


//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $title = get_field('starter_kit_title');
        ?>
    <section class="section section-features section-features-15 <?php echo $padding_type . ' ' . $padding; ?> ">
        <div class="features-lists">
            <div class="container">
                    <div class="content">
                    <?php if ($title != '') { ?>
                                <h4 class="content__title text-center"><?php echo $title; ?></h4>
                     <?php } ?>
                    </div>
                    <div class="features-lists__icon">
                    <?php while (have_rows('starter_kit_feature_details')) {
                        the_row();
                        $logo = get_sub_field('starter_kit_logo');
                        ?>
                        <div class="icons d-inline-block">
                            <?php if ($logo != "") { ?>
                                <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt'] ? $logo['alt'] : $logo['title']); ?>"/>
                            <?php } ?>
                    </div>
                    <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>