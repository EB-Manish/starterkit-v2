<?php

/**
 * Block Name: Testimonial Six
 *
 * This is the template that displays the Testimonial Six
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'testimonial-six-' . $block['id'];

//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $title = get_field('starter_kit_title');
    $text_position = get_field('starter_kit_text_position');
    $text_pos_class = ($text_position == 'right') ? $text_pos_class = 'order-md-1' : '';

?>
    <section id="<?php echo $id; ?>" class="section section-testimonial section-testimonial-six <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-md-6 <?php echo $text_pos_class; ?> ">
                    <div class="section-heading">
                        <?php if ($title != '') { ?>
                            <h2 class=" h1 section-heading__title"><?php echo $title; ?></h1>
                            <?php } ?>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row">
                        <?php while (have_rows('starter_kit_details')) {
                            the_row();
                            $name = get_sub_field('starter_kit_image');
                            $description = get_sub_field('starter_kit_description');
                            $image = get_sub_field('starter_kit_image');
                            $position = get_sub_field('starter_kit_position');
                            $name = get_sub_field('starter_kit_name');
                        ?>
                            <div class="col-12 testimonial ">
                                <div class=" border  p-5">
                                    <?php if ($description != '') { ?>
                                        <h3 class=" h5 testimonial__heading"><?php echo $description; ?></h3>
                                    <?php } ?>
                                    <div class="testimonial-content  d-flex align-items-center">
                                        <div class="testimonial-content__image">
                                            <?php if ($image != '') {
                                            ?>
                                                <figure class="m-0"><img class="rounded-circle mx-auto object-fit-cover " src="<?php echo $image['url']; ?>" alt="<?php starterkit_alt($image) ?>" /></figure>
                                            <?php } else {
                                            ?>
                                                <figure class="m-0"><img class="rounded-circle mx-auto object-fit-cover " src="<?php echo STARTERKIT_IMAGES_DIR; ?>/user.svg" alt="<?php starterkit_alt($image) ?>" /></figure>
                                            <?php } ?>
                                        </div>
                                        <div class="testimonial-content__info">
                                            <?php if ($name != '') {
                                            ?>
                                                <p class="testimonial-content__info__name m-0"><?php echo $name; ?></p>
                                            <?php  }
                                            ?>
                                            <?php if ($position != '') {
                                            ?>
                                                <p class=" testimonial-content__info__position  m-0"><?php echo $position; ?></p>
                                            <?php  }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
    </section>
<?php } ?>