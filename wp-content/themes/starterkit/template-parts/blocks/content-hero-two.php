<?php

/**
 * Block Name: Hero Section Two
 *
 * This is the template that displays the Hero section Two
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'hero-section-two-' . $block['id'];

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
    $link = get_field('starter_kit_button');
    $enable_page_down = get_field('starter_kit_enable_page_down');
    $image_position = get_field('starter_kit_image_position');
    $img_pos_class = ($image_position == 'right') ? $img_pos_class = 'order-md-1' : '';

?>
    <section id="<?php echo $id; ?>" class="section section-hero section-hero-two <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <?php if ($image != '') { ?>
                    <div class="col-12 col-md-6 section-col-img mb-3 mb-md-0 <?php echo $img_pos_class; ?>">
                        <div class="img-wrap">
                            <img class="w-100" src="<?php echo $image['url']; ?>" alt="<?php starterkit_alt($image) ?>">
                        </div>
                    </div>
                <?php } ?>

                <?php if ($title != '' || $description != '') { ?>
                    <div class="col-12 col-md-5 section-heading">
                        <?php if ($title != '') { ?>
                            <h1 class="section-heading__title"><?php echo $title; ?></h1>
                        <?php } ?>
                        <?php if ($description != '') { ?>
                            <div class="section-heading__desc mg-4"><?php echo $description; ?></div>
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
    </section>
<?php } ?>