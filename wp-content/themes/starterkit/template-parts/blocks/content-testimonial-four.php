<?php

/**
 * Block Name: testimonial Four
 *
 * This is the template that displays the Testimonial Four Block
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'testimonial-four-' . $block['id'];

//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $image = get_field('starter_kit_image');
    $description = get_field('starter_kit_description');
    $name = get_field('starter_kit_name');
    $image_position = get_field('starter_kit_image_position');
    $logo = get_field('starter_kit_logo');
    $img_pos_class = ($image_position == 'right') ? $img_pos_class = 'order-md-1' : '';

?>
    <section id="<?php echo $id; ?>" class="section section-testimonial section-testimonial-four <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container">
            <div class="row justify-content-between ">
                <?php if ($image != '') { ?>
                    <div class="col-12 col-md-6 section-col-img mb-3 mb-md-0 <?php echo $img_pos_class; ?>">
                        <div class="testimonial-img-wrap">
                            <img class="w-100" src="<?php echo $image['url']; ?>" alt="<?php starterkit_alt($image) ?>">
                        </div>
                    </div>
                <?php } ?>
                <?php if ($title != '' || $description != '') { ?>
                    <div class="col-12 col-md-6 ">
                        <div class="section-heading">
                            <?php if ($description != '') { ?>
                                <div class="h3 section-heading__title large"><?php echo $description; ?></div>
                            <?php } ?>
                            <?php if ($name != '') { ?>
                                <div class="section-heading__name mg-4 large"><?php echo $name; ?></div>
                            <?php } ?>
                            <?php if ($logo != '') { ?>
                                <div class="client-logo">
                                    <img class="w-100" src="<?php echo $logo['url']; ?>" alt="<?php starterkit_alt($logo) ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>