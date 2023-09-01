<?php

/**
 * Block Name: Full Width CTA Two 
 *
 * This is the template that displays the Full Width CTA Two
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'full-width-cta-two-' . $block['id'];

//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');
$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
    $title = get_field('starter_kit_title');
    $description = get_field('starter_kit_subtitle');
    $starter_kit_form_shortcode = get_field('starter_kit_form_shortcode');
?>
    <section id="<?php echo $id; ?>" class="section section-cta  section-cta--two <?php echo  ' ' . $padding_type . ' ' . $padding; ?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-heading text-center">
                        <?php if ($title != '') { ?>
                            <h4 class="section-heading__title"><?php echo $title; ?></h4>
                        <?php } ?>
                        <?php if ($description != '') { ?>
                            <div class="section-heading__desc"><?php echo $description; ?></div>
                        <?php } ?>
                        <?php if (!empty($starter_kit_form_shortcode)) {
                            $shortcode = '[gravityform id="' . $starter_kit_form_shortcode['id'] . '" title="false" description="false" ajax="true"]'; ?>
                            <div class="form-wrapper mt-md-0">
                                <?php echo do_shortcode($shortcode, false); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </section>
<?php } ?>