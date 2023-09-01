<?php

/**
 * Block Name: Testimonial Seven
 *
 * This is the template that displays the Testimonial Seven
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'testimonial-seven-' . $block['id'];

//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $title = get_field('starter_kit_title');
?>
    <section id="<?php echo $id; ?>" class="section section-testimonial section-testimonial-seven <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container ">
            <div class="row">
                <div class="col-md-6 col-lg-5 col-xxl-4">
                    <div class="section-heading">
                        <?php if ($title != '') { ?>
                            <h2 class="h3 section-heading__title"><?php echo $title; ?></h2>
                        <?php  } ?>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-seven  swiper">
                        <div class="swiper-wrapper">
                            <?php if (have_rows('starter_kit_details')) {
                                $count = 1;
                            ?>
                                <?php while (have_rows('starter_kit_details')) {
                                    the_row();
                                    $video_image = get_sub_field('starter_kit_video_image');
                                    $video_type = get_sub_field('starter_kit_video_type');
                                    $video_url = get_sub_field('starter_kit_video_url');
                                    $video_upload = get_sub_field('starter_kit_video_upload');
                                    $description = get_sub_field('starter_kit_description');
                                    $user_image = get_sub_field('starter_kit_user_image');
                                    $name = get_sub_field('starter_kit_name');
                                    $position = get_sub_field('starter_kit_position');
                                    $add_video = get_sub_field('starter_kit_add_video');
                                ?>
                                    <div class="testimonial-seven-item swiper-slide">
                                        <div class="row">
                                            <div class="col-lg-6 col-xl-5 section-col-vid  ">
                                                <div class="image-video-btn">
                                                    <?php if ($video_image != '') { ?>
                                                        <img src="<?php echo $video_image['url']; ?>" alt="<?php starterkit_alt($video_image) ?>" class="w-100 ">
                                                    <?php } else { ?>
                                                        <img src="<?php echo STARTERKIT_IMAGES_DIR . 'placeholder.jpg'; ?>" class="w-100 ">
                                                    <?php } ?>
                                                    <?php if ($add_video != '') { ?>
                                                        <button type="button" id="video-popup" class="video-popup image-video-btn__play" data-bs-toggle="modal" data-bs-target="#halfVideoModel<?php echo $count ?>"></button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-7 ">
                                                <div class="testimonial-content">
                                                    <?php if ($description != '') { ?>
                                                        <div class="testimonial-content__desc"><?php echo $description; ?></div>
                                                    <?php  }  ?>
                                                    <div class="testimonial-content-user d-flex align-items-center">
                                                        <div class="testimonial-content-user-image">
                                                            <?php if ($user_image != '') { ?>
                                                                <figure class="m-0"><img class="rounded-circle object-fit-cover" src="<?php echo $user_image['url']; ?>" alt="<?php starterkit_alt($user_image) ?>" /></figure>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="testimonial-content-user-info">
                                                            <?php if ($name != '') { ?>
                                                                <div class="testimonial-content-user-info__name m-0"><?php echo $name; ?></div>
                                                            <?php  } ?>
                                                            <?php if ($position != '') { ?>
                                                                <p class="testimonial-content-user-info__position m-0"><?php echo $position; ?></p>
                                                            <?php  } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $count++; ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class="pagination-arrow-wrap">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-pagination mt-5"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if (have_rows('starter_kit_details')) {
        $count = 1;
    ?>
        <?php while (have_rows('starter_kit_details')) {
            the_row();
            $video_image = get_sub_field('starter_kit_video_image');
            $video_type = get_sub_field('starter_kit_video_type');
            $video_url = get_sub_field('starter_kit_video_url');
            $video_upload = get_sub_field('starter_kit_video_upload');
        ?>
            <!-- modal -->
            <div class="modal fade" id="halfVideoModel<?php echo $count ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <?php if ($video_type === "url" && $video_url) {
                            echo $video_url;
                        } elseif ($video_type === "upload" && $video_upload) { ?>
                            <video controls>
                                <source src="<?php echo $video_upload["url"]; ?>" type="video/mp4">
                            </video>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php $count++; ?>
    <?php }
    } ?>
<?php } ?>