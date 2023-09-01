<?php

/**
 * Block Name: Hero Section Eight
 *
 * This is the template that displays the Hero section eight
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'hero-section-eight-' . $block['id'];

//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $image = get_field('starter_kit_image');
    $title = get_field('starter_kit_title');
    $description = get_field('starter_kit_subtitle');
    $video_type = get_field('starter_kit_video_type');
    $video_url = get_field('starter_kit_video_url');
    $video_upload = get_field('starter_kit_video_upload');
    $link = get_field('starter_kit_button');
    $enable_page_down = get_field('starter_kit_enable_page_down');
    $video_position = get_field('starter_kit_video_position');
    $vid_pos_class = ($video_position == 'right') ? $vid_pos_class = 'order-md-1' : '';

?>
    <section id="<?php echo $id; ?>" class="section section-hero section-hero-eight <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <?php if ($image != '') { ?>
                    <div class="col-12 col-md-6 section-col-vid mb-3 mb-md-0 d-flex justify-content-center <?php echo $vid_pos_class; ?>">
                        <div class="section-content">
                            <img class="" src="<?php echo $image['url']; ?>" alt="<?php starterkit_alt($image) ?>">
                            <div class="btn-wrapper">
                                <button type="button" id="video-popup" class="video-popup" data-bs-toggle="modal" data-bs-target="#halfVideoModel">
                                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M32 0C14.3547 0 0 14.3547 0 32C0 49.6453 14.3547 64 32 64C49.6453 64 64 49.6453 64 32C64 14.3547 49.6453 0 32 0ZM24 45.3333V18.6667L45.3333 32L24 45.3333Z" fill="#3C434A" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($title != '' || $description != '') { ?>
                    <div class="col-12 col-md-5 section-heading">
                        <?php if ($title != '') { ?>
                            <h1 class="section-heading__title"><?php echo $title; ?></h1>
                        <?php } ?>
                        <?php if ($description != '') { ?>
                            <div class="section-heading__desc mg-4 large"><?php echo $description; ?></div>
                        <?php } ?>
                        <?php if ($link != '') { ?>
                            <div class="section-heading__btn btn-wrapper">
                                <a href="<?php echo $link['url'] ?>" class="btn btn-primary" <?php starterkit_target($link) ?>>
                                    <?php echo $link['title'] ? $link['title'] : 'Read More'; ?>
                                </a>
                            </div>
                        <?php } ?>
                        <?php if ($enable_page_down) { ?>
                            <button class="page-down">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.0001 29.3333C23.3639 29.3333 29.3334 23.3638 29.3334 16C29.3334 8.63619 23.3639 2.66666 16.0001 2.66666C8.63629 2.66666 2.66675 8.63619 2.66675 16C2.66675 23.3638 8.63629 29.3333 16.0001 29.3333Z" stroke="#3C434A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10.6667 16L16.0001 21.3333L21.3334 16" stroke="#3C434A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16 10.6667L16 21.3333" stroke="#3C434A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="halfVideoModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
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
    </section>
<?php } ?>