<?php

/**
 * Block Name: Feature Sixteen
 *
 * This is the template that displays the Feature One.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'feature-sixteen-' . $block['id'];

//Check for section padding
$section_padding = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');


//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $title = get_field('starter_kit_title');
    $desc = get_field('starter_kit_description');
    $enable_number = get_field('starter_kit_enable_question_number');
?>
    <section class="section section-features-16-17 <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container">
            <div class="section-heading">
                <?php if ($title != '') { ?>
                    <h2 class="section-heading__title h1"><?php echo $title; ?></h2>
                <?php } ?>
                <?php if ($desc != '') { ?>
                    <div class="section-heading__desc">
                        <?php echo $desc; ?>
                    </div>
                <?php } ?>
            </div>
            <?php if (have_rows('starter_kit_faq')) { ?>
                <?php
                $acc_id = substr($block['id'], 6, 5);
                $count = 1;
                ?>
                <div class="accordion accordion-flush starterkit-accordion" id="feature<?php echo $block['id']; ?>">
                    <?php while (have_rows('starter_kit_faq')) {
                        the_row();
                        $faq_question = get_sub_field('starter_kit_question');
                        $faq_answer = get_sub_field('starter_kit_answer');
                    ?>
                        <div class="accordion-item<?php echo $enable_number ? ' has-index' : ''; ?>">
                            <h5 class="accordion-header accordion-button collapsed" id="flush-heading<?php echo $acc_id . '-' . $count; ?>" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $acc_id . '-' . $count; ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $acc_id . '-' . $count; ?>">
                                <span class="index text-light"> <?php if ($enable_number) { ?>
                                        <span class="index text-light">
                                            <?php echo $count <= 10 ? str_pad($count, 2, '0', STR_PAD_LEFT) : $count; ?></span>
                                    <?php } ?>
                                </span> <?php echo $faq_question; ?>
                            </h5>
                            <div id="flush-collapse<?php echo $acc_id . '-' . $count; ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $acc_id . '-' . $count; ?>" data-bs-parent="#feature<?php echo $block['id']; ?>">
                                <div class="accordion-body"><?php echo $faq_answer; ?></div>
                            </div>
                            <?php $acc_id . '-' . $count++; ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>