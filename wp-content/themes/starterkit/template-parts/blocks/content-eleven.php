<?php

/**
 * Block Name: Content Eleven
 *
 * This is the template that displays the Content eleven.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'content-eleven' . $block['id'];

//Check for section padding
$section_padding = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');


//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
?>
    <section id="<?php echo $id; ?>" class="section section-content section-content-eleven <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container">
            <div class="row">
                <?php
                while (have_rows('starter_kit_image_column')) {
                    the_row();
                    $image = get_sub_field('starter_kit_image');
                    $title = get_sub_field('starter_kit_title');
                    $location = get_sub_field('starter_kit_location');
                ?>
                    <div class="col-12 col-md-4 item">
                        <div class="img-wrap">
                            <figure class="mb-0">
                                <img class="w-100" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ? $image['alt'] : $image['title']; ?>;">
                            </figure>
                        </div>
                        <div class="content-wrap">
                            <?php if ($title != '') { ?>
                                <h4><?php echo $title; ?></h4>
                            <?php } ?>
                            <?php if ($location != '') { ?>
                                <p class="location"><?php echo $location; ?></p>
                            <?php } ?>
                        </div>

                    </div>
                <?php
                } ?>
            </div>
        </div>
    </section>
<?php } ?>