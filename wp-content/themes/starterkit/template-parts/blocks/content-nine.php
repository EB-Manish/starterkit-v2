<?php

/**
 * Block Name: Content Nine
 *
 * This is the template that displays the content nine block.
 */

// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$id = 'content-nine' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';


//Check for section padding
$section_padding  = get_field('starter_kit_section_padding');
$padding = (!empty($section_padding) ? implode(' ', $section_padding) : '');

$padding_type  = get_field('starter_kit_padding_type');


//Check if section is enable or disable
$section_enable = get_field('starter_kit_enable_section');
if ($section_enable) {
?>
    <section id="<?php echo $id; ?>" class="section section-content-nine <?php echo $padding_type . ' ' . $padding; ?>">
        <div class="container">
            <div class="row">
                <?php while (have_rows('starter_kit_details')) {
                    the_row();
                    $title = get_sub_field('starter_kit_title');
                    $description = get_sub_field('starter_kit_description');
                    $link = get_sub_field('starter_kit_link');
                ?>
                    <div class="col-12 col-md-6 ">
                        <div class="content">
                            <?php if ($title != '') { ?>
                                <h5 class="title"><?php echo $title; ?></h5>
                            <?php } ?>
                            <div class="desc">
                                <?php if ($description != '') { ?>
                                    <?php echo $description; ?>
                                <?php } ?>
                            </div>
                            <?php if ($link != '') { ?>
                                <div class="btn-wrapper">
                                    <a href="<?php echo $link['url'] ?>" <?php if ($link['target']) { ?>target="_blank" <?php } ?>>
                                        <?php echo $link['title'] ? $link['title'] : 'Read More'; ?>
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