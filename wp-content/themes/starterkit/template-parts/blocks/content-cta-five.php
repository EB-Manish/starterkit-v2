<?php

/**
 * Block Name: Call To Action Five
 *
 * This is the template that displays the Call To Action Five block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'call-to-action-five-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';


//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');

$padding_type  = get_field('starter_kit_padding_type');

//Check if section is enable or disable
$section_enable = get_field('starterkit_enable_section');
if ($section_enable) {
    $title = get_field('starterkit_section_title');
    $link = get_field('starterkit_section_link');
?>
    <section id="<?php echo $id; ?>" class="section section-cta section-cta--five <?php echo $padding_type . ' ' . $align_class . ' ' . $padding; ?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-heading m-auto">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-9 ">
                                <?php if ($title != '') { ?>
                                    <h4 class="h4 section-heading__title"><?php echo $title; ?></h4>
                                <?php } ?>
                            </div>
                            <div class="col-12 col-md-3">
                                <?php if ($link != '') { ?>
                                    <div class="section-heading__btn-wrap btn-wrapper d-flex justify-content-center">
                                        <a href="<?php echo $link['url'] ?>" class="btn btn-primary " <?php starterkit_target($link); ?>>
                                            <?php echo $link['title'] ? $link['title'] : 'Read More'; ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>