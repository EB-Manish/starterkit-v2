<?php

/**
 * Block Name: Feature One TO Six
 *
 * This is the template that displays the Feature One to Six.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'feature-one-' . $block['id'];

//Check for section padding
$section_padding = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type = get_field('starter_kit_padding_type');


//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $choose_column_type = get_field('starter_kit_column_type');
    $icon_position = get_field('icon_position');
    //choosing for column type
    if ($choose_column_type == 'two-column') {
        $col_class = 'col-md-6';
        $col = 2; //for icon style
    }
    if ($choose_column_type == 'three-column') {
        $col_class = 'col-md-4';
    }
    if ($choose_column_type == 'four-column') {
        $col_class = 'col-md-3';
    }
    //for icon position top or left for 2 column
    if ($col == 2) {
        if ($icon_position == 'left') {
            $icon_left_pos = 'section-features--left-icon';
        } else {
            $icon_left_pos = '';
        }
    }
    ?>
    <section class="section section-features <?php echo $icon_left_pos . ' ' . $padding_type . ' ' . $padding; ?> ">
        <div class="features-lists">
            <div class="container">
                <div class="row">
                    <?php while (have_rows('starter_kit_feature_details')) {
                        the_row();
                        $icon = get_sub_field('starter_kit_icon');
                        $title = get_sub_field('starter_kit_title');
                        $description = get_sub_field('starter_kit_description');
                            ?>
                                <div class="<?php echo $col_class; ?>">
                                    <div class="features-lists__item text-center text-md-start">
                                        <div class="icon">
                                            <?php if ($icon != "") { ?>
                                                    <figure>
                                                        <img src="<?php echo esc_url($icon['url']); ?>"
                                                alt="<?php echo esc_attr($icon['alt'] ? $icon['alt'] : $icon['title']); ?>" />
                                        </figure>
                                    <?php } ?>
                                </div>
                                <div class="content">
                                    <?php if ($title != '') { ?>
                                        <h4 class="content__title">
                                            <?php echo $title; ?>
                                        </h4>
                                    <?php } ?>
                                    <?php if ($description != '') { ?>
                                        <div class="content__desc">
                                            <?php echo $description; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>