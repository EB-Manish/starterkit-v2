<?php

/**
 * Block Name: Content Testimonial Two
 *
 * This is the template that displays the Testimionial Section Two block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// Create id attribute allowing for custom "anchor" value.
$id = 'testimonial-two-' . $block['id'];
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
    $testimonial_title = get_field('starter_kit__testimonials_title');
?>
    <section id="<?php echo $id; ?>" class="section section-testimonial-two <?php echo $className . ' ' . $padding_type . ' ' . $padding; ?>">
        <div class="container">
            <?php if ($testimonial_title != '') {
            ?>
                <div class="section-title">
                    <h5 class="text-light text-center"><?php echo $testimonial_title; ?></h5>
                </div>
            <?php }
            ?>
            <div class="testimonial-single-two swiper">
                <div class="swiper-wrapper ">
                    <?php while (have_rows('starter_kit_testimonial_content')) {
                        the_row();
                        $name = get_sub_field('starter_kit_testimonial_content_name');
                        $description = get_sub_field('starter_kit_testimonial_content_description');
                        $image = get_sub_field('starter_kit_testimonial_content_image');
                        $position = get_sub_field('starter_kit_testimonial_content_position');
                    ?>
                        <div class="testimonial-single-two__item swiper-slide">
                            <?php if ($description != '') {
                            ?>
                                <div class="desc">
                                    <?php echo $description; ?>
                                </div>
                            <?php  }
                            ?>
                            <div class="author d-flex align-items-center">
                                <?php if ($image != '') {
                                ?>
                                    <figure class="figure">
                                        <img class="rounded-circle" width="100" height="100" src="<?php echo $image['url']; ?>" alt="<?php starterkit_alt($image) ?>" />
                                    </figure>
                                <?php }
                                ?>
                                <div class="author-info">
                                    <?php if ($name != '') {
                                    ?>
                                        <h6 class=" author-info__name"><?php echo $name; ?><h6>
                                            <?php  } ?>
                                            <?php if ($position != '') {
                                            ?>
                                                <h6 class="text-light author-info__position"><?php echo $position; ?></h6>
                                            <?php  }
                                            ?>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                    </div>
                    <div class="pagination-arrow-wrap">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination mt-5"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
    </section>
<?php } ?>