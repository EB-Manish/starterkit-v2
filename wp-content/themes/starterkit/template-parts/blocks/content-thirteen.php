<?php

/**
 * Block Name: Content Thirteen
 *
 * This is the template that displays the Content Thirteen.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'content-thirteen' . $block['id'];

//Check for section padding
$section_padding = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');


//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {

    $title = get_field('starter_kit_title');

?>
    <section id="<?php echo $id; ?>" class="section section-content section-content-thirteen <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container content-background">
            <div class="row text-center">
                <?php
                while (have_rows('stater_kit_column_details')) {
                    the_row();
                    $sign = get_sub_field('starter_kit_choose_sign');
                    $number = get_sub_field('starter_kit_number');
                    $title = get_sub_field('starter_kit_title');
                    if ($sign == 'plus') {
                        $sign_value = '+';
                    }
                    if ($sign == 'minus') {
                        $sign_value = "-";
                    }
                ?>
                    <div class="col-md-3 item">
                        <?php if ($number != '') { ?>
                            <h1 class="text-white"><span><?php echo $sign_value; ?></span><span class="counter-num"><?php echo $number; ?></span></h1>
                        <?php } ?>
                        <?php if ($title != '') { ?>
                            <p class="text-white"><?php echo $title; ?></p>
                        <?php } ?>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    </section>
<?php } ?>