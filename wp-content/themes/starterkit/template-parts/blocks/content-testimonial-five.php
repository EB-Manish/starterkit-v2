<?php

/**
 * Block Name: Testimonial Five
 *
 * This is the template that displays Testimonial Five block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'testimonial-five-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';


//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');

$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $title = get_field('starter_kit_title');
?>
    <section id="<?php echo $id; ?>" class="section section-testimonial section-testimonial-five <?php echo $padding_type . ' ' . $align_class . ' ' . $padding; ?>">
        <div class="container">
            <div class="section-heading">
                <?php if ($title != '') { ?>
                    <h2 class="h5 text-center section-heading__title  "><?php echo $title; ?></h2>
                <?php } ?>
            </div>
            <div class="row justify-content-center text-center">
                <div class="col-lg-7 testimonial-wrap">
                    <div class="testimonial-single-five swiper mySwiper2">
                        <div class="swiper-wrapper ">
                            <?php while (have_rows('starter_kit_details_columns')) {
                                the_row();
                                $description = get_sub_field('starter_kit_description');
                            ?>
                                <div class="testimonial-single-five__item swiper-slide">
                                    <?php if ($description != '') {
                                    ?>
                                        <div class="desc">
                                            <h3 class="h4"><?php echo $description; ?></h3>
                                        </div>
                                    <?php  }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-single-five-nav swiper  mySwiper">
                <div class="swiper-wrapper ">
                    <?php while (have_rows('starter_kit_details_columns')) {
                        the_row();
                        $image = get_sub_field('starter_kit_image');
                    ?>
                        <div class="testimonial-single-five-nav__item swiper-slide">
                            <?php if ($image != '') {
                            ?>
                                <img src="<?php echo $image['url']; ?>" alt="<?php starterkit_alt($image) ?>">
                            <?php  }
                            ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="pagination-arrow-wrap d-md-none">
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination mt-5"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>