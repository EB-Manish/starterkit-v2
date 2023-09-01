<?php

/**
 * Block Name: Call To Action Three
 *
 * This is the template that displays the Call To Action Three block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'cta-three-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';


//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');

$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $bg_image = get_field('starter_kit_section_background_image');
    $background_option = get_field('mobile_background_option');
    $block_alignment = get_field('content_block_alignment');
    $icon = get_field('starter_kit_icon');
    $title = get_field('starter_kit_title');
    $description = get_field('starter_kit_description');
    $link = get_field('starter_kit_link');
    $bg_class = 'background-2';
    if ($background_option != 'option_2') {
        $bg_class = 'background-1';
        $background_image = $bg_image ? 'style="background-image: url(' . $bg_image['url'] . '); background-repeat: no-repeat; background-size: cover;"' : '';
    }
?>
    <section id="<?php echo $id; ?>" class="section section-cta-three <?php echo $bg_class; ?> <?php echo $padding_type . ' ' . $align_class . ' ' . $padding; ?>" <?php echo $background_image ? $background_image : ''; ?>>
        <?php if ($background_option === 'option_2') { ?>
            <div class="bg-image">
                <img src="<?php echo $bg_image['url']; ?>" alt="<?php starterkit_alt($bg_image); ?>">
            </div>
        <?php
        } ?>
        <div class="container">
            <div class="row justify-content-start">
                <div class="col-12 col-md-6 col-lg-5<?php echo $block_alignment === 'right' ? ' offset-md-6' : ' offset-lg-1'; ?>">
                    <div class="section-heading bg-white">
                        <?php if ($icon != '') { ?>
                            <div class="section-heading__icon">
                                <img src="<?php echo $icon['url']; ?>" alt="<?php echo starterkit_alt($icon); ?>">
                            </div>
                        <?php } ?>
                        <?php if ($title != '') { ?>
                            <h4 class="h4 section-heading__title"><?php echo $title; ?></h4>
                        <?php } ?>
                        <?php if ($description != '') { ?>
                            <div class="section-heading__desc "><?php echo $description; ?></div>
                        <?php } ?>
                        <?php if ($link != '') { ?>
                            <div class="section-heading__btn btn-wrapper">
                                <a href="<?php echo $link['url'] ?>" class="btn-link bt-lg has-icon-right" <?php starterkit_target($link); ?>>
                                    <?php echo $link['title'] ? $link['title'] : 'Read More'; ?>
                                    <span class="icon"><svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_1533_3596)">
                                                <path d="M9.29 7.21002C8.9 7.60002 8.9 8.23002 9.29 8.62002L13.17 12.5L9.29 16.38C8.9 16.77 8.9 17.4 9.29 17.79C9.68 18.18 10.31 18.18 10.7 17.79L15.29 13.2C15.68 12.81 15.68 12.18 15.29 11.79L10.7 7.20002C10.32 6.82002 9.68 6.82002 9.29 7.21002Z" fill="#2196F3" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_1533_3596">
                                                    <rect width="24" height="24" fill="white" transform="translate(0 0.5)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>