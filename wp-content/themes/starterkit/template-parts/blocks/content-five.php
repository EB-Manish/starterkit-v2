<?php

/**
 * Block Name: Content Section One
 *
 * This is the template that displays the Content Section One block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// Create id attribute allowing for custom "anchor" value.
$id = 'content-section-one-' . $block['id'];
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
    $image_position = get_field('starter_kit_position');
    $image = get_field('starter_kit_image');
    $title = get_field('starter_kit_title');
    $description = get_field('starter_kit_description');
    $link = get_field('starter_kit_link');
    $img_pos_class = ($image_position == 'right') ? $img_pos_class = 'order-md-1' : '';
?>
    <section id="<?php echo $id; ?>" class="section section-content-five <?php echo 'img-' . $image_position . ' ' . $padding_type . ' ' . $padding; ?>">
        <div class="row justify-content-between align-items-center">
            <?php if ($image != '') { ?>
                <div class="col-12 col-md-7 section-col-img mb-3 mb-md-0 <?php echo $img_pos_class; ?>">
                    <div class="img-wrap">
                        <img src="<?php echo $image['url']; ?>" alt="<?php starterkit_alt($image) ?>">
                    </div>
                </div>
            <?php } ?>

            <?php if ($title != '' || $description != '') { ?>
                <div class="col-12 col-md-5 section-heading">
                    <div>
                        <?php if ($title != '') { ?>
                            <h3 class="section-heading__title"><?php echo $title; ?></h3>
                        <?php } ?>
                        <?php if ($description != '') { ?>
                            <div class="section-heading__desc mg-4 large"><?php echo $description; ?></div>
                        <?php } ?>
                        <?php if ($link != '') { ?>
                            <div class="section-heading__btn btn-wrapper">
                                <a href="<?php echo $link['url'] ?>" class="btn btn-outline-primary" <?php starterkit_target($link) ?>>
                                    <?php echo $link['title'] ? $link['title'] : 'Read More'; ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>