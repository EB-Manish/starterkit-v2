<?php

/**
 * Block Name: Two Column CTA Four 
 *
 * This is the template that displays the Two Column CTA Four block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'two-col-cta-five- ' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';


//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');

$padding_type  = get_field('starter_kit_padding_type');


//Check if section is enable or disable
$section_enable = get_field('starterkit_enable_section');
if ($section_enable) {
?>
    <section id="<?php echo $id; ?>" class="section section-two-col-cta <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container">
            <div class="row">
                <?php while (have_rows('starterkit_two_column_cta')) {
                    the_row();
                    $icon = get_sub_field('starterkit_section_icon');
                    $title = get_sub_field('starterkit_section_title');
                    $description = get_sub_field('starterkit_section_description');
                    $link = get_sub_field('starterkit_section_link');
                    $bg_color = get_sub_field('starterkit_background_color');
                    $bg = '';
                    if ($bg_color) {
                        $bg = 'gray';
                    }
                ?>
                    <div class="col-12 col-md-6 <?php echo  $bg; ?> ">
                        <div class="content">
                            <?php if ($icon != '') { ?>
                                <div class="content__icon">
                                    <img src="<?php echo  $icon['url']; ?>" alt="<?php starterkit_alt($icon); ?>" class="w-100">

                                </div>
                            <?php } ?>
                            <?php if ($title != '') { ?>
                                <h4 class="content__title"><?php echo $title; ?></h4>
                            <?php } ?>
                            <div class="content__desc">
                                <?php if ($description != '') { ?>
                                    <?php echo $description; ?>
                                <?php } ?>
                            </div>
                            <?php if ($link != '') { ?>
                                <div class="btn-wrapper">
                                    <a href="<?php echo $link['url'] ?>" class="btn btn-link has-icon-right " <?php if ($link['target']) { ?>target="_blank" <?php } ?>>
                                        <?php echo $link['title'] ? $link['title'] : 'Read More'; ?><span class="icon-right"></span>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>