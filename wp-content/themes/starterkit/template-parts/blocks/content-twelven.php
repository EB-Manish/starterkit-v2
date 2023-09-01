<?php

/**
 * Block Name: Content Twelven
 *
 * This is the template that displays the Content Tweven.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'content-twelven' . $block['id'];

//Check for section padding
$section_padding = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');


//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $title = get_field('starter_kit_title');

?>
    <section id="<?php echo $id; ?>" class="section section-content section-content-twelven <?php echo $padding_type . '' . $padding; ?>">
        <div class="container">
            <div class="row text-center">
                <?php if ($title != '') { ?>
                    <div class="section-heading">
                        <h2 class="section-heading__title mx-auto"><?php echo $title; ?></h2>
                    </div>
                <?php } ?>
                <?php
                while (have_rows('stater_kit_column_details')) {
                    the_row();
                    $sign = get_sub_field('starter_kit_choose_sign');
                    $percent = get_sub_field('starter_kit_percentage');
                    $title = get_sub_field('starter_kit_title');
                    if ($sign == 'plus') {
                        $sign_value = '+';
                    }
                    if ($sign == 'minus') {
                        $sign_value = "-";
                    }
                ?>
                    <div class="col-md-3 item">
                        <?php if ($percent != '') { ?>
                            <h1><span><?php echo $sign_value; ?></span><span class="counter-num"><?php echo $percent; ?></span>%</h1>
                        <?php } ?>
                        <?php if ($title != '') { ?>
                            <p><?php echo $title; ?></p>
                        <?php } ?>
                    </div>
                <?php
                } ?>
            </div>
        </div>
    </section>
<?php } ?>