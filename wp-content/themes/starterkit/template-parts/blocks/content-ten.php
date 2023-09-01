<?php

/**
 * Block Name: Content Ten
 *
 * This is the template that displays the Content Ten block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// Create id attribute allowing for custom "anchor" value.
$id = 'content-section-four-' . $block['id'];
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
    $image = get_field('starter_kit_image_1');
    $image2 = get_field('starter_kit_image_2');
    $image3 = get_field('starter_kit_image_3');
    $link = get_field('starter_kit_link');

?>
    <section id="<?php echo $id; ?>" class="section section-content-ten <?php echo 'img-' . $image_position . ' ' . $padding_type . ' ' . $padding; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-12 ">
                    <div class="row">
                        <div class="col-12 section-content-ten-img-1">
                            <?php if ($image != '') { ?>
                                <img class="column-image-1" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ? $image['alt'] : $image['title']; ?>;">
                            <?php } ?>
                        </div>
                        <div class="col-12 ">
                            <div class="row section-content-ten-second-row">
                                <div class="col-12 col-md-6 section-content-ten-img-2 ">
                                    <?php if ($image2 != '') { ?>
                                        <img src="<?php echo $image2['url']; ?>" alt="<?php echo $image2['alt'] ? $image['alt'] : $image2['title']; ?>;">
                                    <?php } ?>
                                </div>
                                <div class="col-12 col-md-6 section-content-ten-link">
                                    <div class="section-content-ten-link-box">
                                        <?php if ($link != '') { ?>
                                            <h4><a class="column-link" href="<?php echo $link['url'] ?>" <?php if ($link['target']) { ?>target="_blank" <?php } ?>>
                                                    <?php echo $link['title'] ? $link['title'] : 'Read More'; ?></a></h4>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 section-content-ten-img-3">
                    <?php if ($image3 != '') { ?>
                        <img class="column-image-3" src="<?php echo $image3['url']; ?>" alt="<?php echo $image3['alt'] ? $image3['alt'] : $image3['title']; ?>;">
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

<?php } ?>