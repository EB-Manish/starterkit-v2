<?php

/**
 * Block Name: Feature Ten to Eleven
 *
 * This is the template that displays the Feature Ten to Eleven block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'feature-seven-' . $block['id'];

//Check for section padding
$section_padding = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');


//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $choose_column_type = get_field('starter_kit_column_type');
    if ($choose_column_type == 'three-column') {
        $col_class = 'col-md-4';
    }
    if ($choose_column_type == 'four-column') {
        $col_class = 'col-md-3';
    }

?>
    <section class="section section-features-counter <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="counter-lists">
            <div class="container">
                <div class="row">
                    <?php while (have_rows('starter_kit_feature_details')) {
                        the_row();
                        $counter = get_sub_field('starter_kit_counter');
                        $title = get_sub_field('starter_kit_title');
                        $description = get_sub_field('starter_kit_description');

                    ?>
                        <div class="<?php echo $col_class; ?>">
                            <div class="counter-lists__item">
                                <div class="stats">
                                    <?php if ($counter != '') { ?>
                                        <?php echo $counter; ?>
                                    <?php } ?>
                                </div>
                                <div class=" content">
                                    <?php if ($title != '') { ?>
                                        <h5 class="content__title"><?php echo $title; ?></h5>
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